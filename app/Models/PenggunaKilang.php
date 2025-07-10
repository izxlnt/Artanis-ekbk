<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class PenggunaKilang extends Model
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'name','jantina','warganegara', 'kaum','email','no_kad_pengenalan','gambar_ic_hadapan','gambar_ic_belakang','gambar_passport','jawatan','no_pekerja','gambar_kad_pekerja','shuttle_type','shuttle_id'
      ];

      public function shuttle_id()
      {
          return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
      }
}
