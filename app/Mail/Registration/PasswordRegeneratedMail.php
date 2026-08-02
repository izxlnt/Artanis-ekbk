<?php

namespace App\Mail\Registration;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordRegeneratedMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $password;

    /**
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $password = $this->password;

        $tajuk = 'Kata Laluan Baharu Telah Dijana';
        $perenggan_1 = 'Pentadbir sistem telah menjana kata laluan baharu bagi akaun anda di Sistem eShuttle JPSM.';
        $perenggan_2 = 'Berikut merupakan kata laluan baharu anda:';
        $perenggan_3 = "<br>ID Log Masuk : <strong>{$user->login_id}</strong>";
        $perenggan_4 = "Kata Laluan Baharu: <strong>{$password}</strong>";

        $route = route('login');

        $returnArr = [
            'user' => $user,
            'password' => $password,

            'tajuk' => $tajuk,
            'perenggan_1' => $perenggan_1,
            'perenggan_2' => $perenggan_2,
            'perenggan_3' => $perenggan_3,
            'perenggan_4' => $perenggan_4,

            'route' => $route,
        ];

        return $this->to($user->email, $user->name)
            ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
            ->subject($tajuk)
            ->view('senarai-email.auth.register', $returnArr);
    }
}
