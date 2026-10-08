<?php
/**
 * member-signup.php
 * Handles "Become a Member" AJAX submissions.
 * Validates, sanitizes, enforces honeypot and timing checks,
 * appends new members to members.json, and returns JSON.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');

// Ensure request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'message' => 'Method Not Allowed. Only POST requests are accepted.'
    ]);
    exit;
}

// Decode input (support JSON payload or standard FormData / POST)
$rawInput = file_get_contents('php://input');
$jsonData = json_decode($rawInput, true);
$data = is_array($jsonData) ? $jsonData : $_POST;

// Optional CSRF validation if token exists in session
if (!empty($_SESSION['csrf_token'])) {
    $submittedToken = $data['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!hash_equals($_SESSION['csrf_token'], (string)$submittedToken)) {
        http_response_code(403);
        echo json_encode([
            'success' => false,
            'message' => 'Security token invalid or expired. Please refresh the page and try again.'
        ]);
        exit;
    }
}

// 1. Honeypot Spam Protection (field must remain completely empty)
$honeypot = isset($data['website']) ? trim((string)$data['website']) : '';
if ($honeypot !== '') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Spam verification detected an automated submission.'
    ]);
    exit;
}

// 2. Submission Timing Check (must take > 2 seconds to complete form)
$formTimestamp = isset($data['form_timestamp']) ? (int)$data['form_timestamp'] : 0;
$currentTime = time();
if ($formTimestamp <= 0 || ($currentTime - $formTimestamp) < 2) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Submission was too fast. Please take at least 2 seconds before submitting.'
    ]);
    exit;
}

// 3. Extract and Sanitize Inputs
$rawName  = isset($data['name']) ? trim((string)$data['name']) : '';
$rawEmail = isset($data['email']) ? trim((string)$data['email']) : '';
$rawOrg   = isset($data['organization']) ? trim((string)$data['organization']) : '';

// Validation: Required fields
if ($rawName === '') {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Please provide your full name.'
    ]);
    exit;
}

if ($rawEmail === '' || !filter_var($rawEmail, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'message' => 'Please provide a valid email address.'
    ]);
    exit;
}

// Sanitize inputs using filter_var() and htmlspecialchars()
$name = htmlspecialchars($rawName, ENT_QUOTES, 'UTF-8');
$email = filter_var($rawEmail, FILTER_SANITIZE_EMAIL);
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$organization = htmlspecialchars($rawOrg, ENT_QUOTES, 'UTF-8');

// 4. Append Member to members.json
$jsonPath = __DIR__ . '/members.json';
$members = [];

if (file_exists($jsonPath)) {
    $existingRaw = @file_get_contents($jsonPath);
    $decoded = json_decode($existingRaw, true);
    if (is_array($decoded)) {
        $members = $decoded;
    }
}

// Construct member entry
$displayName = $organization !== '' ? "$name ($organization)" : $name;
$newMember = [
    'name'         => $displayName,
    'logo'         => 'assets/logos/partner.png', // Default member tile
    'url'          => '',
    'email'        => $email,
    'organization' => $organization,
    'date_joined'  => date('Y-m-d H:i:s')
];

$members[] = $newMember;

// Write back to members.json with atomic lock
$encoded = json_encode($members, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
if (@file_put_contents($jsonPath, $encoded, LOCK_EX) === false) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Unable to save membership record. Please try again later.'
    ]);
    exit;
}

// Success response
echo json_encode([
    'success' => true,
    'message' => 'Thank you, ' . $name . '! Your membership registration has been received successfully.'
]);
exit;
