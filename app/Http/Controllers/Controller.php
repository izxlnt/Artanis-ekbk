<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * BorangDiHantar notifications are write-once - nothing ever marks them read
     * except the user clicking the exact bell item (NotifikasiKilangController::
     * redirect_notification). PHD's normal workflow is to confirm/reject straight
     * from the listing page, which never touches the notification, so it lingers
     * in the bell forever even after the form has been decided. Call this from
     * each PHD confirm/reject method right after the form's status is saved.
     *
     * The notification payload stores the whole form model (no table/type field),
     * so a form id alone isn't unique across form types - $routeNeedle (e.g.
     * "shuttle-3-listA") disambiguates by matching the notification's own
     * precomputed route, which is form-type/shuttle-type specific.
     */
    protected function clearBorangDiHantarNotification($formId, $routeNeedle)
    {
        auth()->user()->unreadNotifications()
            ->where('type', \App\Notifications\IBK\BorangDiHantar::class)
            ->get()
            ->each(function ($notification) use ($formId, $routeNeedle) {
                $data = $notification->data;
                $notifiedFormId = $data['borang']['id'] ?? null;
                $route = $data['route'] ?? '';
                if ($notifiedFormId !== null
                    && (string) $notifiedFormId === (string) $formId
                    && strpos($route, $routeNeedle) !== false) {
                    $notification->markAsRead();
                }
            });
    }
}
