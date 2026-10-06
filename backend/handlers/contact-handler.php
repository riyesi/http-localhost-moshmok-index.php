<?php
/**
 * Contact form handler — POST JSON → MySQL + emails
 *
 * Expected fields: name, email, phone, service, message, consent
 * Returns: JSON { success: bool, message: string }
 */

header('Content-Type: application/json; charset=utf-8');

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
if (empty($d['message']) || strlen($d['message']) > 5000) {
    $errors[] = 'A message is required (max 5000 chars).';
}
$validServices = ['accounting','tax_audit','advisory','training','other'];
if (!empty($d['service']) && !in_array($d['service'], $validServices, true)) {
    $errors[] = 'Invalid service selection.';
}

if ($errors) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// ── Insert into DB ───────────────────────────────────────────
try {
    $pdo = getDB();
    $sql = "INSERT INTO contact_messages (name, email, phone, service, message, consent, read_status)
            VALUES (:name, :email, :phone, :service, :message, :consent, 'unread')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name'    => $d['name'],
        ':email'   => $d['email'],
        ':phone'   => $d['phone'] ?? '',
        ':service' => $d['service'] ?? '',
        ':message' => $d['message'],
        ':consent' => !empty($d['consent']) ? 1 : 0,
    ]);

    $contactId = (int)$pdo->lastInsertId();

    // ── Capture Unified Lead & Schedule Follow-ups ───────────
    captureLead($pdo, [
        'source_type'      => 'contact',
        'source_id'        => $contactId,
        'full_name'        => $d['name'],
        'email'            => $d['email'],
        'phone'            => $d['phone'] ?? '',
        'service_interest' => 'Enquiry: ' . ($d['service'] ?: 'General Advisory'),
        'message'          => $d['message'],
    ]);

    // ── Send internal practice notification ──────────────────
    $details = "
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Service</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['service']}</td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Phone</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['phone']}</td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Message</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['message']}</td></tr>
    ";
    sendPracticeNotification('Contact Enquiry', $d['name'], $d['email'], $details);

    echo json_encode(['success' => true, 'message' => 'Message sent successfully.']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
