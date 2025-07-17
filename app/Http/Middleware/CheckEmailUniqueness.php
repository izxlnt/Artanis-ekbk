<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\EmailValidationService;

class CheckEmailUniqueness
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
        // Only check for POST requests that contain email fields
        if ($request->isMethod('post')) {
            $emailFields = ['email', 'email_kilang'];
            
            // Check if emails are different from each other
            if ($request->has('email') && $request->has('email_kilang')) {
                $userEmail = $request->input('email');
                $factoryEmail = $request->input('email_kilang');
                
                if ($userEmail && $factoryEmail && !EmailValidationService::areEmailsDifferent($userEmail, $factoryEmail)) {
                    return back()->withErrors([
                        'email' => 'Email pengguna dan email kilang mesti berbeza. Sila gunakan alamat email yang berbeza.',
                        'email_kilang' => 'Email pengguna dan email kilang mesti berbeza. Sila gunakan alamat email yang berbeza.'
                    ])->withInput();
                }
            }
            
            // Check uniqueness across all tables
            foreach ($emailFields as $field) {
                if ($request->has($field) && $request->filled($field)) {
                    $email = $request->input($field);
                    
                    if (!EmailValidationService::isEmailUnique($email)) {
                        return back()->withErrors([
                            $field => 'Email ini telah digunakan dalam sistem. Sila pilih email yang lain.'
                        ])->withInput();
                    }
                }
            }
        }

        return $next($request);
    }
}
