<?php
/**
 * Admin Leads Dashboard
 *
 * Overview of all inbound leads, filtering by status and source,
 * sorting by timeline or score, quick follow-up trigger, and metrics.
 */

require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../includes/lead-service.php';

$user = requireAdminAuth();
$pdo = getDB();

$flashNotice = '';
$flashError = '';

// Handle manual trigger of follow-up cron from UI
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'run_cron') {
    if (verifyAdminCsrfToken($_POST['csrf_token'] ?? '')) {
        // Execute follow-up processing internally
        ob_start();
        include __DIR__ . '/../cron/process-follow-ups.php';
        ob_end_clean();
        $flashNotice = 'Follow-up engine executed successfully. Overdue pending emails were processed.';
    } else {
        $flashError = 'Invalid CSRF security token.';
    }
}

// ── Metrics Calculation ──────────────────────────────────────
$totalLeads = (int)$pdo->query("SELECT COUNT(*) FROM leads")->fetchColumn();
$newLeads = (int)$pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'new'")->fetchColumn();
$contactedLeads = (int)$pdo->query("SELECT COUNT(*) FROM leads WHERE status = 'contacted'")->fetchColumn();
$convertedLeads = (int)$pdo->query("SELECT COUNT(*) FROM leads WHERE status IN ('qualified', 'converted')")->fetchColumn();
$dueFollowUps = (int)$pdo->query("SELECT COUNT(*) FROM lead_follow_ups WHERE status = 'pending' AND scheduled_for <= NOW()")->fetchColumn();

// ── Query Filtering & Sorting ────────────────────────────────
$filterStatus = trim($_GET['status'] ?? '');
$filterSource = trim($_GET['source'] ?? '');
$search       = trim($_GET['q'] ?? '');
$sortBy       = trim($_GET['sort'] ?? 'created_desc');

$where = [];
$params = [];

if (!empty($filterStatus) && in_array($filterStatus, ['new', 'contacted', 'qualified', 'converted', 'lost'], true)) {
    $where[] = "l.status = :status";
    $params[':status'] = $filterStatus;
}

if (!empty($filterSource) && in_array($filterSource, ['booking', 'training', 'contact', 'upload', 'manual'], true)) {
    $where[] = "l.source_type = :source";
    $params[':source'] = $filterSource;
}

if (!empty($search)) {
    $where[] = "(l.full_name LIKE :s OR l.email LIKE :s OR l.phone LIKE :s OR l.service_interest LIKE :s)";
    $params[':s'] = '%' . $search . '%';
}

$whereSql = !empty($where) ? ('WHERE ' . implode(' AND ', $where)) : '';

switch ($sortBy) {
    case 'created_asc':
        $orderSql = "ORDER BY l.created_at ASC";
        break;
    case 'score_desc':
        $orderSql = "ORDER BY l.score DESC, l.created_at DESC";
        break;
    case 'next_followup':
        // Overdue and upcoming first, nulls last
        $orderSql = "ORDER BY (l.next_follow_up_at IS NULL), l.next_follow_up_at ASC";
        break;
    case 'created_desc':
    default:
        $orderSql = "ORDER BY l.created_at DESC";
        break;
}

$stmt = $pdo->prepare("
    SELECT l.*, 
           u.full_name AS assignee_name,
           (SELECT COUNT(*) FROM lead_follow_ups fu WHERE fu.lead_id = l.id AND fu.status = 'pending') AS pending_followups_count
    FROM leads l
    LEFT JOIN admin_users u ON l.assigned_to = u.id
    {$whereSql}
    {$orderSql}
    LIMIT 100
");
$stmt->execute($params);
$leads = $stmt->fetchAll();

$csrfToken = getAdminCsrfToken();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leads Management Dashboard — Financial Precision</title>
  <link rel="stylesheet" href="../../assets/css/styles.css">
  <style>
    .badge-overdue {
      animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.6; }
    }
  </style>
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
        <div class="text-right hidden sm:block">
          <p class="text-xs text-on-surface-variant">Signed in as</p>
          <p class="text-sm font-bold text-primary leading-tight">
            <?= htmlspecialchars($user['full_name'], ENT_QUOTES, 'UTF-8') ?>
            <span class="text-xs font-normal text-on-surface-variant font-mono">(<?= htmlspecialchars($user['role'], ENT_QUOTES, 'UTF-8') ?>)</span>
          </p>
        </div>
        <a href="../../index.php" target="_blank" class="text-xs text-on-surface-variant hover:text-primary border border-outline-variant px-2.5 py-1.5 rounded transition-colors hidden md:inline-flex items-center gap-1">
          <span>View Site</span> &nearr;
        </a>
        <a href="logout.php" class="text-xs bg-surface-container-high hover:bg-surface-container text-primary font-bold px-3 py-1.5 rounded transition-colors">
          Log Out
        </a>
      </div>
    </div>
  </header>

  <!-- Main Content Container -->
  <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Flash notifications -->
    <?php if (!empty($flashNotice)): ?>
      <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-900 rounded-lg flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2">
          <span class="font-bold text-emerald-700">&#10003;</span>
          <span><?= htmlspecialchars($flashNotice, ENT_QUOTES, 'UTF-8') ?></span>
        </div>
        <a href="dashboard.php" class="text-xs font-bold text-emerald-700 hover:underline">Dismiss</a>
      </div>
    <?php endif; ?>

    <?php if (!empty($flashError)): ?>
      <div class="p-4 bg-error-container border border-error/20 text-on-error-container rounded-lg flex items-center gap-2 shadow-sm">
        <span class="font-bold text-error">&#9888;</span>
        <span><?= htmlspecialchars($flashError, ENT_QUOTES, 'UTF-8') ?></span>
      </div>
    <?php endif; ?>

    <!-- Title & Quick Run Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-2xl font-bold text-primary tracking-tight">Inbound Leads &amp; Follow-Up Queue</h1>
        <p class="text-sm text-on-surface-variant mt-0.5">Track prospects, monitor automated nurturing sequences, and convert client inquiries.</p>
      </div>

      <div class="flex items-center gap-3">
        <form method="POST" action="dashboard.php" class="inline">
          <input type="hidden" name="action" value="run_cron">
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
          <button type="submit" 
                  title="Checks for pending follow-ups where scheduled_for <= NOW() and dispatches emails"
                  class="inline-flex items-center gap-2 bg-tertiary-fixed text-on-tertiary-fixed px-4 py-2 rounded-lg font-label-md text-sm font-bold hover:opacity-90 transition-all shadow-sm">
            <span>&#9654;</span>
            <span>Process Due Follow-Ups (<?= $dueFollowUps ?> due)</span>
          </button>
        </form>
      </div>
    </div>

    <!-- Stats Overview Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
      <!-- Total -->
      <a href="dashboard.php" class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl hover:border-primary/40 transition-colors">
        <span class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider block">Total Leads</span>
        <span class="text-2xl font-bold text-primary mt-1 block"><?= $totalLeads ?></span>
      </a>

      <!-- New -->
      <a href="dashboard.php?status=new" class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl hover:border-emerald-400 transition-colors">
        <span class="text-xs font-semibold text-emerald-800 uppercase tracking-wider block">New / Uncontacted</span>
        <span class="text-2xl font-bold text-emerald-700 mt-1 block"><?= $newLeads ?></span>
      </a>

      <!-- Contacted -->
      <a href="dashboard.php?status=contacted" class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl hover:border-blue-400 transition-colors">
        <span class="text-xs font-semibold text-blue-800 uppercase tracking-wider block">Contacted</span>
        <span class="text-2xl font-bold text-blue-700 mt-1 block"><?= $contactedLeads ?></span>
      </a>

      <!-- Converted / Qualified -->
      <a href="dashboard.php?status=converted" class="bg-surface-container-lowest border border-outline-variant p-4 rounded-xl hover:border-green-400 transition-colors">
        <span class="text-xs font-semibold text-green-800 uppercase tracking-wider block">Qualified / Won</span>
        <span class="text-2xl font-bold text-green-700 mt-1 block"><?= $convertedLeads ?></span>
      </a>

      <!-- Follow-Ups Due -->
      <div class="bg-surface-container-lowest border <?= $dueFollowUps > 0 ? 'border-amber-400 bg-amber-50/30' : 'border-outline-variant' ?> p-4 rounded-xl">
        <span class="text-xs font-semibold text-amber-900 uppercase tracking-wider block">Emails Due Now</span>
        <span class="text-2xl font-bold <?= $dueFollowUps > 0 ? 'text-amber-700' : 'text-primary' ?> mt-1 block"><?= $dueFollowUps ?></span>
      </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm">
      <form method="GET" action="dashboard.php" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <!-- Search -->
        <div class="lg:col-span-2">
          <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Search Lead</label>
          <input type="text" name="q" value="<?= htmlspecialchars($search, ENT_QUOTES, 'UTF-8') ?>"
                 placeholder="Name, email, phone, or service..."
                 class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-sm text-primary focus:outline-none focus:border-tertiary-fixed-dim">
        </div>

        <!-- Filter Status -->
        <div>
          <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Status</label>
          <select name="status" class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-sm text-primary focus:outline-none focus:border-tertiary-fixed-dim">
            <option value="">All Statuses</option>
            <option value="new" <?= $filterStatus === 'new' ? 'selected' : '' ?>>New</option>
            <option value="contacted" <?= $filterStatus === 'contacted' ? 'selected' : '' ?>>Contacted</option>
            <option value="qualified" <?= $filterStatus === 'qualified' ? 'selected' : '' ?>>Qualified</option>
            <option value="converted" <?= $filterStatus === 'converted' ? 'selected' : '' ?>>Converted</option>
            <option value="lost" <?= $filterStatus === 'lost' ? 'selected' : '' ?>>Lost</option>
          </select>
        </div>

        <!-- Filter Source -->
        <div>
          <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Source</label>
          <select name="source" class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-sm text-primary focus:outline-none focus:border-tertiary-fixed-dim">
            <option value="">All Sources</option>
            <option value="booking" <?= $filterSource === 'booking' ? 'selected' : '' ?>>Booking Request</option>
            <option value="training" <?= $filterSource === 'training' ? 'selected' : '' ?>>Training Sign-up</option>
            <option value="contact" <?= $filterSource === 'contact' ? 'selected' : '' ?>>Contact Enquiry</option>
            <option value="upload" <?= $filterSource === 'upload' ? 'selected' : '' ?>>Document Upload</option>
          </select>
        </div>

        <!-- Sort By -->
        <div>
          <label class="block text-xs font-bold text-on-surface-variant uppercase mb-1">Sort By</label>
          <div class="flex gap-2">
            <select name="sort" class="w-full bg-surface border border-outline-variant rounded-lg px-3 py-2 text-sm text-primary focus:outline-none focus:border-tertiary-fixed-dim">
              <option value="created_desc" <?= $sortBy === 'created_desc' ? 'selected' : '' ?>>Newest Created</option>
              <option value="created_asc" <?= $sortBy === 'created_asc' ? 'selected' : '' ?>>Oldest Created</option>
              <option value="score_desc" <?= $sortBy === 'score_desc' ? 'selected' : '' ?>>Highest Score</option>
              <option value="next_followup" <?= $sortBy === 'next_followup' ? 'selected' : '' ?>>Next Follow-Up</option>
            </select>
            <button type="submit" class="bg-primary text-on-primary font-bold px-3 py-2 rounded-lg text-sm hover:opacity-90">
              Filter
            </button>
          </div>
        </div>
      </form>
    </div>

    <!-- Leads Table -->
    <div class="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm overflow-hidden">
      <?php if (empty($leads)): ?>
        <div class="p-12 text-center">
          <p class="text-base text-primary font-bold">No leads found matching your criteria</p>
          <p class="text-xs text-on-surface-variant mt-1">Try resetting filters or submitting a test form from the website.</p>
          <a href="dashboard.php" class="mt-4 inline-block text-xs bg-surface-container-high px-3 py-1.5 rounded font-bold text-primary hover:bg-surface-container">
            Clear Filters
          </a>
        </div>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-surface-container-low text-xs font-bold uppercase text-on-surface-variant tracking-wider border-b border-outline-variant">
                <th class="py-3 px-4">Lead / Contact</th>
                <th class="py-3 px-4">Source</th>
                <th class="py-3 px-4">Service Interest</th>
                <th class="py-3 px-4">Score</th>
                <th class="py-3 px-4">Status</th>
                <th class="py-3 px-4">Last Contact</th>
                <th class="py-3 px-4">Next Follow-Up</th>
                <th class="py-3 px-4 text-right">Action</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/60 text-sm">
              <?php foreach ($leads as $lead): ?>
                <?php
                  $isOverdue = false;
                  $nextFormatted = 'None';
                  if (!empty($lead['next_follow_up_at'])) {
                      $nextTimestamp = strtotime($lead['next_follow_up_at']);
                      $isOverdue = ($nextTimestamp <= time() && in_array($lead['status'], ['new', 'contacted'], true));
                      $nextFormatted = date('d M Y, H:i', $nextTimestamp);
                  }
                ?>
                <tr class="hover:bg-surface-container-low/50 transition-colors">
                  <!-- Name & Contact -->
                  <td class="py-3.5 px-4">
                    <a href="lead.php?id=<?= $lead['id'] ?>" class="font-bold text-primary hover:underline block">
                      <?= htmlspecialchars($lead['full_name'], ENT_QUOTES, 'UTF-8') ?>
                    </a>
                    <span class="text-xs text-on-surface-variant block font-mono">
                      <?= htmlspecialchars($lead['email'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <?php if (!empty($lead['phone'])): ?>
                      <span class="text-xs text-on-surface-variant block">
                        <?= htmlspecialchars($lead['phone'], ENT_QUOTES, 'UTF-8') ?>
                      </span>
                    <?php endif; ?>
                  </td>

                  <!-- Source -->
                  <td class="py-3.5 px-4 whitespace-nowrap">
                    <?= renderSourceBadge($lead['source_type']) ?>
                  </td>

                  <!-- Service Interest -->
                  <td class="py-3.5 px-4">
                    <span class="text-xs text-primary font-medium">
                      <?= htmlspecialchars($lead['service_interest'], ENT_QUOTES, 'UTF-8') ?>
                    </span>
                  </td>

                  <!-- Score -->
                  <td class="py-3.5 px-4 whitespace-nowrap">
                    <?= renderScoreBadge((int)$lead['score']) ?>
                  </td>

                  <!-- Status -->
                  <td class="py-3.5 px-4 whitespace-nowrap">
                    <?= renderStatusBadge($lead['status']) ?>
                  </td>

                  <!-- Last Contacted -->
                  <td class="py-3.5 px-4 whitespace-nowrap text-xs text-on-surface-variant">
                    <?= timeAgo($lead['last_contacted_at']) ?>
                  </td>

                  <!-- Next Follow-up -->
                  <td class="py-3.5 px-4 whitespace-nowrap text-xs">
                    <?php if ($isOverdue): ?>
                      <span class="inline-flex items-center gap-1 font-bold text-amber-700 bg-amber-100 px-2 py-0.5 rounded badge-overdue">
                        <span>&#9888;</span> Due: <?= $nextFormatted ?>
                      </span>
                    <?php elseif (!empty($lead['next_follow_up_at'])): ?>
                      <span class="text-on-surface-variant">
                        <?= $nextFormatted ?>
                      </span>
                    <?php else: ?>
                      <span class="text-gray-400">Completed / None</span>
                    <?php endif; ?>
                  </td>

                  <!-- Actions -->
                  <td class="py-3.5 px-4 text-right whitespace-nowrap">
                    <a href="lead.php?id=<?= $lead['id'] ?>"
                       class="inline-block text-xs bg-surface-container-high hover:bg-tertiary-fixed hover:text-on-tertiary-fixed text-primary font-bold px-3 py-1.5 rounded transition-all">
                      Manage &rarr;
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div class="p-3 bg-surface-container-low border-t border-outline-variant text-xs text-on-surface-variant text-right">
          Showing <?= count($leads) ?> lead(s)
        </div>
      <?php endif; ?>
    </div>

  </main>

</body>
</html>
