<?php
/**
 * Input validation helpers
 */

/**
 * Validate email format
 */
function isValidEmail(string $email): bool
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone — accepts digits, spaces, +, -, (, ) — min 8 chars
 */
function isValidPhone(string $phone): bool
{
    $cleaned = preg_replace('/[\s\-\+\(\)]/', '', $phone);
    return ctype_digit($cleaned) && strlen($cleaned) >= 8;
}

/**
 * Validate a date string (YYYY-MM-DD) — must be today or future
 */
function isValidFutureDate(string $dateStr): bool
{
    $d = DateTime::createFromFormat('Y-m-d', $dateStr);
    if (!$d || $d->format('Y-m-d') !== $dateStr) {
        return false;
    }
    $today = new DateTime('today');
    return $d >= $today;
}

/**
 * Validate time (HH:MM, 24h)
 */
function isValidTime(string $time): bool
{
    return preg_match('/^([01]\d|2[0-3]):[0-5]\d$/', $time) === 1;
}

/**
 * Validate an ENUM value against an allowed list
 */
function isValidEnum(string $value, array $allowed): bool
{
    return in_array($value, $allowed, true);
}

/**
 * Validate file extension + MIME against whitelist
 * Returns true if allowed, false otherwise.
 */
function isAllowedFile(string $originalName, string $tmpName): bool
{
    $allowedExtensions = [
        'pdf', 'doc', 'docx', 'xls', 'xlsx',
        'csv', 'txt', 'jpg', 'jpeg', 'png',
    ];
    $allowedMimes = [
        'application/pdf',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'text/csv',
        'text/plain',
        'image/jpeg',
        'image/png',
    ];

    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions, true)) {
        return false;
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime  = finfo_file($finfo, $tmpName);
    finfo_close($finfo);

    return in_array($mime, $allowedMimes, true);
}
