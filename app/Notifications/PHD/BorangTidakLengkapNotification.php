<?php

namespace App\Notifications\PHD;

use App\Mail\PHD\BorangTidakLengkapMail as BorangTidakLengkapMailable;

use App\Models\PenggunaKilang;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class BorangTidakLengkapNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user, $form, $status, $ulasan, $pengguna_kilang)
    {
        //
        $this->user = $user;
        $this->form = $form;
        $this->status = $status;
        $this->ulasan = $ulasan;
        // dd($this->form->shuttle->id);
        $this->pengguna_kilang = $pengguna_kilang;
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
        // dd(env('MAIL_FROM_ADDRESS'));
        $pengguna_kilang = $this->pengguna_kilang;
        $user = $this->user;
        $form = $this->form;
        $status = $this->status;
        $form = $this->form;

        return (new BorangTidakLengkapMailable($pengguna_kilang, $user, $form, $status, $notifiable->created_at))
                ->to($pengguna_kilang['email']);
    }

    public function toDatabase($notifiable)
    {
        if ($this->form->shuttle->shuttle_type == '3') {
            if ($this->form->getTable() == "form_a_s") {
                $route = route('user.shuttle-3-formA');
            }
            elseif ($this->form->getTable() == "formbs") {
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
            } elseif ($this->form->getTable() == "form4_e_s") {
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

        // dd($this->form->getTable());

        return [
            'kepada' => $this->pengguna_kilang,
            'daripada' => $this->user,
            'borang' => $this->form,
            'tajuk' => 'Terdapat borang yang '.$this->status,
            'created_at' => $notifiable->created_at,
            'route' => $route,
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
