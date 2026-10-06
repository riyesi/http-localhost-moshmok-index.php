<?php
/**
 * Single Lead Detail & Action Center
 *
 * Detailed inspection of lead record, original intake submission details,
 * staff notes, and follow-up timeline execution.
 */

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/mailer.php';
require_once __DIR__ . '/../includes/follow-up-rules.php';
require_once __DIR__ . '/../includes/follow-up-templates.php';
require_once __DIR__ . '/../includes/lead-service.php';

$currentUser = requireAdminAuth();
$pdo = getDB();

$leadId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($leadId <= 0) {
    header('Location: dashboard.php');
    exit;
}

$notice = '';
$error  = '';

// ── Handle Actions (Status Update, Note Addition, Follow-Up Dispatch) ──
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $csrf   = $_POST['csrf_token'] ?? '';

    if (!verifyAdminCsrfToken($csrf)) {
        $error = 'Security validation failed (invalid CSRF token).';
    } else {
        try {
            if ($action === 'update_lead') {
                $newStatus   = trim($_POST['status'] ?? 'new');
                $newScore    = max(0, min(100, (int)($_POST['score'] ?? 0)));
                $assignedTo  = !empty($_POST['assigned_to']) ? (int)$_POST['assigned_to'] : null;
                $nextFollow  = !empty($_POST['next_follow_up_at']) ? $_POST['next_follow_up_at'] : null;

                // Update status (which also auto-cancels pending follow-ups if terminal)
                updateLeadStatus($pdo, $leadId, $newStatus);

                $stmt = $pdo->prepare(
                    "UPDATE leads 
                     SET score = :score, assigned_to = :assigned, next_follow_up_at = :next_follow, updated_at = CURRENT_TIMESTAMP 
                     WHERE id = :id"
                );
                $stmt->execute([
                    ':score'       => $newScore,
                    ':assigned'    => $assignedTo,
                    ':next_follow' => $nextFollow,
                    ':id'          => $leadId,
                ]);

                $notice = 'Lead properties and status updated successfully.';

            } elseif ($action === 'add_note') {
                $noteText = trim($_POST['note'] ?? '');
                if (!empty($noteText)) {
                    addLeadNote($pdo, $leadId, $noteText, $currentUser['id'], $currentUser['full_name']);
                    $notice = 'Staff note added.';
                } else {
                    $error = 'Note text cannot be empty.';
                }

            } elseif ($action === 'send_followup_now') {
                $fuId = (int)($_POST['follow_up_id'] ?? 0);
                
                // Fetch follow-up and lead
                $fuStmt = $pdo->prepare(
                    "SELECT f.*, l.full_name, l.email, l.phone, l.service_interest, l.source_type, l.status AS lead_status 
                     FROM lead_follow_ups f
                     JOIN leads l ON f.lead_id = l.id
                     WHERE f.id = :id AND f.lead_id = :lead_id LIMIT 1"
                );
                $fuStmt->execute([':id' => $fuId, ':lead_id' => $leadId]);
                $fu = $fuStmt->fetch();

                if ($fu && $fu['status'] === 'pending') {
                    $tpl = renderFollowUpTemplate($fu['template_key'], [
                        'full_name'        => $fu['full_name'],
                        'email'            => $fu['email'],
                        'phone'            => $fu['phone'],
                        'service_interest' => $fu['service_interest'],
                        'source_type'      => $fu['source_type'],
                    ]);

                    $sent = sendEmail($fu['email'], $tpl['subject'], $tpl['body']);
                    if ($sent) {
                        $pdo->prepare("UPDATE lead_follow_ups SET status = 'sent', sent_at = CURRENT_TIMESTAMP, error_message = NULL WHERE id = :id")
                            ->execute([':id' => $fuId]);
                        $pdo->prepare("UPDATE leads SET last_contacted_at = CURRENT_TIMESTAMP WHERE id = :id")
                            ->execute([':id' => $leadId]);
                        $notice = 'Follow-up email dispatched successfully.';
                    } else {
                        $pdo->prepare("UPDATE lead_follow_ups SET status = 'failed', error_message = 'PHP mail() returned false' WHERE id = :id")
                            ->execute([':id' => $fuId]);
                        $error = 'Delivery attempted, but PHP mail() returned failure.';
                    }
                    updateLeadNextFollowUp($pdo, $leadId);
                }

            } elseif ($action === 'cancel_followup') {
                $fuId = (int)($_POST['follow_up_id'] ?? 0);
                $pdo->prepare("UPDATE lead_follow_ups SET status = 'cancelled', error_message = 'Cancelled manually by staff' WHERE id = :id AND lead_id = :lid")
                    ->execute([':id' => $fuId, ':lid' => $leadId]);
                updateLeadNextFollowUp($pdo, $leadId);
                $notice = 'Follow-up was cancelled.';

            } elseif ($action === 'create_custom_followup') {
                $fuType      = $_POST['type'] ?? 'manual_email';
                $subject     = trim($_POST['custom_subject'] ?? '');
                $customMsg   = trim($_POST['custom_message'] ?? '');
                $scheduleFor = !empty($_POST['schedule_time']) ? $_POST['schedule_time'] : date('Y-m-d H:i:s');
                $dispatchNow = !empty($_POST['dispatch_now']);

                if ($fuType === 'manual_email' && $dispatchNow) {
                    // Send immediately
                    $leadStmt = $pdo->prepare("SELECT * FROM leads WHERE id = :id");
                    $leadStmt->execute([':id' => $leadId]);
                    $currentLead = $leadStmt->fetch();

                    $rendered = renderFollowUpTemplate('manual_email', $currentLead, [
                        'subject' => $subject,
                        'message' => $customMsg,
                    ]);

                    $sent = sendEmail($currentLead['email'], $rendered['subject'], $rendered['body']);
                    $status = $sent ? 'sent' : 'failed';
                    $sentAt = $sent ? date('Y-m-d H:i:s') : null;
                    $errMsg = $sent ? null : 'Failed to send via PHP mail()';

                    $ins = $pdo->prepare(
                        "INSERT INTO lead_follow_ups (lead_id, type, template_key, scheduled_for, status, sent_at, error_message, created_by)
                         VALUES (:lid, :type, :tkey, CURRENT_TIMESTAMP, :status, :sent_at, :err, :cby)"
                    );
                    $ins->execute([
                        ':lid'     => $leadId,
                        ':type'    => 'manual_email',
                        ':tkey'    => 'manual_email',
                        ':status'  => $status,
                        ':sent_at' => $sentAt,
                        ':err'     => $errMsg,
                        ':cby'     => $currentUser['id'],
                    ]);

                    $pdo->prepare("UPDATE leads SET last_contacted_at = CURRENT_TIMESTAMP WHERE id = :id")->execute([':id' => $leadId]);
                    $notice = $sent ? 'Custom email sent successfully.' : 'Email attempt failed.';
                } else {
                    // Schedule for later or log non-email action
                    $ins = $pdo->prepare(
                        "INSERT INTO lead_follow_ups (lead_id, type, template_key, scheduled_for, status, created_by)
                         VALUES (:lid, :type, :tkey, :sched, 'pending', :cby)"
                    );
                    $ins->execute([
                        ':lid'   => $leadId,
                        ':type'  => $fuType,
                        ':tkey'  => ($fuType === 'manual_email' ? 'manual_email' : $fuType),
                        ':sched' => $scheduleFor,
                        ':cby'   => $currentUser['id'],
                    ]);
                    $notice = 'Scheduled follow-up action created.';
                }
                updateLeadNextFollowUp($pdo, $leadId);
            }
        } catch (Exception $e) {
            $error = 'Error performing action: ' . $e->getMessage();
        }
    }
}

// ── Fetch Lead Record ────────────────────────────────────────
$stmt = $pdo->prepare("SELECT * FROM leads WHERE id = :id LIMIT 1");
$stmt->execute([':id' => $leadId]);
$lead = $stmt->fetch();

if (!$lead) {
    header('Location: dashboard.php');
    exit;
}

// ── Fetch Staff Users (for assignment dropdown) ──────────────
$staffUsers = $pdo->query("SELECT id, full_name, username, role FROM admin_users ORDER BY full_name ASC")->fetchAll();

// ── Fetch Original Submission Details ────────────────────────
$originalData = null;
$originalFiles = [];

if ($lead['source_id']) {
    $srcId = (int)$lead['source_id'];
    switch ($lead['source_type']) {
        case 'booking':
            $s = $pdo->prepare("SELECT * FROM bookings WHERE id = :id");
            $s->execute([':id' => $srcId]);
            $originalData = $s->fetch();
            break;
        case 'training':
            $s = $pdo->prepare("SELECT * FROM training_signups WHERE id = :id");
            $s->execute([':id' => $srcId]);
            $originalData = $s->fetch();
            break;
        case 'contact':
            $s = $pdo->prepare("SELECT * FROM contact_messages WHERE id = :id");
            $s->execute([':id' => $srcId]);
            $originalData = $s->fetch();
            break;
        case 'upload':
            $s = $pdo->prepare("SELECT * FROM document_uploads WHERE id = :id");
            $s->execute([':id' => $srcId]);
            $originalData = $s->fetch();

            $f = $pdo->prepare("SELECT * FROM document_files WHERE upload_id = :id");
            $f->execute([':id' => $srcId]);
            $originalFiles = $f->fetchAll();
            break;
    }
}

// ── Fetch Follow-up Timeline ─────────────────────────────────
$fuStmt = $pdo->prepare("
    SELECT fu.*, u.full_name AS creator_name 
    FROM lead_follow_ups fu
    LEFT JOIN admin_users u ON fu.created_by = u.id
    WHERE fu.lead_id = :id 
    ORDER BY fu.scheduled_for ASC, fu.id ASC
");
$fuStmt->execute([':id' => $leadId]);
$followUps = $fuStmt->fetchAll();

// ── Fetch Internal Staff Notes ───────────────────────────────
$noteStmt = $pdo->prepare("SELECT * FROM lead_notes WHERE lead_id = :id ORDER BY created_at DESC");
$noteStmt->execute([':id' => $leadId]);
$notes = $noteStmt->fetchAll();

$csrfToken = getAdminCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lead #<?= $lead['id'] ?> — <?= htmlspecialchars($lead['full_name'], ENT_QUOTES, 'UTF-8') ?></title>
  <link rel="stylesheet" href="../../assets/css/styles.css">
</head>
<body class="bg-surface text-on-surface font-body-md antialiased min-h-screen flex flex-col">

  <!-- Admin Navigation Header -->
  <header class="bg-surface-container-lowest border-b border-outline-variant sticky top-0 z-30">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
      <div class="flex items-center gap-3">
        <a href="dashboard.php" class="font-headline-md text-headline-md font-bold text-primary tracking-tight">
          FINANCIAL PRECISION
        </a>
        <span class="text-xs bg-primary-container text-on-primary-container font-mono px-2 py-0.5 rounded font-bold uppercase">
          Lead Hub
        </span>
      </div>

      <div class="flex items-center gap-4">
        <a href="dashboard.php" class="text-xs text-primary font-bold hover:underline">
          &larr; Back to Dashboard
        </a>
        <a href="logout.php" class="text-xs bg-surface-container-high hover:bg-surface-container text-primary font-bold px-3 py-1.5 rounded transition-colors">
          Log Out
        </a>
      </div>
    </div>
  </header>

  <!-- Main Content Area -->
  <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Flash notifications -->
    <?php if (!empty($notice)): ?>
      <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-lg flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2">
          <span class="font-bold text-emerald-700">&#10003;</span>
          <span><?= htmlspecialchars($notice, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
      </div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
      <div class="p-4 bg-error-container border border-error/20 text-on-error-container rounded-lg flex items-center gap-2 shadow-sm">
        <span class="font-bold text-error">&#9888;</span>
        <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
    <?php endif; ?>

    <!-- Lead Overview Header -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <div class="flex items-center gap-3">
          <h1 class="text-2xl font-bold text-primary"><?= htmlspecialchars($lead['full_name'], ENT_QUOTES, 'UTF-8') ?></h1>
          <?= renderStatusBadge($lead['status']) ?>
          <?= renderSourceBadge($lead['source_type']) ?>
          <?= renderScoreBadge((int)$lead['score']) ?>
        </div>
        <div class="flex flex-wrap items-center gap-4 mt-2 text-xs text-on-surface-variant">
          <span><strong>Email:</strong> <a href="mailto:<?= htmlspecialchars($lead['email'], ENT_QUOTES, 'UTF-8') ?>" class="text-primary hover:underline"><?= htmlspecialchars($lead['email'], ENT_QUOTES, 'UTF-8') ?></a></span>
          <?php if (!empty($lead['phone'])): ?>
            <span><strong>Phone:</strong> <a href="tel:<?= htmlspecialchars($lead['phone'], ENT_QUOTES, 'UTF-8') ?>" class="text-primary hover:underline"><?= htmlspecialchars($lead['phone'], ENT_QUOTES, 'UTF-8') ?></a></span>
          <?php endif; ?>
          <span><strong>Inquired:</strong> <?= date('d M Y, H:i', strtotime($lead['created_at'])) ?></span>
          <span><strong>Last Contact:</strong> <?= timeAgo($lead['last_contacted_at']) ?></span>
        </div>
      </div>

      <div class="flex items-center gap-2">
        <a href="mailto:<?= htmlspecialchars($lead['email'], ENT_QUOTES, 'UTF-8') ?>" 
           class="bg-tertiary-fixed text-on-tertiary-fixed font-bold text-xs px-3.5 py-2 rounded-lg hover:opacity-90 transition-all">
          Direct Email
        </a>
      </div>
    </div>

    <!-- 2-Column Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

      <!-- Left Column: Lead Management & Original Submission -->
      <div class="lg:col-span-7 space-y-6">

        <!-- Status & Properties Management Card -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
          <h2 class="text-base font-bold text-primary mb-4 pb-2 border-b border-outline-variant">Lead Settings &amp; Assignment</h2>
          
          <form method="POST" action="lead.php?id=<?= $lead['id'] ?>" class="space-y-4">
            <input type="hidden" name="action" value="update_lead">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <!-- Status -->
              <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Lifecycle Status</label>
                <select name="status" class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-sm text-primary focus:outline-none focus:border-tertiary-fixed-dim">
                  <option value="new" <?= $lead['status'] === 'new' ? 'selected' : '' ?>>New (Uncontacted)</option>
                  <option value="contacted" <?= $lead['status'] === 'contacted' ? 'selected' : '' ?>>Contacted (In Progress)</option>
                  <option value="qualified" <?= $lead['status'] === 'qualified' ? 'selected' : '' ?>>Qualified (Valid Opportunity)</option>
                  <option value="converted" <?= $lead['status'] === 'converted' ? 'selected' : '' ?>>Converted (Client Won)</option>
                  <option value="lost" <?= $lead['status'] === 'lost' ? 'selected' : '' ?>>Lost (Closed/Disqualified)</option>
                </select>
                <span class="text-xs text-on-surface-variant mt-1 block">Changing to Qualified, Converted, or Lost automatically cancels pending auto-reminders.</span>
              </div>

              <!-- Score -->
              <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Lead Score (0 - 100)</label>
                <input type="number" name="score" min="0" max="100" value="<?= (int)$lead['score'] ?>"
                       class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-sm text-primary focus:outline-none focus:border-tertiary-fixed-dim">
              </div>

              <!-- Assigned To -->
              <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Assigned Staff</label>
                <select name="assigned_to" class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-sm text-primary focus:outline-none focus:border-tertiary-fixed-dim">
                  <option value="">-- Unassigned --</option>
                  <?php foreach ($staffUsers as $sUser): ?>
                    <option value="<?= $sUser['id'] ?>" <?= ((int)$lead['assigned_to'] === (int)$sUser['id']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($sUser['full_name'], ENT_QUOTES, 'UTF-8') ?> (<?= $sUser['role'] ?>)
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <!-- Next Follow-up -->
              <div>
                <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Next Follow-Up Time</label>
                <input type="text" name="next_follow_up_at" 
                       value="<?= !empty($lead['next_follow_up_at']) ? htmlspecialchars($lead['next_follow_up_at'], ENT_QUOTES, 'UTF-8') : '' ?>"
                       placeholder="YYYY-MM-DD HH:MM:SS"
                       class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-sm text-primary font-mono focus:outline-none focus:border-tertiary-fixed-dim">
              </div>
            </div>

            <div class="pt-2 text-right">
              <button type="submit" class="bg-primary text-on-primary font-bold px-4 py-2 rounded-lg text-sm hover:opacity-90 transition-all">
                Save Properties
              </button>
            </div>
          </form>
        </div>

        <!-- Original Submission Inspector -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
          <h2 class="text-base font-bold text-primary mb-3 pb-2 border-b border-outline-variant flex items-center justify-between">
            <span>Original Intake Submission Details</span>
            <span class="text-xs font-mono font-normal text-on-surface-variant">Table: <?= htmlspecialchars($lead['source_type'], ENT_QUOTES, 'UTF-8') ?> #<?= (int)$lead['source_id'] ?></span>
          </h2>

          <?php if (!$originalData): ?>
            <p class="text-xs text-on-surface-variant">No original submission record linked or record was deleted.</p>
          <?php else: ?>
            <div class="space-y-3 text-xs">
              
              <?php if ($lead['source_type'] === 'booking'): ?>
                <div class="grid grid-cols-2 gap-2 bg-surface-container-low p-3 rounded-lg">
                  <div><strong>Consultation Type:</strong> <?= htmlspecialchars($originalData['service_type'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                  <div><strong>Preferred Date:</strong> <?= htmlspecialchars($originalData['preferred_date'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                  <div><strong>Preferred Time:</strong> <?= htmlspecialchars($originalData['preferred_time'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                  <div><strong>Booking Status:</strong> <?= htmlspecialchars($originalData['status'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                </div>
                <?php if (!empty($originalData['message'])): ?>
                  <div class="mt-2">
                    <strong class="block mb-1">Message / Consultation Notes:</strong>
                    <div class="p-3 bg-surface border border-outline-variant rounded text-on-surface leading-relaxed">
                      <?= nl2br(htmlspecialchars($originalData['message'], ENT_QUOTES, 'UTF-8')) ?>
                    </div>
                  </div>
                <?php endif; ?>

              <?php elseif ($lead['source_type'] === 'training'): ?>
                <div class="grid grid-cols-2 gap-2 bg-surface-container-low p-3 rounded-lg">
                  <div><strong>Course Enrolled:</strong> <?= htmlspecialchars($originalData['course'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                  <div><strong>Company:</strong> <?= htmlspecialchars($originalData['company'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                  <div><strong>Designation:</strong> <?= htmlspecialchars($originalData['designation'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                  <div><strong>Attendees:</strong> <?= (int)($originalData['attendees'] ?? 1) ?></div>
                </div>
                <?php if (!empty($originalData['message'])): ?>
                  <div class="mt-2">
                    <strong class="block mb-1">Special Requirements:</strong>
                    <div class="p-3 bg-surface border border-outline-variant rounded text-on-surface leading-relaxed">
                      <?= nl2br(htmlspecialchars($originalData['message'], ENT_QUOTES, 'UTF-8')) ?>
                    </div>
                  </div>
                <?php endif; ?>

              <?php elseif ($lead['source_type'] === 'contact'): ?>
                <div class="bg-surface-container-low p-3 rounded-lg">
                  <div><strong>Service Area:</strong> <?= htmlspecialchars($originalData['service'] ?? '—', ENT_QUOTES, 'UTF-8') ?></div>
                  <div><strong>Consent Acknowledged:</strong> <?= !empty($originalData['consent']) ? 'Yes (POPIA Compliant)' : 'No' ?></div>
                </div>
                <div class="mt-2">
                  <strong class="block mb-1">Full Message:</strong>
                  <div class="p-3 bg-surface border border-outline-variant rounded text-on-surface leading-relaxed">
                    <?= nl2br(htmlspecialchars($originalData['message'] ?? '', ENT_QUOTES, 'UTF-8')) ?>
                  </div>
                </div>

              <?php elseif ($lead['source_type'] === 'upload'): ?>
                <div class="grid grid-cols-2 gap-2 bg-surface-container-low p-3 rounded-lg">
                  <div><strong>R200 Fee Status:</strong> <span class="font-bold uppercase text-amber-800"><?= htmlspecialchars($originalData['fee_status'] ?? 'pending', ENT_QUOTES, 'UTF-8') ?></span></div>
                  <div><strong>Fee Acknowledged:</strong> <?= !empty($originalData['fee_acknowledged']) ? 'Yes' : 'No' ?></div>
                </div>
                <?php if (!empty($originalData['notes'])): ?>
                  <div class="mt-2">
                    <strong class="block mb-1">Client Notes:</strong>
                    <div class="p-3 bg-surface border border-outline-variant rounded text-on-surface leading-relaxed">
                      <?= nl2br(htmlspecialchars($originalData['notes'], ENT_QUOTES, 'UTF-8')) ?>
                    </div>
                  </div>
                <?php endif; ?>
                <?php if (!empty($originalFiles)): ?>
                  <div class="mt-3">
                    <strong class="block mb-1">Uploaded Files (<?= count($originalFiles) ?>):</strong>
                    <ul class="divide-y divide-outline-variant/60 border border-outline-variant rounded bg-surface">
                      <?php foreach ($originalFiles as $fl): ?>
                        <li class="p-2.5 flex items-center justify-between text-xs">
                          <div>
                            <span class="font-bold text-primary"><?= htmlspecialchars($fl['original_name'], ENT_QUOTES, 'UTF-8') ?></span>
                            <span class="text-on-surface-variant font-mono block"><?= htmlspecialchars($fl['mime_type'], ENT_QUOTES, 'UTF-8') ?></span>
                          </div>
                          <span class="text-on-surface-variant font-mono"><?= round($fl['file_size'] / 1024) ?> KB</span>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endif; ?>

              <?php endif; ?>

            </div>
          <?php endif; ?>
        </div>

        <!-- Staff Internal Notes -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
          <h2 class="text-base font-bold text-primary mb-4 pb-2 border-b border-outline-variant">Internal Staff Notes</h2>

          <!-- Add Note Form -->
          <form method="POST" action="lead.php?id=<?= $lead['id'] ?>" class="mb-5 space-y-2">
            <input type="hidden" name="action" value="add_note">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
            <textarea name="note" rows="3" required placeholder="Add staff observation, telephone discussion note, or next steps..."
                      class="w-full bg-surface border border-outline-variant rounded-lg p-3 text-xs text-primary focus:outline-none focus:border-tertiary-fixed-dim"></textarea>
            <div class="text-right">
              <button type="submit" class="bg-surface-container-high hover:bg-surface-container text-primary font-bold px-3 py-1.5 rounded text-xs transition-colors">
                + Add Internal Note
              </button>
            </div>
          </form>

          <!-- Notes List -->
          <?php if (empty($notes)): ?>
            <p class="text-xs text-on-surface-variant italic">No internal notes logged for this prospect yet.</p>
          <?php else: ?>
            <div class="space-y-3">
              <?php foreach ($notes as $nt): ?>
                <div class="p-3 bg-surface border border-outline-variant/70 rounded-lg text-xs">
                  <div class="flex items-center justify-between font-bold text-primary mb-1">
                    <span><?= htmlspecialchars($nt['author_name'], ENT_QUOTES, 'UTF-8') ?></span>
                    <span class="text-on-surface-variant font-normal font-mono text-[11px]">
                      <?= date('d M Y, H:i', strtotime($nt['created_at'])) ?>
                    </span>
                  </div>
                  <p class="text-on-surface whitespace-pre-line leading-relaxed"><?= htmlspecialchars($nt['note'], ENT_QUOTES, 'UTF-8') ?></p>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

      </div>

      <!-- Right Column: Follow-Up Timeline & Custom Action -->
      <div class="lg:col-span-5 space-y-6">

        <!-- Scheduled & Sent Follow-up Timeline -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
          <div class="flex items-center justify-between mb-4 pb-2 border-b border-outline-variant">
            <h2 class="text-base font-bold text-primary">Follow-Up Timeline</h2>
            <span class="text-xs text-on-surface-variant"><?= count($followUps) ?> action(s)</span>
          </div>

          <?php if (empty($followUps)): ?>
            <p class="text-xs text-on-surface-variant">No follow-ups currently scheduled for this lead.</p>
          <?php else: ?>
            <div class="space-y-4">
              <?php foreach ($followUps as $fu): ?>
                <?php
                  $isPending = ($fu['status'] === 'pending');
                  $isSent    = ($fu['status'] === 'sent');
                  $isFailed  = ($fu['status'] === 'failed');
                  $isCancel  = ($fu['status'] === 'cancelled');

                  $statusBadgeClass = 'bg-gray-100 text-gray-700';
                  if ($isPending) $statusBadgeClass = 'bg-amber-100 text-amber-800';
                  if ($isSent)    $statusBadgeClass = 'bg-emerald-100 text-emerald-800';
                  if ($isFailed)  $statusBadgeClass = 'bg-rose-100 text-rose-800';
                  if ($isCancel)  $statusBadgeClass = 'bg-slate-100 text-slate-500 line-through';
                ?>
                <div class="p-3.5 border border-outline-variant rounded-lg bg-surface relative">
                  <div class="flex items-start justify-between gap-2">
                    <div>
                      <span class="inline-block px-2 py-0.5 rounded text-[11px] font-bold uppercase tracking-wider <?= $statusBadgeClass ?>">
                        <?= htmlspecialchars($fu['status'], ENT_QUOTES, 'UTF-8') ?>
                      </span>
                      <h3 class="text-xs font-bold text-primary mt-1.5 font-mono">
                        <?= htmlspecialchars($fu['template_key'] ?: $fu['type'], ENT_QUOTES, 'UTF-8') ?>
                      </h3>
                    </div>
                    <span class="text-[11px] text-on-surface-variant font-mono">
                      <?= htmlspecialchars($fu['type'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                  </div>

                  <div class="mt-2 text-xs text-on-surface-variant space-y-0.5">
                    <p><strong>Scheduled:</strong> <?= date('d M Y, H:i', strtotime($fu['scheduled_for'])) ?></p>
                    <?php if (!empty($fu['sent_at'])): ?>
                      <p class="text-emerald-700"><strong>Dispatched:</strong> <?= date('d M Y, H:i', strtotime($fu['sent_at'])) ?></p>
                    <?php endif; ?>
                    <?php if (!empty($fu['error_message'])): ?>
                      <p class="text-error text-[11px]"><strong>Note:</strong> <?= htmlspecialchars($fu['error_message'], ENT_QUOTES, 'UTF-8') ?></p>
                    <?php endif; ?>
                  </div>

                  <!-- Action Buttons for Pending Items -->
                  <?php if ($isPending): ?>
                    <div class="mt-3 pt-2.5 border-t border-outline-variant/60 flex items-center justify-end gap-2">
                      <form method="POST" action="lead.php?id=<?= $lead['id'] ?>" class="inline">
                        <input type="hidden" name="action" value="send_followup_now">
                        <input type="hidden" name="follow_up_id" value="<?= $fu['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="bg-tertiary-fixed text-on-tertiary-fixed text-xs font-bold px-2.5 py-1 rounded hover:opacity-90">
                          Send Now
                        </button>
                      </form>

                      <form method="POST" action="lead.php?id=<?= $lead['id'] ?>" class="inline">
                        <input type="hidden" name="action" value="cancel_followup">
                        <input type="hidden" name="follow_up_id" value="<?= $fu['id'] ?>">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
                        <button type="submit" class="bg-surface-container-high text-on-surface-variant text-xs font-bold px-2.5 py-1 rounded hover:bg-surface-container">
                          Cancel
                        </button>
                      </form>
                    </div>
                  <?php endif; ?>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- Schedule New Follow-up Action -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
          <h2 class="text-base font-bold text-primary mb-4 pb-2 border-b border-outline-variant">Schedule Outreach / Manual Email</h2>

          <form method="POST" action="lead.php?id=<?= $lead['id'] ?>" class="space-y-3">
            <input type="hidden" name="action" value="create_custom_followup">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

            <div>
              <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Action Type</label>
              <select name="type" class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-xs text-primary focus:outline-none focus:border-tertiary-fixed-dim">
                <option value="manual_email">Custom Email</option>
                <option value="call">Phone Call Follow-Up</option>
                <option value="note">Reminder Task</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Subject (if email)</label>
              <input type="text" name="custom_subject" placeholder="Update on your consultation..."
                     class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-xs text-primary focus:outline-none focus:border-tertiary-fixed-dim">
            </div>

            <div>
              <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Message / Instructions</label>
              <textarea name="custom_message" rows="3" placeholder="Write custom email message or task notes..."
                        class="w-full bg-surface border border-outline-variant rounded-lg p-2.5 text-xs text-primary focus:outline-none focus:border-tertiary-fixed-dim"></textarea>
            </div>

            <div>
              <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Scheduled Date &amp; Time</label>
              <input type="text" name="schedule_time" value="<?= date('Y-m-d H:i:s', time() + 3600) ?>"
                     class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-xs text-primary font-mono focus:outline-none focus:border-tertiary-fixed-dim">
            </div>

            <div class="flex items-center gap-2 pt-1">
              <input type="checkbox" id="dispatch_now" name="dispatch_now" value="1" class="rounded border-outline-variant text-primary focus:ring-0">
              <label for="dispatch_now" class="text-xs text-primary font-bold">Dispatch email immediately (ignores scheduled date)</label>
            </div>

            <div class="pt-2 text-right">
              <button type="submit" class="bg-primary text-on-primary font-bold px-4 py-2 rounded-lg text-xs hover:opacity-90 transition-all">
                Queue Follow-Up
              </button>
            </div>
          </form>
        </div>

      </div>

    </div>

  </main>

</body>
</html>
