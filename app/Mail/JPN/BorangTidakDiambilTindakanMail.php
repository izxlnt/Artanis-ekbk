<?php

namespace App\Mail\JPN;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorangTidakDiambilTindakanMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pengguna_kilang, $pegawai;

    public function __construct($pegawai)
    {
        $this->pegawai = $pegawai;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $tajuk = "Terdapat Borang Yang Perlu Diambil Tindakan";
        $perenggan_1 = $tajuk;
        $perenggan_2 = "<br>";
        $perenggan_3 = "<br>";
        $perenggan_4 = "<br>";

        $route = route('home-phd');

        $returnArr = [
            'user' => $this->pegawai,

            'tajuk' => $tajuk,
            'perenggan_1' => $perenggan_1,
            'perenggan_2' => $perenggan_2,
            'perenggan_3' => $perenggan_3,
            'perenggan_4' => $perenggan_4,

            'route' => $route,
        ];

        return $this->to($this->pegawai->email, $this->pegawai->name)
        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        ->subject($tajuk)
        ->view('senarai-email.JPN.TidakDiambilTindakan.borang-tiada-tindakan', $returnArr);
    }
}
