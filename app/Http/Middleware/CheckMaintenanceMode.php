<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        // Allow login/logout paths — routeIs() misses the unnamed POST /login route
        if ($request->is('login', 'logout', 'password/reset', 'password/email', 'password/*')) {
            return $next($request);
        }

        // Only BPE (IPJPSM admin) can access the system during maintenance
        if (Auth::check() && Auth::user()->kategori_pengguna === 'BPE') {
            return $next($request);
        }

        $setting = $this->getSetting();

        if ($setting && $setting->is_active) {
            $now = now();

            // Auto turn off when end date has passed
            if ($setting->end_date && $now->gt($setting->end_date)) {
                $setting->is_active = false;
                $setting->save();
                Cache::forget('maintenance_setting');
                return $next($request);
            }

            // Not yet started — don't block yet
            if ($setting->start_date && $now->lt($setting->start_date)) {
                return $next($request);
            }

            return response()->view('maintenance', [
                'start'   => $setting->start_date,
                'end'     => $setting->end_date,
                'message' => $setting->message,
            ], 503);
        }

        return $next($request);
    }

    private function getSetting()
    {
        // Only query if the table exists (avoids errors during fresh install / migration)
        if (!Schema::hasTable('maintenance_settings')) {
            return null;
        }

        return Cache::remember('maintenance_setting', 60, function () {
            return \App\Models\MaintenanceSetting::first();
        });
    }
}
