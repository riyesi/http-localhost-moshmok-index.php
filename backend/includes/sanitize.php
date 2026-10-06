<?php
/**
 * Input sanitisation helpers
 */

require_once __DIR__ . '/csrf.php';

/**
 * Trim, strip tags, and encode for safe storage/display
 */
function sanitizeString(string $input): string
{
    return htmlspecialchars(trim(strip_tags($input)), ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitise a full array of POST data (recursive)
 */
function sanitizeArray(array $data): array
{
    $clean = [];
    foreach ($data as $key => $value) {
        if (is_string($value)) {
            $clean[$key] = sanitizeString($value);
        } elseif (is_array($value)) {
            $clean[$key] = sanitizeArray($value);
        } else {
            $clean[$key] = $value;
        }
    }
    return $clean;
}

/**
 * Generate a safe random string for CSRF / filenames
 */
function generateToken(int $length = 32): string
{
    return bin2hex(random_bytes($length));
}
