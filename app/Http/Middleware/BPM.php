<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BPM
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        else if (Auth::user()->kategori_pengguna == 'BPE') {
            return redirect()->route('home');
        }
        else if (Auth::user()->kategori_pengguna == 'BPM') {
            return $next($request);
        }
        else if (Auth::user()->kategori_pengguna == 'JPN') {
            return redirect()->route('home-jpn');
        }
        else if (Auth::user()->kategori_pengguna == 'PHD') {
            return redirect()->route('home-phd');
        }

        else if (Auth::user()->kategori_pengguna == 'IBK') {
            return redirect()->route('home-user');
            // return $next($request);
        }else{
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
