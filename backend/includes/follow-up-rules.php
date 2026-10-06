<?php
/**
 * Follow-Up Rules Configuration
 *
 * Configures the automated follow-up sequences for inbound leads:
 * 1. Immediate: Welcome / confirmation email right away
 * 2. +24h: Reminder #1 (allowed only if status is 'new')
 * 3. +72h: Reminder #2 (allowed if status is 'new' or 'contacted')
 * 4. +7 days: Final reminder (allowed if status is 'new' or 'contacted')
 *
 * If lead status transitions to 'qualified', 'converted', or 'lost',
 * pending automated follow-ups are cancelled.
 */

if (!defined('FOLLOW_UP_RULES_LOADED')) {
    define('FOLLOW_UP_RULES_LOADED', true);
}

/**
 * Returns the configured automated follow-up schedule.
 *
 * @return array<int, array{key: string, type: string, delay_seconds: int, allowed_statuses: array<string>, title: string}>
 */
function getFollowUpRulesConfig(): array
{
    return [
        [
            'key'              => 'immediate_welcome',
            'type'             => 'auto_email',
            'delay_seconds'    => 0,                       // Immediate (0 seconds)
            'allowed_statuses' => ['new'],
            'title'            => 'Immediate Welcome & Acknowledgment',
        ],
        [
            'key'              => 'reminder_24h',
            'type'             => 'auto_email',
            'delay_seconds'    => 24 * 3600,               // +24 hours
            'allowed_statuses' => ['new'],
            'title'            => '24-Hour Consultation & Service Reminder',
        ],
        [
            'key'              => 'reminder_72h',
            'type'             => 'auto_email',
            'delay_seconds'    => 72 * 3600,               // +72 hours (3 days)
            'allowed_statuses' => ['new', 'contacted'],
            'title'            => '72-Hour Advisory Value & Check-in',
        ],
        [
            'key'              => 'reminder_7d',
            'type'             => 'auto_email',
            'delay_seconds'    => 7 * 24 * 3600,           // +7 days (1 week)
            'allowed_statuses' => ['new', 'contacted'],
            'title'            => '7-Day Final Follow-up Outreach',
        ],
    ];
}

/**
 * Checks if a specific template is permitted to fire given the current lead status.
 *
 * @param string $templateKey
 * @param string $leadStatus ('new', 'contacted', 'qualified', 'converted', 'lost')
 * @return bool
 */
function isFollowUpAllowedForLeadStatus(string $templateKey, string $leadStatus): bool
{
    // Leads that are qualified, converted, or lost must never receive automated reminders
    if (in_array($leadStatus, ['qualified', 'converted', 'lost'], true)) {
        return false;
    }

    $rules = getFollowUpRulesConfig();
    foreach ($rules as $rule) {
        if ($rule['key'] === $templateKey) {
            return in_array($leadStatus, $rule['allowed_statuses'], true);
        }
    }

    // Default to true for unrecognized/custom templates unless lead is terminal
    return true;
}
