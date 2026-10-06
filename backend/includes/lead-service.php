<?php
/**
 * Lead Management Service
 *
 * Handles lead ingestion, deduplication/upserting, scoring,
 * follow-up scheduling, and status lifecycle management.
 */

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/follow-up-rules.php';
require_once __DIR__ . '/follow-up-templates.php';
require_once __DIR__ . '/mailer.php';

/**
 * Calculates a lead score between 0 and 100 based on source and intake characteristics.
 *
 * @param string $sourceType
 * @param array $data
 * @return int
 */
function calculateLeadScore(string $sourceType, array $data): int
{
    $baseScores = [
        'upload'   => 50, // High intent: shared real accounting/tax docs & acknowledged fee
        'booking'  => 40, // High intent: requested specific consultation slot
        'training' => 35, // Strong intent: specific course registration
        'contact'  => 20, // General enquiry
        'manual'   => 25,
    ];

    $score = $baseScores[$sourceType] ?? 20;

    // Bonus points for phone number provided
    if (!empty($data['phone'])) {
        $score += 10;
    }

    // Bonus points for company provided (corporate lead)
    if (!empty($data['company'])) {
        $score += 15;
    }

    // Bonus for high-intent messages (> 30 characters)
    $msg = $data['message'] ?? ($data['notes'] ?? '');
    if (strlen(trim($msg)) > 30) {
        $score += 10;
    }

    // Bonus for fee acknowledgment (uploads)
    if (!empty($data['fee_acknowledged'])) {
        $score += 15;
    }

    return min(100, max(5, $score));
}

/**
 * Captures or updates a lead, scores it, and schedules the follow-up sequence.
 *
 * @param PDO $pdo
 * @param array{
 *     source_type: string,
 *     source_id: int,
 *     full_name: string,
 *     email: string,
 *     phone?: string,
 *     service_interest?: string,
 *     company?: string,
 *     message?: string,
 *     notes?: string,
 *     fee_acknowledged?: int
 * } $leadData
 * @return int The lead ID
 */
function captureLead(PDO $pdo, array $leadData): int
{
    $email = strtolower(trim($leadData['email']));
    $fullName = trim($leadData['full_name']);
    $phone = trim($leadData['phone'] ?? '');
    $serviceInterest = trim($leadData['service_interest'] ?? 'General Advisory');
    $sourceType = $leadData['source_type'];
    $sourceId = (int)$leadData['source_id'];
    $score = calculateLeadScore($sourceType, $leadData);

    // Check for an existing lead with this email
    $checkStmt = $pdo->prepare("SELECT id, status, score FROM leads WHERE email = :email LIMIT 1");
    $checkStmt->execute([':email' => $email]);
    $existing = $checkStmt->fetch();

    if ($existing) {
        $leadId = (int)$existing['id'];
        $newScore = max((int)$existing['score'], $score);

        // If previously lost or converted, reopen as new if a new submission arrives
        $targetStatus = in_array($existing['status'], ['lost', 'converted'], true) ? 'new' : $existing['status'];

        $updateStmt = $pdo->prepare(
            "UPDATE leads 
             SET source_type = :source_type,
                 source_id = :source_id,
                 full_name = :full_name,
                 phone = CASE WHEN :phone != '' THEN :phone_val ELSE phone END,
                 service_interest = :service_interest,
                 status = :status,
                 score = :score,
                 updated_at = CURRENT_TIMESTAMP
             WHERE id = :id"
        );
        $updateStmt->execute([
            ':source_type'      => $sourceType,
            ':source_id'        => $sourceId,
            ':full_name'        => $fullName,
            ':phone'            => $phone,
            ':phone_val'        => $phone,
            ':service_interest' => $serviceInterest,
            ':status'           => $targetStatus,
            ':score'            => $newScore,
            ':id'               => $leadId,
        ]);
    } else {
        $insertStmt = $pdo->prepare(
            "INSERT INTO leads (source_type, source_id, full_name, email, phone, service_interest, status, score)
             VALUES (:source_type, :source_id, :full_name, :email, :phone, :service_interest, 'new', :score)"
        );
        $insertStmt->execute([
            ':source_type'      => $sourceType,
            ':source_id'        => $sourceId,
            ':full_name'        => $fullName,
            ':email'            => $email,
            ':phone'            => $phone,
            ':service_interest' => $serviceInterest,
            ':score'            => $score,
        ]);
        $leadId = (int)$pdo->lastInsertId();
    }

    // Schedule automated follow-up sequences
    scheduleLeadFollowUps($pdo, $leadId, [
        'full_name'        => $fullName,
        'email'            => $email,
        'phone'            => $phone,
        'service_interest' => $serviceInterest,
        'source_type'      => $sourceType,
    ]);

    return $leadId;
}

/**
 * Schedules follow-up rows for a lead and dispatches the immediate welcome message.
 *
 * @param PDO $pdo
 * @param int $leadId
 * @param array $leadContext
 * @return void
 */
function scheduleLeadFollowUps(PDO $pdo, int $leadId, array $leadContext): void
{
    $rules = getFollowUpRulesConfig();
    $now = time();

    // Check existing pending templates to prevent duplicate scheduling
    $existStmt = $pdo->prepare("SELECT template_key FROM lead_follow_ups WHERE lead_id = :lead_id AND status = 'pending'");
    $existStmt->execute([':lead_id' => $leadId]);
    $existingPending = $existStmt->fetchAll(PDO::FETCH_COLUMN);

    $insertFollowUp = $pdo->prepare(
        "INSERT INTO lead_follow_ups (lead_id, type, template_key, scheduled_for, status, sent_at, error_message)
         VALUES (:lead_id, :type, :template_key, :scheduled_for, :status, :sent_at, :error_message)"
    );

    foreach ($rules as $rule) {
        $key = $rule['key'];

        // If an identical pending follow-up is already queued, don't double-queue
        if (in_array($key, $existingPending, true)) {
            continue;
        }

        if ($rule['delay_seconds'] === 0) {
            // Immediate welcome follow-up: Send right away
            $tpl = renderFollowUpTemplate($key, $leadContext);
            $sent = sendEmail($leadContext['email'], $tpl['subject'], $tpl['body']);

            $status = $sent ? 'sent' : 'failed';
            $sentAt = $sent ? date('Y-m-d H:i:s', $now) : null;
            $errorMsg = $sent ? null : 'Failed to send immediate welcome via PHP mail()';

            $insertFollowUp->execute([
                ':lead_id'       => $leadId,
                ':type'          => 'auto_email',
                ':template_key'  => $key,
                ':scheduled_for' => date('Y-m-d H:i:s', $now),
                ':status'        => $status,
                ':sent_at'       => $sentAt,
                ':error_message' => $errorMsg,
            ]);

            // Mark last_contacted_at on the lead
            $pdo->prepare("UPDATE leads SET last_contacted_at = CURRENT_TIMESTAMP WHERE id = :id")->execute([':id' => $leadId]);

        } else {
            // Future scheduled follow-ups (+24h, +72h, +7d)
            $scheduledFor = date('Y-m-d H:i:s', $now + $rule['delay_seconds']);
            $insertFollowUp->execute([
                ':lead_id'       => $leadId,
                ':type'          => 'auto_email',
                ':template_key'  => $key,
                ':scheduled_for' => $scheduledFor,
                ':status'        => 'pending',
                ':sent_at'       => null,
                ':error_message' => null,
            ]);
        }
    }

    // Refresh earliest next_follow_up_at
    updateLeadNextFollowUp($pdo, $leadId);
}

/**
 * Updates next_follow_up_at timestamp for a lead based on earliest pending follow-up.
 *
 * @param PDO $pdo
 * @param int $leadId
 * @return void
 */
function updateLeadNextFollowUp(PDO $pdo, int $leadId): void
{
    $stmt = $pdo->prepare(
        "SELECT MIN(scheduled_for) AS next_time 
         FROM lead_follow_ups 
         WHERE lead_id = :lead_id AND status = 'pending'"
    );
    $stmt->execute([':lead_id' => $leadId]);
    $nextTime = $stmt->fetchColumn();

    $upStmt = $pdo->prepare("UPDATE leads SET next_follow_up_at = :next_time WHERE id = :id");
    $upStmt->execute([
        ':next_time' => $nextTime ?: null,
        ':id'        => $leadId,
    ]);
}

/**
 * Changes a lead's status and automatically cancels pending follow-ups if terminal.
 *
 * @param PDO $pdo
 * @param int $leadId
 * @param string $newStatus ('new','contacted','qualified','converted','lost')
 * @return bool
 */
function updateLeadStatus(PDO $pdo, int $leadId, string $newStatus): bool
{
    $validStatuses = ['new', 'contacted', 'qualified', 'converted', 'lost'];
    if (!in_array($newStatus, $validStatuses, true)) {
        return false;
    }

    $stmt = $pdo->prepare("UPDATE leads SET status = :status, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
    $stmt->execute([':status' => $newStatus, ':id' => $leadId]);

    // If moving to qualified, converted, or lost, cancel remaining pending automated emails
    if (in_array($newStatus, ['qualified', 'converted', 'lost'], true)) {
        $cancelStmt = $pdo->prepare(
            "UPDATE lead_follow_ups 
             SET status = 'cancelled', 
                 error_message = CONCAT('Auto-cancelled: Lead status transitioned to ', :status)
             WHERE lead_id = :lead_id AND status = 'pending'"
        );
        $cancelStmt->execute([':status' => $newStatus, ':lead_id' => $leadId]);
    }

    updateLeadNextFollowUp($pdo, $leadId);
    return true;
}

/**
 * Adds an internal staff note to a lead.
 *
 * @param PDO $pdo
 * @param int $leadId
 * @param string $note
 * @param int|null $authorId
 * @param string $authorName
 * @return int
 */
function addLeadNote(PDO $pdo, int $leadId, string $note, ?int $authorId = null, string $authorName = 'Staff'): int
{
    $stmt = $pdo->prepare(
        "INSERT INTO lead_notes (lead_id, author_id, author_name, note)
         VALUES (:lead_id, :author_id, :author_name, :note)"
    );
    $stmt->execute([
        ':lead_id'     => $leadId,
        ':author_id'   => $authorId,
        ':author_name' => $authorName,
        ':note'        => trim($note),
    ]);

    return (int)$pdo->lastInsertId();
}
