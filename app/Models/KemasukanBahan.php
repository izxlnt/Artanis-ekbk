<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KemasukanBahan extends Model
{
    use HasFactory;

    protected $fillable = [
        'spesis_id',
        'baki_stok',
        'kayu_masuk',
        'jumlah_stok_kayu_balak' ,
        'proses_masuk',
        'proses_keluar',
        'baki_stok_kehadapan' ,

        'kemasukan_id',


        'jumlah_baki_stok',
        'jumlah_kayu_masuk',
        'total_stok_kayu_balak',
        'total_kayu_masuk_jentera',
        'total_kayu_keluar_jentera',
        'total_kayu_dibawa_bulan_hadapan',


        'jumlah_besar_baki_stok_bulan_lepas' ,
        'jumlah_besar_kemasukan_kayu_ke_kilang' ,
        'jumlah_besar_stok_kayu_balak' ,
        'jumlah_besar_kayu_ke_dalam_jentera' ,
        'jumlah_besar_pengeluaran_kayu_daripada_jentera' ,
        'jumlah_besar_baki_stok_bulan_depan' ,

        'shuttle_id',
        'bulan',
        'tahun',
        'formcs_id'
    ];

    public function spesis_id()
    {
        return $this->hasOne('App\Models\Spesis','id','spesis_id');
    }

    public function kemasukan_id()
    {
        return $this->hasOne('App\Models\Kemasukan','id','kemasukan_id');
    }

    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
    }

    public function formc()
    {
        return $this->hasOne('App\Models\FormC','id','formcs_id');
    }
}
