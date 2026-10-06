<?php
/**
 * Follow-Up Email Templates
 *
 * Professional HTML email templates for lead nurturing sequences.
 * Integrates with wrapEmail() from mailer.php.
 */

require_once __DIR__ . '/mailer.php';

/**
 * Render email subject and HTML body for a given follow-up template.
 *
 * @param string $templateKey
 * @param array $lead Associative array with lead data (full_name, email, service_interest, source_type, etc.)
 * @param array $extra Optional context or custom message
 * @return array{subject: string, body: string}
 */
function renderFollowUpTemplate(string $templateKey, array $lead, array $extra = []): array
{
    $name = htmlspecialchars($lead['full_name'] ?? 'Valued Client', ENT_QUOTES, 'UTF-8');
    $service = htmlspecialchars($lead['service_interest'] ?? 'our services', ENT_QUOTES, 'UTF-8');
    $sourceType = $lead['source_type'] ?? 'enquiry';
    $practiceName = PRACTICE_NAME;
    $practiceEmail = PRACTICE_EMAIL;

    switch ($templateKey) {
        case 'immediate_welcome':
            $subject = SITE_NAME . " — Thank You for Reaching Out";
            $content = "
                <p>Dear <strong>{$name}</strong>,</p>
                <p>Thank you for submitting your request regarding <strong>{$service}</strong>.</p>
                <p>We have assigned your inquiry to our advisory and compliance team in Johannesburg. One of our specialists will review your requirements and reach out within <strong>24 business hours</strong>.</p>
                <div style='background:#f0f3ff;border-left:4px solid #002200;padding:12px 16px;margin:20px 0;'>
                    <p style='margin:0;font-weight:bold;color:#002200;'>What happens next?</p>
                    <p style='margin:4px 0 0 0;font-size:14px;color:#45464d;'>We will review your request against our practice schedule and get in touch with preliminary insights or confirmation.</p>
                </div>
                <p>If you have urgent questions, you can contact us directly by replying to this email or calling our Johannesburg office.</p>
                <p>Kind regards,<br><strong>{$practiceName} Team</strong></p>
            ";
            break;

        case 'reminder_24h':
            $subject = "Follow-Up: Your Consultation & Request with " . $practiceName;
            $content = "
                <p>Dear <strong>{$name}</strong>,</p>
                <p>We hope your day is going well. We wanted to follow up on your recent enquiry regarding <strong>{$service}</strong>.</p>
                <p>Our team is available to assist you with compliance evaluations, SARS matters, accounting setup, or corporate training scheduling.</p>
                <p>Would you like to schedule a quick 15-minute introductory call with one of our senior advisors to discuss your exact requirements?</p>
                <p>Simply reply directly to this email with your preferred time, or let us know if you need any additional practice documentation.</p>
                <p>Warm regards,<br><strong>Client Relations Team</strong><br>{$practiceName}</p>
            ";
            break;

        case 'reminder_72h':
            $subject = "Tailored Solutions for Your Business — " . $practiceName;
            $content = "
                <p>Dear <strong>{$name}</strong>,</p>
                <p>A few days ago, you connected with us regarding <strong>{$service}</strong>.</p>
                <p>At <strong>{$practiceName}</strong>, we pride ourselves on helping South African enterprises and professionals navigate statutory compliance, optimize tax efficiency, and elevate skills through accredited training.</p>
                <p>Here are a few ways we can fast-track your objectives:</p>
                <ul style='color:#111c2c;padding-left:20px;'>
                    <li>Comprehensive statutory compliance & SARS audit support</li>
                    <li>Accredited training in corporate governance, financial reporting & AML</li>
                    <li>Strategic bookkeeping, payroll and monthly management reporting</li>
                </ul>
                <p>We would love to learn more about your immediate priorities. Are you available for a brief conversation this week?</p>
                <p>Best regards,<br><strong>Senior Advisory Services</strong><br>{$practiceName}</p>
            ";
            break;

        case 'reminder_7d':
            $subject = "Checking In: How Can We Assist You? — " . $practiceName;
            $content = "
                <p>Dear <strong>{$name}</strong>,</p>
                <p>We are checking in one last time regarding your enquiry on <strong>{$service}</strong>.</p>
                <p>We understand that business schedules can be demanding. Whether you are actively preparing for an upcoming audit, training your finance team, or simply exploring options for the next financial year, our doors remain open.</p>
                <p>If you are still interested, please reply to this message and we will gladly arrange a consultation at your convenience.</p>
                <p>Thank you for considering {$practiceName}, and we wish you continued success.</p>
                <p>Kind regards,<br><strong>Practice Management</strong><br>{$practiceName}</p>
            ";
            break;

        case 'manual_email':
        default:
            $customSubject = !empty($extra['subject']) ? $extra['subject'] : (SITE_NAME . " — Update on Your Request");
            $customBody = !empty($extra['message']) ? nl2br(htmlspecialchars($extra['message'], ENT_QUOTES, 'UTF-8')) : "Thank you for contacting {$practiceName}.";
            $subject = $customSubject;
            $content = "
                <p>Dear <strong>{$name}</strong>,</p>
                <div>{$customBody}</div>
                <p style='margin-top:24px;'>Kind regards,<br><strong>{$practiceName}</strong></p>
            ";
            break;
    }

    $wrappedHtml = wrapEmail($subject, $content);
    return [
        'subject' => $subject,
        'body'    => $wrappedHtml,
    ];
}
