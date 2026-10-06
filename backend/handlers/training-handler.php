<?php
/**
 * Training sign-up handler — POST JSON → MySQL + emails
 *
 * Expected fields: first-name, last-name, email, phone, company, designation, course, message
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

if (empty($d['first-name']) || strlen($d['first-name']) > 100) {
    $errors[] = 'First name is required (max 100 chars).';
}
if (empty($d['last-name']) || strlen($d['last-name']) > 100) {
    $errors[] = 'Last name is required (max 100 chars).';
}
if (!isValidEmail($d['email'] ?? '')) {
    $errors[] = 'A valid email address is required.';
}
if (!empty($d['phone']) && !isValidPhone($d['phone'])) {
    $errors[] = 'Phone number format is invalid.';
}

$validCourses = [
    'tax-compliance', 'statistical-techniques', 'financial-reporting',
    'aml', 'internal-audit', 'corporate-governance',
];
if (empty($d['course']) || !in_array($d['course'], $validCourses, true)) {
    $errors[] = 'Please select a valid course.';
}

if ($errors) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// ── Insert into DB ───────────────────────────────────────────
try {
    $pdo = getDB();
    $sql = "INSERT INTO training_signups (first_name, last_name, email, phone, company, designation, course, message, status)
            VALUES (:first_name, :last_name, :email, :phone, :company, :designation, :course, :message, 'pending')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':first_name' => $d['first-name'],
        ':last_name'  => $d['last-name'],
        ':email'      => $d['email'],
        ':phone'      => $d['phone'] ?? '',
        ':company'    => $d['company'] ?? '',
        ':designation'=> $d['designation'] ?? '',
        ':course'     => $d['course'],
        ':message'    => $d['message'] ?? null,
    ]);

    $signupId = (int)$pdo->lastInsertId();
    $fullName = $d['first-name'] . ' ' . $d['last-name'];

    // ── Capture Unified Lead & Schedule Follow-ups ───────────
    captureLead($pdo, [
        'source_type'      => 'training',
        'source_id'        => $signupId,
        'full_name'        => $fullName,
        'email'            => $d['email'],
        'phone'            => $d['phone'] ?? '',
        'service_interest' => 'Training: ' . $d['course'],
        'company'          => $d['company'] ?? '',
        'message'          => $d['message'] ?? '',
    ]);

    // ── Send internal practice notification ──────────────────
    $details = "
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Course</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['course']}</td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Company</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['company']}</td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Designation</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['designation']}</td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Phone</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$d['phone']}</td></tr>
    ";
    sendPracticeNotification('Training Sign-up', $fullName, $d['email'], $details);

    echo json_encode(['success' => true, 'message' => 'Training sign-up submitted successfully.']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
