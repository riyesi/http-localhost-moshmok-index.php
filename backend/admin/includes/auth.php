<?php
/**
 * Admin Authentication & Session Guard
 *
 * Enforces session-based authentication for administrative routes,
 * provides CSRF protection and view helpers for lead management.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Require valid administrator session; redirects to login if unauthenticated.
 *
 * @return array Current authenticated admin user details
 */
function requireAdminAuth(): array
{
    if (empty($_SESSION['admin_user']) || !is_array($_SESSION['admin_user'])) {
        header('Location: login.php');
        exit;
    }
    return $_SESSION['admin_user'];
}

/**
 * Returns current admin user or null.
 */
function getCurrentAdminUser(): ?array
{
    return $_SESSION['admin_user'] ?? null;
}

/**
 * Generate or retrieve CSRF token stored in admin session.
 */
function getAdminCsrfToken(): string
{
    if (empty($_SESSION['admin_csrf_token'])) {
        $_SESSION['admin_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['admin_csrf_token'];
}

/**
 * Verifies submitted CSRF token against session token.
 */
function verifyAdminCsrfToken(?string $token): bool
{
    if (empty($token) || empty($_SESSION['admin_csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['admin_csrf_token'], $token);
}

/**
 * Helper to display human-readable time elapsed.
 */
function timeAgo(?string $datetime): string
{
    if (empty($datetime)) {
        return 'Never';
    }
    $time = strtotime($datetime);
    $diff = time() - $time;
    if ($diff < 60) {
        return 'Just now';
    }
    if ($diff < 3600) {
        return round($diff / 60) . 'm ago';
    }
    if ($diff < 86400) {
        return round($diff / 3600) . 'h ago';
    }
    $days = round($diff / 86400);
    if ($days === 1) {
        return '1 day ago';
    }
    return "{$days} days ago";
}

/**
 * Render color-coded status badge HTML.
 */
function renderStatusBadge(string $status): string
{
    switch ($status) {
        case 'new':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">New</span>';
        case 'contacted':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Contacted</span>';
        case 'qualified':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">Qualified</span>';
        case 'converted':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Converted</span>';
        case 'lost':
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">Lost</span>';
        default:
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">' . htmlspecialchars($status, ENT_QUOTES, 'UTF-8') . '</span>';
    }
}

/**
 * Render color-coded source badge HTML.
 */
function renderSourceBadge(string $source): string
{
    $colors = [
        'booking'  => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        'training' => 'bg-amber-50 text-amber-700 border-amber-200',
        'contact'  => 'bg-teal-50 text-teal-700 border-teal-200',
        'upload'   => 'bg-sky-50 text-sky-700 border-sky-200',
        'manual'   => 'bg-slate-50 text-slate-700 border-slate-200',
    ];
    $cls = $colors[$source] ?? 'bg-gray-50 text-gray-700 border-gray-200';
    return '<span class="inline-flex items-center px-2 py-0.5 rounded border text-xs font-medium ' . $cls . '">' . ucfirst(htmlspecialchars($source, ENT_QUOTES, 'UTF-8')) . '</span>';
}

/**
 * Render score badge HTML with color coding.
 */
function renderScoreBadge(int $score): string
{
    if ($score >= 70) {
        $color = 'bg-emerald-100 text-emerald-800';
    } elseif ($score >= 40) {
        $color = 'bg-amber-100 text-amber-800';
    } else {
        $color = 'bg-gray-100 text-gray-700';
    }
    return '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold ' . $color . '">' . $score . ' / 100</span>';
}
