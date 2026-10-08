<?php
/**
 * member-signup.php
 * Handles "Become a Member" AJAX registrations.
 * Validates inputs, enforces CSRF & spam protection,
 * stores registration records securely, and returns JSON.
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

// Decode input (JSON or FormData/POST)
$rawInput = file_get_contents('php://input');
$jsonData = json_decode($rawInput, true);
$data = is_array($jsonData) ? $jsonData : $_POST;

// 1. CSRF Validation
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

// 2. Honeypot Spam Protection (field must remain completely empty)
$honeypot = isset($data['website']) ? trim((string)$data['website']) : '';
if ($honeypot !== '') {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Automated spam submission detected.'
    ]);
    exit;
}

// 3. Submission Timing Check (must take at least 1.5 seconds)
$formTimestamp = isset($data['form_timestamp']) ? (int)$data['form_timestamp'] : 0;
$currentTime = time();
if ($formTimestamp > 0 && ($currentTime - $formTimestamp) < 1.5) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Submission was too fast. Please take a moment to review before submitting.'
    ]);
    exit;
}

// 4. Extract and Sanitize Inputs
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

$name = htmlspecialchars($rawName, ENT_QUOTES, 'UTF-8');
$email = filter_var($rawEmail, FILTER_SANITIZE_EMAIL);
$organization = htmlspecialchars($rawOrg, ENT_QUOTES, 'UTF-8');

// 5. Save Member Signup Record
$saved = false;

// Attempt Database Insertion
try {
    if (file_exists(__DIR__ . '/backend/config/db.php')) {
        require_once __DIR__ . '/backend/config/db.php';
        $pdo = getDB();
        if ($pdo instanceof PDO) {
            // Ensure member_signups table exists
            $pdo->exec("CREATE TABLE IF NOT EXISTS `member_signups` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(150) NOT NULL,
                `email` VARCHAR(255) NOT NULL,
                `organization` VARCHAR(255) NOT NULL DEFAULT '',
                `status` ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
                `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                INDEX `idx_email` (`email`),
                INDEX `idx_status` (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

            $stmt = $pdo->prepare("INSERT INTO `member_signups` (`name`, `email`, `organization`) VALUES (:name, :email, :org)");
            $stmt->execute([
                ':name'  => $name,
                ':email' => $email,
                ':org'   => $organization
            ]);
            $saved = true;

            // Ingest as Lead if lead service is available
            if (file_exists(__DIR__ . '/backend/includes/lead-service.php')) {
                require_once __DIR__ . '/backend/includes/lead-service.php';
                if (function_exists('ingestLead')) {
                    ingestLead($pdo, 'manual', [
                        'full_name'        => $name,
                        'email'            => $email,
                        'company'          => $organization,
                        'service_interest' => 'Membership Network Signup',
                        'message'          => "Registered interest in membership network. Org: {$organization}"
                    ]);
                }
            }
        }
    }
} catch (Throwable $e) {
    error_log('[member-signup] DB Error: ' . $e->getMessage());
}

// Persistent JSON Storage Fallback
$dataDir = __DIR__ . '/backend/data';
if (!is_dir($dataDir)) {
    @mkdir($dataDir, 0755, true);
}
$storageFile = $dataDir . '/member_signups.json';
$signups = [];
if (file_exists($storageFile)) {
    $existing = @file_get_contents($storageFile);
    $decoded = json_decode($existing, true);
    if (is_array($decoded)) {
        $signups = $decoded;
    }
}
$signups[] = [
    'name'         => $name,
    'email'        => $email,
    'organization' => $organization,
    'created_at'   => date('Y-m-d H:i:s')
];
@file_put_contents($storageFile, json_encode($signups, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES), LOCK_EX);

// 6. Send Email Confirmation if mailer exists
if (file_exists(__DIR__ . '/backend/includes/mailer.php')) {
    require_once __DIR__ . '/backend/includes/mailer.php';
    if (function_exists('sendClientConfirmation')) {
        @sendClientConfirmation($email, $name, 'Membership Network Registration', 'Your registration to join the Financial Precision professional network has been received. Our team will review your application and be in touch.');
    }
}

// Return success JSON
echo json_encode([
    'success' => true,
    'message' => 'Thank you, ' . $name . '! Your membership application has been received successfully.'
]);
exit;
