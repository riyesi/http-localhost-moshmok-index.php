<?php
/**
 * Email notification helper
 *
 * Uses PHP mail() — works with XAMPP Mercury Mail or any configured MTA.
 * For production, swap to PHPMailer + SMTP relay (e.g. SendGrid, Mailgun).
 */

// -- Configurable addresses -----------------------------------
define('PRACTICE_EMAIL', 'info@moshmokbusinessenter-prise.me');
define('PRACTICE_NAME',  'Financial Precision');
define('SITE_NAME',      'Professional Financial & Training Solutions');

/**
 * Send an email via PHP mail()
 *
 * @param string $to       Recipient email
 * @param string $subject  Subject line
 * @param string $body     HTML body
 * @return bool
 */
function sendEmail(string $to, string $subject, string $body): bool
{
    $headers  = "MIME-Version: 1.0\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    $headers .= "From: " . SITE_NAME . " <" . PRACTICE_EMAIL . ">\r\n";
    $headers .= "Reply-To: " . PRACTICE_EMAIL . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // In XAMPP, sendmail.exe is bundled. To enable it, set sendmail_path in php.ini.
    // In production with no local MTA, replace with PHPMailer + SMTP relay.
    // Use @ to suppress warnings: a failed email must NOT corrupt the JSON
    // response or block the already-saved database record.
    $ok = @mail($to, $subject, $body, $headers);

    if (!$ok) {
        // Log quietly for the site administrator instead of emitting warnings.
        error_log('Mail send failed to: ' . $to . ' Subject: ' . $subject);
    }

    return $ok;
}

/**
 * Generic HTML email wrapper
 */
function wrapEmail(string $title, string $content): string
{
    $year = date('Y');
    return <<<HTML
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"></head>
<body style="margin:0;padding:0;background:#f5f5f5;font-family:Arial,Helvetica,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background:#f5f5f5;padding:32px 0;">
    <tr><td align="center">
      <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:8px;overflow:hidden;">
        <tr><td style="background:#002200;padding:24px 32px;color:#ffffff;font-size:20px;font-weight:bold;">
          {$title}
        </td></tr>
        <tr><td style="padding:32px;color:#111c2c;font-size:15px;line-height:1.6;">
          {$content}
        </td></tr>
        <tr><td style="background:#f0f3ff;padding:16px 32px;color:#45464d;font-size:12px;text-align:center;">
          &copy; {$year} Professional Financial &amp; Training Solutions. All rights reserved.
        </td></tr>
      </table>
    </td></tr>
  </table>
</body>
</html>
HTML;
}

/**
 * Client confirmation email
 */
function sendClientConfirmation(string $email, string $name, string $type, string $extra = ''): bool
{
    $subject = SITE_NAME . ' — ' . ucfirst($type) . ' Received';
    $content = "
        <p>Dear <strong>{$name}</strong>,</p>
        <p>Thank you for your {$type}. We have received your submission and our team will review it shortly.</p>
        <p>You can expect a response within <strong>24 business hours</strong>.</p>
        {$extra}
        <p>If you need immediate assistance, please call us or reply to this email.</p>
        <p>Kind regards,<br><strong>" . PRACTICE_NAME . "</strong></p>
    ";
    return sendEmail($email, $subject, wrapEmail($type . ' Confirmation', $content));
}

/**
 * Practice notification email
 */
function sendPracticeNotification(string $type, string $name, string $email, string $details): bool
{
    $subject = "[New {$type}] from {$name}";
    $content = "
        <p><strong>New {$type} submission</strong></p>
        <table style='width:100%;border-collapse:collapse;margin:16px 0;'>
            <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;width:140px;'>Name</td>
                <td style='padding:8px;border:1px solid #c5c6ce;'>{$name}</td></tr>
            <tr><td style='padding:8px;border:1px solid #c5c6ce;background:#f0f3ff;font-weight:bold;'>Email</td>
                <td style='padding:8px;border:1px solid #c5c6ce;'>{$email}</td></tr>
            {$details}
        </table>
        <p style='color:#45464d;font-size:13px;'>This is an automated notification from the website.</p>
    ";
    return sendEmail(PRACTICE_EMAIL, $subject, wrapEmail("New {$type} Notification", $content));
}
