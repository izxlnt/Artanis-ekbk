<?php

namespace App\Notifications\Channels;

use Illuminate\Notifications\Channels\MailChannel;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

/**
 * Mail channel for every notification: when the mail server cannot be reached
 * (e.g. "SSL: Handshake timed out" from postmaster.mygovuc.gov.my), log it and
 * carry on instead of turning the user's action into an error page. Mail is sent
 * during the request (QUEUE_CONNECTION=sync), after the form is already saved,
 * and the 'database' notification is still stored, so the in-app bell works.
 */
class ResilientMailChannel extends MailChannel
{
    public function send($notifiable, Notification $notification)
    {
        try {
            return parent::send($notifiable, $notification);
        } catch (\Swift_TransportException $e) {
            Log::warning('Notification email not sent: ' . get_class($notification)
                . ' to user #' . ($notifiable->id ?? '?') . ': ' . $e->getMessage());

            return null;
        }
    }
}
