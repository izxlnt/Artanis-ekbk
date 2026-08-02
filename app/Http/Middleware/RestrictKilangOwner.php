<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestrictKilangOwner
{
    /**
     * Blocks the kilang's SSM-login owner account (pengguna_kilang_id is null)
     * from reaching form-filling routes. Only IC-login sub-user accounts
     * (pengguna_kilang_id set) may fill in and submit data.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check() && Auth::user()->isKilangOwner()) {
            return redirect()->route('home-user.user-management')
                ->with('error', 'Akaun pemilik kilang (No. SSM) hanya boleh menguruskan pengguna. Sila hantar akaun pengguna (No. KP) untuk mengisi borang.');
        }

        return $next($request);
    }
}
