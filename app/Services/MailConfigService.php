<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Config;

class MailConfigService
{
    /**
     * Applies SMTP settings from the database to Laravel's mailer.
     * Uses the first "connected" account, or the first account available.
     * Returns true if settings were applied, false if falling back to .env.
     */
    public static function applyFromSettings(): bool
    {
        $accountsJson = Setting::getValue('email_accounts', '[]');
        $accounts = json_decode($accountsJson, true) ?? [];

        $account = collect($accounts)->firstWhere('status', 'connected')
                ?? collect($accounts)->first();

        if (!$account || empty($account['smtpHost']) || empty($account['smtpUser']) || empty($account['smtpPass'])) {
            return false;
        }

        self::applyAccount($account);
        return true;
    }

    public static function applyAccount(array $account): void
    {
        $port = (int) ($account['smtpPort'] ?? 587);
        $encryption = $port === 465 ? 'smtps' : 'tls';

        Config::set('mail.mailers.smtp.host', $account['smtpHost']);
        Config::set('mail.mailers.smtp.port', $port);
        Config::set('mail.mailers.smtp.encryption', $encryption);
        Config::set('mail.mailers.smtp.username', $account['smtpUser']);
        Config::set('mail.mailers.smtp.password', $account['smtpPass']);
        Config::set('mail.from.address', $account['fromEmail'] ?? $account['smtpUser']);
        Config::set('mail.from.name', $account['fromName'] ?? 'TalentionHR');

        // Reset cached mailer instances so new config takes effect
        app()->forgetInstance('mail.manager');
        app()->forgetInstance('mailer');
    }
}
