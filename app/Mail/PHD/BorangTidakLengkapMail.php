<?php

namespace App\Mail\PHD;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorangTidakLengkapMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pengguna_kilang, $user, $form, $status, $created_at;

    public function __construct($pengguna_kilang, $user, $form, $status, $created_at)
    {
        $this->pengguna_kilang = $pengguna_kilang;
        $this->user = $user;
        $this->form = $form;
        $this->status = $status;
        $this->created_at = $created_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $status = $this->status;
        $tajuk = "Terdapat borang yang ". $status;
        $perenggan_1 = $tajuk;
        $perenggan_2 = "<br>";
        $perenggan_3 = "<br>";
        $perenggan_4 = "<br>";

        if ($this->form->shuttle->shuttle_type == '3') {
            if ($this->form->getTable() == "form_a_s") {
                $route = route('user.shuttle-3-formA');
            } elseif ($this->form->getTable() == "formbs") {
                $route = route('user.shuttle-3-senaraiB', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_c_s") {
                $route = route('user.shuttle-3-senaraiC', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_d_s") {
                $route = route('user.shuttle-3-senaraiD', $this->form->tahun);
            }
        } else if ($this->form->shuttle->shuttle_type == '4') {
            if ($this->form->getTable() == "form_a_s") {
                $route = route('user.shuttle-4-formA');
            } elseif ($this->form->getTable() == "formbs") {
                $route = route('user.shuttle-4-senaraiC', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_c_s") {
                $route = route('user.shuttle-4-senaraiC', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_4_d_s") {
                $route = route('user.shuttle-4-senaraiD', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_4_e_s") {
                $route = route('user.shuttle-4-senaraiE', $this->form->tahun);
            }
        } else if ($this->form->shuttle->shuttle_type == '5') {
            if ($this->form->getTable() == "form_a_s") {
                $route = route('user.shuttle-5-formA');
            } elseif ($this->form->getTable() == "formbs") {
                $route = route('user.shuttle-5-senaraiC', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_c_s") {
                $route = route('user.shuttle-5-senaraiC', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_5_d_s") {
                $route = route('user.shuttle-5-senaraiD', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_5_e_s") {
                $route = route('user.shuttle-5-senaraiE', $this->form->tahun);
            }
        }

        $returnArr = [
            'user' => $this->user,

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
        ->view('senarai-email.PHD.TidakLengkap.borang-phd-to-ibk', $returnArr);
    }
}
