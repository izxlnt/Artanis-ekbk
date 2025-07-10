<?php

namespace App\Mail\Registration;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $password = $this->password;
        // dd($user);

        $tajuk = "Pendaftaran Berjaya!";
        $perenggan_1 = "Pendaftaran akaun bagi Sistem eShuttle JPSM telah berjaya!";
        $perenggan_2 = "Berikut merupakan kata laluan sementara :";
        $perenggan_3 = "<br>ID Log Masuk : <strong>$user->login_id</strong>";
        $perenggan_4 = "Kata Laluan Sementara: <strong>$password</strong>";

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


        return $this->to($this->user['email'], $this->user['nama'])
        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        ->subject($tajuk)
        ->view('senarai-email.auth.register', $returnArr);
    }
}
