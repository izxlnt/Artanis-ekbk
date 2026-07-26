<?php

namespace App\Http\Middleware;

use App\Services\LicenseService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * Absolute system lock — unlike CheckMaintenanceMode, nobody is exempted
 * (not even BPE/admin users), and it cannot be toggled from any in-app
 * settings screen. The only way through is the unlock-key form, which
 * validates against LicenseService (HMAC-signed against LICENSE_SECRET).
 */
class CheckSystemLicense
{
    public function handle(Request $request, Closure $next)
    {
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

        $service = app(LicenseService::class);
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
