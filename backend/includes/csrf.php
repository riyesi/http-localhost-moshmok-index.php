<?php
/**
 * CSRF Protection Helper
 *
 * Provides cryptographic session-based CSRF tokens and timing-safe verification.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Generate or retrieve current session CSRF token.
 *
 * @return string 64-character hexadecimal token
 */
function getCsrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verifies submitted CSRF token against session token using timing-safe comparison.
 *
 * @param string|null $token Submitted token to verify
 * @return bool True if valid, false otherwise
 */
function verifyCsrfToken(?string $token): bool
{
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], (string)$token);
}
