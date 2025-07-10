<?php

namespace App\Mail\CustomForgetPassword;

use App\Models\PasswordReset;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;

        $pw_reset = PasswordReset::where('email', $user->email)->first();

        $token = $pw_reset->token;

        return $this->to($this->user->email, $this->user->name)
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject('Tetapan Semula Kata Laluan')
            ->view('senarai-email.notifikasiUserResetPassword', compact('user', 'token'));
    }
}
