<?php

namespace App\Mail\PHD;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorangTidakDiisiMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pengguna_kilang, $pegawai, $form_list;

    public function __construct($pengguna_kilang, $pegawai, $form_list)
    {
        $this->pengguna_kilang = $pengguna_kilang;
        $this->pegawai = $pegawai;
        $this->form_list = $form_list;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $route = null;
        if ($this->pengguna_kilang->shuttle->shuttle_type == "3") {
            if (substr($this->form_list[0], 0, 8) == "Borang A") {
                $route = route('user.shuttle-3-formA');
            } elseif (substr($this->form_list[0], 0, 8) == "Borang B") {
                $route = route('user.shuttle-3-senaraiB', date("Y"));
            } elseif (substr($this->form_list[0], 0, 8) == "Borang C") {
                $route = route('user.shuttle-3-senaraiC', date("Y"));
            } elseif (substr($this->form_list[0], 0, 8) == "Borang D") {
                $route = route('user.shuttle-3-senaraiD', date("Y"));
            }
        } elseif ($this->pengguna_kilang->shuttle->shuttle_type == "4") {
            if (substr($this->form_list[0], 0, 8) == "Borang A") {
                $route = route('user.shuttle-4-formA');
            } elseif (substr($this->form_list[0], 0, 8) == "Borang B") {
                $route = route('user.shuttle-4-senaraiB', date("Y"));
            } elseif (substr($this->form_list[0], 0, 8) == "Borang C") {
                $route = route('user.shuttle-4-senaraiC', date("Y"));
            } elseif (substr($this->form_list[0], 0, 8) == "Borang D") {
                $route = route('user.shuttle-4-senaraiD', date("Y"));
            } elseif (substr($this->form_list[0], 0, 8) == "Borang E") {
                $route = route('user.shuttle-4-senaraiE', date("Y"));
            }
        } elseif ($this->pengguna_kilang->shuttle->shuttle_type == "5") {
            if (substr($this->form_list[0], 0, 8) == "Borang A") {
                $route = route('user.shuttle-5-formA');
            } elseif (substr($this->form_list[0], 0, 8) == "Borang B") {
                $route = route('user.shuttle-5-senaraiB', date("Y"));
            } elseif (substr($this->form_list[0], 0, 8) == "Borang C") {
                $route = route('user.shuttle-5-senaraiC', date("Y"));
            } elseif (substr($this->form_list[0], 0, 8) == "Borang D") {
                $route = route('user.shuttle-5-senaraiD', date("Y"));
            } elseif (substr($this->form_list[0], 0, 8) == "Borang E") {
                $route = route('user.shuttle-5-senaraiE', date("Y"));
            }
        }

        $tajuk = "Terdapat borang yang perlu diisi";
        $perenggan_1 = $tajuk;
        $perenggan_2 = "<br>";
        $perenggan_3 = "<br>";
        $perenggan_4 = "<br>";

        $route = route('home-user');

        $returnArr = [
            'user' => $this->pegawai,

            'form_list' => $this->form_list,

            'tajuk' => $tajuk,
            'perenggan_1' => $perenggan_1,
            'perenggan_2' => $perenggan_2,
            'perenggan_3' => $perenggan_3,
            'perenggan_4' => $perenggan_4,

            'route' => $route,
        ];

        return $this->to($this->pengguna_kilang->email, $this->pengguna_kilang->name)
        ->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        ->subject($tajuk)
        ->view('senarai-email.PHD.TidakDiisi.borang-tidak-diisi', $returnArr);
    }
}
