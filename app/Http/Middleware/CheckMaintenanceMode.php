<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next)
    {
        if (config('app.maintenance_mode')) {
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
