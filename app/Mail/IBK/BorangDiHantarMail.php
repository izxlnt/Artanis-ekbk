<?php

namespace App\Mail\IBK;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BorangDiHantarMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $pengguna_kilang, $user, $form, $status, $created_at;

    public function __construct($pengguna_kilang, $user, $form, $created_at)
    {
        $this->pengguna_kilang = $pengguna_kilang;
        $this->user = $user;
        $this->form = $form;
        $this->created_at = $created_at;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $route = route('home-phd');
        if ($this->form->shuttle->shuttle_type == '3') {
            if ($this->form->getTable() == "form_a_s") {
                $route = route('phd.shuttle-3-listA', $this->form->tahun);
            } elseif ($this->form->getTable() == "formbs") {
                $route = route('phd.shuttle-3-listB', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_c_s") {
                $route = route('phd.shuttle-3-listC', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_d_s") {
                $route = route('phd.shuttle-3-listD', $this->form->tahun);
            }
        } else if ($this->form->shuttle->shuttle_type == '4') {
            if ($this->form->getTable() == "form_a_s") {
                $route = route('phd.shuttle-4-listA', $this->form->tahun);
            } elseif ($this->form->getTable() == "formbs") {
                $route = route('phd.shuttle-4-listB', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_c_s") {
                $route = route('phd.shuttle-4-listC', $this->form->tahun);
            } elseif ($this->form->getTable() == "form4_d_s") {
                $route = route('phd.shuttle-4-listD', $this->form->tahun);
            } elseif ($this->form->getTable() == "form4_e_s") {
                $route = route('phd.shuttle-4-listE', $this->form->tahun);
            }
        } else if ($this->form->shuttle->shuttle_type == '5') {
            if ($this->form->getTable() == "form_a_s") {
                $route = route('phd.shuttle-5-listA', $this->form->tahun);
            } elseif ($this->form->getTable() == "formbs") {
                $route = route('phd.shuttle-5-listB', $this->form->tahun);
            } elseif ($this->form->getTable() == "form_c_s") {
                $route = route('phd.shuttle-5-listC', $this->form->tahun);
            } elseif ($this->form->getTable() == "form5_d_s") {
                $route = route('phd.shuttle-5-listD', $this->form->tahun);
            } elseif ($this->form->getTable() == "form5_e_s") {
                $route = route('phd.shuttle-5-listE', $this->form->tahun);
            }
        }
        $status = $this->status ?? "";
        $tajuk = "Terdapat borang yang perlu disemak";
        $perenggan_1 = $tajuk;
        $perenggan_2 = "<br>";
        $perenggan_3 = "<br>";
        $perenggan_4 = "<br>";

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
            ->view('senarai-email.IBK.BorangDihantar.borang-ibk-to-phd', $returnArr);
    }
}
