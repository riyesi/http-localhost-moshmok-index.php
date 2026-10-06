<?php
/**
 * Automated Follow-Up Processing Engine
 *
 * Can be executed via:
 * 1. CLI / Cron / Windows Task Scheduler:
 *    php -c C:\xampp\php\php.ini C:\xampp\htdocs\moshmok\backend\cron\process-follow-ups.php
 * 2. HTTP GET / POST (e.g., from Admin Dashboard or web hook)
 *
 * Functionality:
 * - Queries pending follow-ups where scheduled_for <= NOW()
 * - Re-evaluates parent lead status to ensure compliance with nurturing rules
 * - Cancels follow-ups if lead is qualified, converted, or lost
 * - Dispatches emails via mailer.php
 * - Updates record statuses and timestamps
 * - Appends structured events to backend/logs/follow-up.log
 */

// Determine CLI vs HTTP execution
$isCli = (php_sapi_name() === 'cli' || empty($_SERVER['REMOTE_ADDR']));

if (!$isCli) {
    header('Content-Type: application/json; charset=utf-8');
}

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/mailer.php';
require_once __DIR__ . '/../includes/follow-up-rules.php';
require_once __DIR__ . '/../includes/follow-up-templates.php';
require_once __DIR__ . '/../includes/lead-service.php';

// Ensure log directory exists
$logDir = __DIR__ . '/../logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}
$logFile = $logDir . '/follow-up.log';

/**
 * Append entry to follow-up log.
 */
function logFollowUpEvent(string $message): void
{
    global $logFile;
    $timestamp = date('Y-m-d H:i:s');
    @file_put_contents($logFile, "[{$timestamp}] {$message}" . PHP_EOL, FILE_APPEND | LOCK_EX);
}

$summary = [
    'timestamp' => date('Y-m-d H:i:s'),
    'found'     => 0,
    'sent'      => 0,
    'cancelled' => 0,
    'failed'    => 0,
    'details'   => [],
];

try {
    $pdo = getDB();

    // Select pending follow-ups due for dispatch
    $sql = "
        SELECT f.id AS follow_up_id,
               f.lead_id,
               f.type,
               f.template_key,
               f.scheduled_for,
               l.full_name,
               l.email,
               l.phone,
               l.service_interest,
               l.source_type,
               l.status AS lead_status
        FROM lead_follow_ups f
        INNER JOIN leads l ON f.lead_id = l.id
        WHERE f.status = 'pending'
          AND f.scheduled_for <= NOW()
        ORDER BY f.scheduled_for ASC
        LIMIT 50
    ";

    $stmt = $pdo->query($sql);
    $dueFollowUps = $stmt->fetchAll();
    $summary['found'] = count($dueFollowUps);

    $touchedLeadIds = [];

    $updateSuccessStmt = $pdo->prepare(
        "UPDATE lead_follow_ups 
         SET status = 'sent', sent_at = CURRENT_TIMESTAMP, error_message = NULL 
         WHERE id = :id"
    );

    $updateCancelStmt = $pdo->prepare(
        "UPDATE lead_follow_ups 
         SET status = 'cancelled', error_message = :reason 
         WHERE id = :id"
    );

    $updateFailedStmt = $pdo->prepare(
        "UPDATE lead_follow_ups 
         SET status = 'failed', error_message = :err 
         WHERE id = :id"
    );

    $touchLeadStmt = $pdo->prepare(
        "UPDATE leads 
         SET last_contacted_at = CURRENT_TIMESTAMP 
         WHERE id = :id"
    );

    foreach ($dueFollowUps as $item) {
        $fuId       = (int)$item['follow_up_id'];
        $leadId     = (int)$item['lead_id'];
        $template   = $item['template_key'];
        $leadStatus = $item['lead_status'];
        $email      = $item['email'];
        $touchedLeadIds[$leadId] = true;

        // Condition Check: Is follow-up allowed under current lead status?
        $allowed = isFollowUpAllowedForLeadStatus($template, $leadStatus);

        if (!$allowed) {
            $reason = "Cancelled: Lead status '{$leadStatus}' not eligible for template '{$template}'";
            $updateCancelStmt->execute([':reason' => $reason, ':id' => $fuId]);
            $summary['cancelled']++;
            $summary['details'][] = "Follow-up #{$fuId} (Lead #{$leadId}) CANCELLED: {$reason}";
            logFollowUpEvent("CANCELLED: Follow-up #{$fuId} to {$email} (Lead #{$leadId}, Status: {$leadStatus})");
            continue;
        }

        // Render template and send email
        $rendered = renderFollowUpTemplate($template, [
            'full_name'        => $item['full_name'],
            'email'            => $email,
            'phone'            => $item['phone'],
            'service_interest' => $item['service_interest'],
            'source_type'      => $item['source_type'],
        ]);

        $sent = sendEmail($email, $rendered['subject'], $rendered['body']);

        if ($sent) {
            $updateSuccessStmt->execute([':id' => $fuId]);
            $touchLeadStmt->execute([':id' => $leadId]);
            $summary['sent']++;
            $summary['details'][] = "Follow-up #{$fuId} (Lead #{$leadId}) SENT to {$email} [{$template}]";
            logFollowUpEvent("SENT: Follow-up #{$fuId} to {$email} (Lead #{$leadId}, Template: {$template})");
        } else {
            $errMsg = "PHP mail() returned false or MTA unreachable";
            $updateFailedStmt->execute([':err' => $errMsg, ':id' => $fuId]);
            $summary['failed']++;
            $summary['details'][] = "Follow-up #{$fuId} (Lead #{$leadId}) FAILED to {$email}: {$errMsg}";
            logFollowUpEvent("FAILED: Follow-up #{$fuId} to {$email} (Lead #{$leadId}, Error: {$errMsg})");
        }
    }

    // Refresh next_follow_up_at for all affected leads
    foreach (array_keys($touchedLeadIds) as $leadId) {
        updateLeadNextFollowUp($pdo, (int)$leadId);
    }

    logFollowUpEvent("RUN SUMMARY: Processed {$summary['found']} items ({$summary['sent']} sent, {$summary['cancelled']} cancelled, {$summary['failed']} failed)");

} catch (Exception $e) {
    $summary['error'] = $e->getMessage();
    logFollowUpEvent("ERROR: " . $e->getMessage());
}

// Output based on execution context
if ($isCli) {
    echo "========================================\n";
    echo "Follow-Up Processor Run: " . $summary['timestamp'] . "\n";
    echo "Found: {$summary['found']} | Sent: {$summary['sent']} | Cancelled: {$summary['cancelled']} | Failed: {$summary['failed']}\n";
    if (!empty($summary['details'])) {
        foreach ($summary['details'] as $line) {
            echo " - {$line}\n";
        }
    }
    if (!empty($summary['error'])) {
        echo "Error: {$summary['error']}\n";
    }
    echo "========================================\n";
} else {
    echo json_encode([
        'success' => empty($summary['error']),
        'summary' => $summary,
    ], JSON_PRETTY_PRINT);
}
