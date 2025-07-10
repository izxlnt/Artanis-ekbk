<?php

namespace App\Notifications\IBK;

use App\Mail\IBK\BorangDiHantarMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorangDiHantar extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pengguna_kilang, $pegawai, $form)
    {
        $this->pengguna_kilang = $pengguna_kilang;
        $this->pegawai = $pegawai;
        $this->form = $form;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail', 'database'];
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new BorangDiHantarMail($this->pengguna_kilang, $this->pegawai, $this->form, $notifiable->created_at))
        ->to($this->pegawai);
        // return (new BorangTidakLengkapMailable($pengguna_kilang, $user, $form, $status, $notifiable->created_at))
        //     ->to($pengguna_kilang['email']);
    }

    public function toDatabase($notifiable)
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

        return [
            'kepada' => $this->pegawai,
            'daripada' => $this->pengguna_kilang,
            'borang' => $this->form,
            'tajuk' => 'Terdapat borang yang perlu disemak',
            'created_at' => $notifiable->created_at,
            'route' => $route
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
