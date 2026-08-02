<?php

namespace App\Notifications\Concerns;

use Illuminate\Support\Facades\Log;

trait GuardsMailFromAddress
{
    /**
     * Append the 'mail' channel only if MAIL_FROM_ADDRESS is configured.
     * Logs a warning instead of failing silently when it is not, so a
     * missing config value shows up in the logs instead of just looking
     * like "the notification worked" (database channel still fires).
     */
    protected function channelsWithMail(array $channels = ['database']): array
    {
        $from = config('mail.from.address');

        if ($from && $from !== 'null') {
            $channels[] = 'mail';
        } else {
            Log::warning(static::class.': MAIL_FROM_ADDRESS is not configured, skipping the mail channel for this notification.');
        }

        return $channels;
    }
}
