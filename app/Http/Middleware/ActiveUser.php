<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ActiveUser
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
        if(auth()->user()){
            if (auth()->user()->is_approved == 0 && auth()->user()->is_approved_ipjpsm == 0) {

                if(auth()->user()->status == 0){
                    $user = auth()->user();
                    auth()->logout();
                    return redirect()->route('login')
                        ->with('error', 'Akaun anda telah dinyaktifkan.');
                }
                else{
                    $user = auth()->user();
                    auth()->logout();
                    return redirect()->route('login')
                        ->with('error', 'Akaun anda masih belum disahkan.');
                }

            }
            else{
                if(auth()->user()->status == 0){
                    $user = auth()->user();
                    auth()->logout();
                    return redirect()->route('login')
                        ->with('error', 'Akaun anda telah dinyaktifkan.');
                }
            }
        }

        return $next($request);
    }
}
