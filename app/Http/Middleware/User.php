<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Http\Request;

class User
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
            return redirect()->route('home-bpm');
        }
        else if (Auth::user()->kategori_pengguna == 'IBK') {
            return $next($request);
        }
        else if (Auth::user()->kategori_pengguna == 'PHD') {
            return redirect()->route('home-phd');
        }

        else if (Auth::user()->kategori_pengguna == 'JPN') {
            return redirect()->route('home-jpn');
        }

        else{
            Auth::logout();
            return redirect()->route('login');
        }
    }
}
