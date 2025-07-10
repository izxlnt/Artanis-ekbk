<?php

namespace App\Notifications\PHD;

use App\Mail\PHD\BorangTidakDiisiMail as BorangTidakDiisiMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BorangTidakDiisiNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pengguna_kilang, $pegawai, $form_list)
    {
        $this->pengguna_kilang = $pengguna_kilang;
        $this->pegawai = $pegawai;
        $this->form_list = $form_list;
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
        $pengguna_kilang = $this->pengguna_kilang;
        $pegawai = $this->pegawai;
        $form_list = $this->form_list;
        return (new BorangTidakDiisiMailable($pengguna_kilang, $pegawai, $form_list))->to($pengguna_kilang['email']);
    }

    public function toDatabase($notifiable)
    {
        $route = null;
        if($this->pengguna_kilang->shuttle->shuttle_type == "3"){
            if(substr($this->form_list[0], 0, 8) == "Borang A"){
                $route = route('user.shuttle-3-formA');
            }elseif(substr($this->form_list[0], 0, 8) == "Borang B"){
                $route = route('user.shuttle-3-senaraiB', date("Y"));

            }elseif(substr($this->form_list[0], 0, 8) == "Borang C"){
                $route = route('user.shuttle-3-senaraiC', date("Y"));

            }elseif(substr($this->form_list[0], 0, 8) == "Borang D"){
                $route = route('user.shuttle-3-senaraiD', date("Y"));

            }
        }elseif($this->pengguna_kilang->shuttle->shuttle_type == "4"){
            if(substr($this->form_list[0], 0, 8) == "Borang A"){
                $route = route('user.shuttle-4-formA');
            }elseif(substr($this->form_list[0], 0, 8) == "Borang B"){
                $route = route('user.shuttle-4-senaraiB', date("Y"));

            }elseif(substr($this->form_list[0], 0, 8) == "Borang C"){
                $route = route('user.shuttle-4-senaraiC', date("Y"));

            }elseif(substr($this->form_list[0], 0, 8) == "Borang D"){
                $route = route('user.shuttle-4-senaraiD', date("Y"));

            }elseif(substr($this->form_list[0], 0, 8) == "Borang E"){
                $route = route('user.shuttle-4-senaraiE', date("Y"));

            }
        }elseif($this->pengguna_kilang->shuttle->shuttle_type == "5"){
            if(substr($this->form_list[0], 0, 8) == "Borang A"){
                $route = route('user.shuttle-5-formA');
            }elseif(substr($this->form_list[0], 0, 8) == "Borang B"){
                $route = route('user.shuttle-5-senaraiB', date("Y"));

            }elseif(substr($this->form_list[0], 0, 8) == "Borang C"){
                $route = route('user.shuttle-5-senaraiC', date("Y"));

            }elseif(substr($this->form_list[0], 0, 8) == "Borang D"){
                $route = route('user.shuttle-5-senaraiD', date("Y"));

            }elseif(substr($this->form_list[0], 0, 8) == "Borang E"){
                $route = route('user.shuttle-5-senaraiE', date("Y"));

            }
        }
        return [
            'kepada' => $this->pengguna_kilang,
            'daripada' => $this->pegawai,
            'borang' => $this->form_list,
            'tajuk' => 'Terdapat borang yang perlu diisi',
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
