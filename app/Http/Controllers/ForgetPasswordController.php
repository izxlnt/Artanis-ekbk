<?php

namespace App\Http\Controllers;

use App\Mail\CustomForgetPassword\ResetPasswordMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgetPasswordController extends Controller
{
    public function forgetPassword()
    {
        return view('auth.passwords.email');
    }

    public function forgetPasswordSubmit(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user == null) {
            return redirect()->back()->with('error', 'Email tidak berdaftar dalam sistem ini.');
        }

        // Drop any previous reset request for this email so only the latest link works.
        PasswordReset::where('email', $request->email)->delete();

        $token = Str::random(64);

        PasswordReset::create([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        Mail::send(new ResetPasswordMail($user, $token));

        return redirect()->route('login')->with('success', 'Sistem telah menghantar pautan tetapan semula kata laluan anda melalui emel!');
    }

    public function customChangePassword(Request $request)
    {

        if ($request->password != $request->password_confirmation) {
            return redirect()->back()->with('error', 'Kata laluan pengesahan tidak sama.');
        }

        if (strlen($request->password) < 8) {
            return redirect()->back()->with('error', 'Kata laluan perlu mempunyai 8 huruf atau lebih.');
        }

        $reset = PasswordReset::where('email', $request->email)->first();

        $expiryMinutes = config('auth.passwords.users.expire', 60);

        if (
            !$reset
            || !$request->filled('token')
            || !Hash::check($request->token, $reset->token)
            || !$reset->created_at
            || $reset->created_at->lt(now()->subMinutes($expiryMinutes))
        ) {
            PasswordReset::where('email', $request->email)->delete();

            return redirect()->route('forget-password.show')
                ->with('error', 'Pautan tetapan semula kata laluan tidak sah atau telah tamat tempoh. Sila mohon pautan baharu.');
        }

        //save password
        $hashed_password = Hash::make($request->password);

        $users = User::where('email', $request->email)->get();

        foreach ($users as $user) {
            $user->password = $hashed_password;

            $user->save();
        }

        //delete token from password reset
        PasswordReset::where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Kata laluan baru telah dikemaskini.');
    }
}
