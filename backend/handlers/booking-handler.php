<?php
/**
 * Booking form handler — POST JSON → MySQL + emails
 *
 * Expected fields: name, email, phone, consultation_type, preferred_date, preferred_time, message
 * Returns: JSON { success: bool, message: string }
 */

header('Content-Type: application/json; charset=utf-8');

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/validate.php';
require_once __DIR__ . '/../includes/sanitize.php';
require_once __DIR__ . '/../includes/mailer.php';
require_once __DIR__ . '/../includes/lead-service.php';

// ── Read input ───────────────────────────────────────────────
$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) {
    // Fallback to form-urlencoded
    $data = $_POST;
}

if (empty($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No data received.']);
    exit;
}

// ── Sanitise ─────────────────────────────────────────────────
$d = sanitizeArray($data);

// ── CSRF Validation ──────────────────────────────────────────
$csrfToken = $d['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
if (!verifyCsrfToken($csrfToken)) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Security validation failed (invalid or expired session token). Please refresh the page and try again.'
    ]);
    exit;
}

// ── Validate ─────────────────────────────────────────────────
$errors = [];

if (empty($d['name']) || strlen($d['name']) > 100) {
    $errors[] = 'Name is required (max 100 chars).';
}
if (!isValidEmail($d['email'] ?? '')) {
    $errors[] = 'A valid email address is required.';
}
if (!empty($d['phone']) && !isValidPhone($d['phone'])) {
    $errors[] = 'Phone number format is invalid.';
}
$validTypes = ['tax_compliance','audit_review','financial_advisory','accounting_setup','training_enquiry','general'];
if (empty($d['consultation_type']) || !in_array($d['consultation_type'], $validTypes, true)) {
    $errors[] = 'Please select a consultation type.';
}
if (!empty($d['preferred_date']) && !isValidFutureDate($d['preferred_date'])) {
    $errors[] = 'Preferred date must be today or later.';
}
if (!empty($d['preferred_time']) && !isValidTime($d['preferred_time'])) {
    $errors[] = 'Preferred time format is invalid.';
}

if ($errors) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// ── Insert into DB ───────────────────────────────────────────
try {
    $pdo = getDB();
    $sql = "INSERT INTO bookings (name, email, phone, service_type, preferred_date, preferred_time, message, status)
            VALUES (:name, :email, :phone, :service_type, :preferred_date, :preferred_time, :message, 'pending')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name'             => $d['name'],
        ':email'            => $d['email'],
        ':phone'            => $d['phone'] ?? '',
        ':service_type'     => $d['consultation_type'],
        ':preferred_date'   => !empty($d['preferred_date']) ? $d['preferred_date'] : null,
        ':preferred_time'   => $d['preferred_time'] ?? '',
        ':message'          => $d['message'] ?? null,
    ]);

    $bookingId = (int)$pdo->lastInsertId();

    // ── Capture Unified Lead & Schedule Follow-ups ───────────
    captureLead($pdo, [
        'source_type'      => 'booking',
        'source_id'        => $bookingId,
        'full_name'        => $d['name'],
        'email'            => $d['email'],
        'phone'            => $d['phone'] ?? '',
        'service_interest' => 'Consultation: ' . $d['consultation_type'],
        'message'          => $d['message'] ?? '',
    ]);

    // ── Send internal practice notification ──────────────────
    $notesHtml = !empty($d['message']) ? $d['message'] : '—';
    $details = "
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Type</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['consultation_type']}</td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Date</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['preferred_date']}</td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Time</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['preferred_time']}</td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Phone</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['phone']}</td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Notes</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$notesHtml}</td></tr>
    ";
    sendPracticeNotification('Booking', $d['name'], $d['email'], $details);

    echo json_encode(['success' => true, 'message' => 'Booking request submitted successfully.']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
