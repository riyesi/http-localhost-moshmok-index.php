<?php
/**
 * Database configuration — PDO connection (singleton)
 *
 * IMPORTANT: Before going live, replace the placeholder values below
 * with real credentials. This file should be in .gitignore.
 */

// ── credentials ──────────────────────────────────────────────
define('DB_HOST', '127.0.0.1');       // XAMPP MySQL host
define('DB_PORT', '3306');
define('DB_NAME', 'moshmok_db');
define('DB_USER', 'root');            // XAMPP default
define('DB_PASS', '');                // XAMPP default — set a password in production
define('DB_CHARSET', 'utf8mb4');

// ── PDO singleton ────────────────────────────────────────────
function getDB(): PDO
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            DB_HOST, DB_PORT, DB_NAME, DB_CHARSET
        );
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }
    return $pdo;
}
