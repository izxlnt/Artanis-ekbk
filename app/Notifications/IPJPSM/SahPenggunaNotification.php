<?php

namespace App\Notifications\IPJPSM;

use App\Mail\IPJPSM\SahPenggunaMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SahPenggunaNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($pengguna_kilang, $pegawai)
    {
        $this->pengguna_kilang = $pengguna_kilang;
        $this->pegawai = $pegawai;
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
        return (new SahPenggunaMail($pengguna_kilang, $pegawai, $notifiable->created_at))->to($pegawai['email']);
    }

    public function toDatabase($notifiable)
    {
        if($this->pengguna_kilang->kategori_pengguna == 'PHD'){
            $route =route('ipjpsm.status-permohonan-phd');
        }elseif($this->pengguna_kilang->kategori_pengguna == 'JPN'){
            $route = route('ipjpsm.status-permohonan-jpn');
        }else{
            $route = route('ipjpsm.status-permohonan-shuttle-3-kilang');
        }

        return [
            'kepada' => $this->pegawai,
            'daripada' => $this->pengguna_kilang,
            'tajuk' => 'Terdapat Pengguna Baharu yang Perlu Pengesahan',
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
