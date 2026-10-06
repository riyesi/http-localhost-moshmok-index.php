<?php
/**
 * Production Environment Configuration
 *
 * ---------------------------------------------------------------
 * INSTRUCTIONS FOR HOSTING PROVIDER SETUP
 * ---------------------------------------------------------------
 *
 * 1. Copy this file to backend/config/db.php on your server.
 * 2. Fill in ALL values marked with: <<< CHANGE THIS
 * 3. NEVER commit real credentials to version control.
 * 4. Ensure this file is NOT publicly accessible via HTTP.
 *    (The backend/config/.htaccess blocks it.)
 *
 * Hosting tested on: cPanel (SiteGround, Hostgator), Plesk,
 * Cloudways, DigitalOcean (Apache/Nginx with PHP-FPM).
 * ---------------------------------------------------------------
 */

// -- Database credentials --------------------------------------
define('DB_HOST',    '127.0.0.1');          // Usually localhost or 127.0.0.1
define('DB_PORT',    '3306');               // Standard MySQL/MariaDB port
define('DB_NAME',    'moshmok_db');         // <<< CHANGE THIS — your DB name
define('DB_USER',    'root');               // <<< CHANGE THIS — your DB username
define('DB_PASS',    '');                   // <<< CHANGE THIS — your DB password
define('DB_CHARSET', 'utf8mb4');

// -- Application settings -------------------------------------
define('APP_ENV',    'production');         // 'development' | 'production'
define('APP_DEBUG',  false);               // MUST be false in production

// -- Email settings --------------------------------------------
// Replace with your actual business email address.
// For SMTP, install PHPMailer via Composer and update mailer.php.
define('PRACTICE_EMAIL', 'info@moshmokbusinessenter-prise.me');
define('PRACTICE_NAME',  'Financial Precision');
define('SITE_NAME',      'Professional Financial & Training Solutions');

// -- Session security ------------------------------------------
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure',   1);   // Requires HTTPS — set 0 if not yet on SSL
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');

// -- Error handling: log only, never display -------------------
if (APP_DEBUG === false) {
    ini_set('display_errors',         '0');
    ini_set('display_startup_errors', '0');
    ini_set('log_errors',             '1');
    error_reporting(E_ALL);
}

// -- PDO singleton ---------------------------------------------
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
