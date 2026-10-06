<?php
/**
 * Document upload handler — multipart/form-data → MySQL + filesystem
 *
 * Expected fields: name, email, notes, fee_acknowledge (checkbox), documents[] (files)
 * Returns: JSON { success: bool, message: string, upload_id?: int }
 *
 * R200 FEE: Submission is recorded with fee_status = 'pending'.
 * A payment gateway insertion point is provided below.
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

// ── Config ───────────────────────────────────────────────────
define('UPLOAD_DIR', __DIR__ . '/../uploads/');
define('MAX_FILE_SIZE', 25 * 1024 * 1024);   // 25 MB per file
define('MAX_FILES', 10);                       // max files per submission

// Ensure upload directory exists and is not web-accessible
if (!is_dir(UPLOAD_DIR)) {
    mkdir(UPLOAD_DIR, 0750, true);
}

// ── CSRF Validation ──────────────────────────────────────────
$csrfToken = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
if (!verifyCsrfToken($csrfToken)) {
    http_response_code(403);
    echo json_encode([
        'success' => false,
        'message' => 'Security validation failed (invalid or expired session token). Please refresh the page and try again.'
    ]);
    exit;
}

// ── Validate inputs ──────────────────────────────────────────
$name  = isset($_POST['name'])  ? sanitizeString($_POST['name'])  : '';
$email = isset($_POST['email']) ? sanitizeString($_POST['email']) : '';
$notes = isset($_POST['notes']) ? sanitizeString($_POST['notes']) : '';
$fee   = isset($_POST['fee_acknowledge']) ? 1 : 0;

// ── Normalise uploaded files ─────────────────────────────────
// The browser sends a `multiple` input as an array. Some clients
// (or single-file drops) may send a single scalar entry. Normalise
// everything into a uniform list of file arrays.
$fileList = [];
if (!empty($_FILES['documents'])) {
    $f = $_FILES['documents'];
    if (is_array($f['name'])) {
        $count = count($f['name']);
        for ($i = 0; $i < $count; $i++) {
            $fileList[] = [
                'name'     => $f['name'][$i],
                'type'     => $f['type'][$i],
                'tmp_name' => $f['tmp_name'][$i],
                'error'    => $f['error'][$i],
                'size'     => $f['size'][$i],
            ];
        }
    } elseif ($f['name'] !== '') {
        $fileList[] = [
            'name'     => $f['name'],
            'type'     => $f['type'],
            'tmp_name' => $f['tmp_name'],
            'error'    => $f['error'],
            'size'     => $f['size'],
        ];
    }
}

$errors = [];
if (empty($name) || strlen($name) > 100) {
    $errors[] = 'Name is required (max 100 chars).';
}
if (!isValidEmail($email)) {
    $errors[] = 'A valid email address is required.';
}
if (!$fee) {
    $errors[] = 'You must acknowledge the R200 review fee.';
}
if (empty($fileList)) {
    $errors[] = 'Please select at least one file to upload.';
}
if (count($fileList) > MAX_FILES) {
    $errors[] = 'Maximum ' . MAX_FILES . ' files per submission.';
}

if ($errors) {
    http_response_code(422);
    echo json_encode(['success' => false, 'message' => implode(' ', $errors)]);
    exit;
}

// ── Validate and store files ─────────────────────────────────
$fileErrors = [];
$storedFiles = [];
$fileCount = count($fileList);

for ($i = 0; $i < $fileCount; $i++) {
    $origName = $fileList[$i]['name'];
    $tmpName  = $fileList[$i]['tmp_name'];
    $size     = $fileList[$i]['size'];
    $errCode  = $fileList[$i]['error'];

    // Check upload errors
    if ($errCode !== UPLOAD_ERR_OK) {
        $fileErrors[] = "Upload error for '{$origName}' (code {$errCode}).";
        continue;
    }

    // Check file size
    if ($size > MAX_FILE_SIZE) {
        $fileErrors[] = "'{$origName}' exceeds the 25 MB limit.";
        continue;
    }

    // Validate extension + MIME
    if (!isAllowedFile($origName, $tmpName)) {
        $fileErrors[] = "'{$origName}' has an unsupported file type.";
        continue;
    }

    // Generate safe stored name: hash + timestamp + original extension
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    $safeName = hash_file('sha256', $tmpName) . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $dest = UPLOAD_DIR . $safeName;

    if (move_uploaded_file($tmpName, $dest)) {
        $storedFiles[] = [
            'original' => $origName,
            'stored'   => $safeName,
            'mime'     => mime_content_type($dest),
            'size'     => $size,
        ];
    } else {
        $fileErrors[] = "Failed to save '{$origName}'.";
    }
}

if (empty($storedFiles)) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'No files could be saved. ' . implode(' ', $fileErrors)]);
    exit;
}

// ── Insert into DB ───────────────────────────────────────────
try {
    $pdo = getDB();
    $pdo->beginTransaction();

    // Insert parent record
    $sql = "INSERT INTO document_uploads (name, email, notes, fee_acknowledged, fee_status)
            VALUES (:name, :email, :notes, 1, 'pending')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':name'  => $name,
        ':email' => $email,
        ':notes' => $notes ?: null,
    ]);
    $uploadId = $pdo->lastInsertId();

    // Insert file records
    $fileStmt = $pdo->prepare(
        "INSERT INTO document_files (upload_id, original_name, stored_name, mime_type, file_size)
         VALUES (:upload_id, :original_name, :stored_name, :mime_type, :file_size)"
    );
    foreach ($storedFiles as $f) {
        $fileStmt->execute([
            ':upload_id'     => $uploadId,
            ':original_name' => $f['original'],
            ':stored_name'   => $f['stored'],
            ':mime_type'     => $f['mime'],
            ':file_size'     => $f['size'],
        ]);
    }

    $pdo->commit();

    // ── Capture Unified Lead & Schedule Follow-ups ───────────
    captureLead($pdo, [
        'source_type'      => 'upload',
        'source_id'        => (int)$uploadId,
        'full_name'        => $name,
        'email'            => $email,
        'phone'            => '',
        'service_interest' => 'Document Review & Verification',
        'notes'            => $notes,
        'fee_acknowledged' => $fee,
    ]);

    // ══════════════════════════════════════════════════════════
    // PAYMENT GATEWAY INSERTION POINT
    // ══════════════════════════════════════════════════════════
    // When PayFast or Yoco integration is ready:
    //
    // 1. Create a payment intent / redirect URL here.
    // 2. Store the gateway reference in a new column (e.g. `payment_ref`).
    // 3. On successful payment callback/webhook, update:
    //    UPDATE document_uploads SET fee_status = 'paid' WHERE id = :id;
    //
    // Example (PayFast):
    //   $payfast_url = 'https://sandbox.payfast.co.za/eng/process';
    //   $payment_data = [...]; // merchant ID, amount, etc.
    //   $redirect = $payfast_url . '?' . http_build_query($payment_data);
    //
    // Example (Yoco):
    //   $yoco = new YocoClient(secret_key());
    //   $checkout = $yoco->checkouts->create([...]);
    //   $redirect = $checkout->redirectUrl;
    //
    // For now, the fee_status remains 'pending' and an email
    // notification is sent so the practice can follow up manually.
    // ══════════════════════════════════════════════════════════

    // ── Send emails ──────────────────────────────────────────
    $fileListHtml = '';
    foreach ($storedFiles as $f) {
        $sizeKB = round($f['size'] / 1024);
        $fileListHtml .= "<li>{$f['original']} ({$sizeKB} KB)</li>";
    }

    $notesHtml = !empty($notes) ? $notes : '—';
    $details = "
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Files</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'><ul style='margin:0;padding-left:18px;'>{$fileListHtml}</ul></td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Fee Status</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>Pending — R200 review fee due</td></tr>
        <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Notes</td>
            <td style='padding:8px;border:1px solid #c5c6ce;'>{$notesHtml}</td></tr>
    ";
    sendClientConfirmation($email, $name, 'document upload',
        '<p>A non-refundable review fee of <strong>R200</strong> is payable. Our team will contact you regarding payment.</p>');
    sendPracticeNotification('Document Upload', $name, $email, $details);

    echo json_encode([
        'success'   => true,
        'message'   => 'Documents uploaded successfully. R200 review fee is pending.',
        'upload_id' => (int) $uploadId,
    ]);

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again later.']);
}
