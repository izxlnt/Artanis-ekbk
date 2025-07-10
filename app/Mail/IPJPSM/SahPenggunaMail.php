<?php

namespace App\Mail\IPJPSM;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SahPenggunaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pengguna_kilang, $pegawai, $status, $created_at;

    public function __construct($pengguna_kilang, $pegawai, $created_at)
    {
        $this->pengguna_kilang = $pengguna_kilang;
        $this->pegawai = $pegawai;
        $this->created_at = $created_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->pengguna_kilang->kategori_pengguna == 'PHD') {
            $route = route('ipjpsm.status-permohonan-phd');
        } elseif ($this->pengguna_kilang->kategori_pengguna == 'JPN') {
            $route = route('ipjpsm.status-permohonan-jpn');
        } else {
            $route = route('ipjpsm.status-permohonan-shuttle-3-kilang');
        }

        $tajuk = "Terdapat Pengguna Baharu yang Perlu Pengesahan";
        $perenggan_1 = $tajuk;
        $perenggan_2 = "<br>";
        $perenggan_3 = "<br>";
        $perenggan_4 = "<br>";

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
            ->view('senarai-email.IPJPSM.SahPengguna.sah-pengguna-ipjpsm', $returnArr);
    }
}
