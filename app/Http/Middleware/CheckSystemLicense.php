<?php

namespace App\Http\Middleware;

use App\Services\LicenseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * Absolute system lock — unlike CheckMaintenanceMode, nobody is exempted
 * (not even BPE/admin users), and it cannot be toggled from any in-app
 * settings screen.
 *
 * Two independent ways to trigger it, checked in this order:
 * 1. The code-based lock (app/license-lock.php) — a plain file you edit
 *    and deploy. No exceptions apply here at all, not even the control
 *    panel, since there's nothing at runtime that could undo it anyway —
 *    the only way out is editing the file back and deploying again.
 * 2. The database-backed lock (LicenseService::current()), controlled via
 *    the /system-control/{token} panel or the license:* artisan commands.
 */
class CheckSystemLicense
{
    public function handle(Request $request, Closure $next)
    {
        $service = app(LicenseService::class);

        if ($service->isCodeLocked()) {
            return response()->view('system-locked', [
                'lockedMessage' => $service->codeLockMessage(),
                'hasSecret'     => false,
            ], 503);
        }

        // Avoid errors before the migration has run (fresh install/deploy).
        if (!Schema::hasTable('system_licenses')) {
            return $next($request);
        }

        // The public unlock form and the token-gated control panel must
        // always be reachable, locked or not — otherwise there'd be no way
        // back in.
        if ($request->routeIs('system-locked.unlock') || $request->routeIs('system-control.*')) {
            return $next($request);
        }

        $license = $service->current();

        if (!$license->is_locked) {
            return $next($request);
        }

        return response()->view('system-locked', [
            'lockedMessage' => $license->locked_message,
            'hasSecret'     => $service->hasSecret(),
        ], 503);
    }
}
