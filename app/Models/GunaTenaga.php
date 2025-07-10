<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GunaTenaga extends Model
{
    use HasFactory;

    protected $fillable = [
        'pekerja_wargabumi_lelaki',
        'pekerja_wargabumi_lelaki_laporan',
        'pekerja_wargabumi_lelaki_cleaning',

        'pekerja_wargabumi_perempuan',
        'pekerja_wargabumi_perempuan_laporan',
        'pekerja_wargabumi_perempuan_cleaning',

        'pekerja_bukan_wargabumi_lelaki',
        'pekerja_bukan_wargabumi_lelaki_laporan',
        'pekerja_bukan_wargabumi_lelaki_cleaning',

        'pekerja_bukan_wargabumi_perempuan',
        'pekerja_bukan_wargabumi_perempuan_laporan',
        'pekerja_bukan_wargabumi_perempuan_cleaning',

        'pekerja_asing_lelaki',
        'pekerja_asing_lelaki_laporan',
        'pekerja_asing_lelaki_cleaning',

        'pekerja_asing_perempuan',
        'pekerja_asing_perempuan_laporan',
        'pekerja_asing_perempuan_cleaning',

        'gaji_lelaki',
        'gaji_lelaki_laporan',
        'gaji_lelaki_cleaning',

        'gaji_perempuan',
        'gaji_perempuan_laporan',
        'gaji_perempuan_cleaning',

        'total_gaji_lelaki',
        'total_gaji_lelaki_laporan',
        'total_gaji_lelaki_cleaning',

        'total_gaji_perempuan',
        'total_gaji_perempuan_laporan',
        'total_gaji_perempuan_cleaning',

        'total_gaji',
        'total_gaji_laporan',
        'total_gaji_cleaning',


        'jumlah_lelaki',
        'jumlah_lelaki_laporan',
        'jumlah_lelaki_cleaning',

        'jumlah_perempuan',
        'jumlah_perempuan_laporan',
        'jumlah_perempuan_cleaning',

        'jumlah_pekerja',
        'jumlah_pekerja_laporan',
        'jumlah_pekerja_cleaning',

        'gaji_lelaki_perempuan',
        'gaji_lelaki_perempuan_laporan',
        'gaji_lelaki_perempuan_cleaning',

        'total_bumi_lelaki',
        'total_bumi_lelaki_cleaning',

        'total_bumi_perempuan',
        'total_bumi_perempuan_cleaning',

        'total_bukanbumi_lelaki',
        'total_bukanbumi_lelaki_cleaning',

        'total_bukanbumi_perempuan',
        'total_bukanbumi_perempuan_cleaning',

        'total_asing_lelaki',
        'total_asing_lelaki_cleaning',

        'total_asing_perempuan',
        'total_asing_perempuan_cleaning',

        'total_pekerja_lelaki',
        'total_pekerja_lelaki_cleaning',

        'total_pekerja_perempuan',
        'total_pekerja_perempuan_cleaning',

        'total_pekerja',
        'total_pekerja_cleaning',

        'jumlah_gaji_lelaki',
        'jumlah_gaji_lelaki_cleaning',

        'jumlah_gaji_perempuan',
        'jumlah_gaji_perempuan_cleaning',

        'jumlah_lelaki_perempuan',
        'jumlah_lelaki_perempuan_cleaning',

        'jumlah_total_lelaki',
        'jumlah_total_lelaki_cleaning',

        'jumlah_total_perempuan',
        'jumlah_total_perempuan_cleaning',

        'jumlah_total_gaji',
        'jumlah_total_gaji_cleaning',


        'shuttle_id',
        'kategori_guna_tenaga_id',
        'bulan',
        'tahun',
        'formbs_id',

        'total_bumi_lelaki_laporan',
        'total_bumi_perempuan_laporan',
        'total_bukanbumi_lelaki_laporan',
        'total_bukanbumi_perempuan_laporan',
        'total_asing_lelaki_laporan',
        'total_asing_perempuan_laporan',
        'total_pekerja_lelaki_laporan',
        'total_pekerja_perempuan_laporan',
        'total_pekerja_laporan',
        'jumlah_gaji_lelaki_laporan',
        'jumlah_gaji_perempuan_laporan',
        'jumlah_lelaki_perempuan_laporan',
        'jumlah_total_lelaki_laporan',
        'jumlah_total_perempuan_laporan',
        'jumlah_total_gaji_laporan'
    ];


    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
    }

    // public function kategori_guna_tenaga()
    // {
    //     return $this->hasOne('App\Models\KategoriGunaTenaga','id','kategori_guna_tenaga_id');
    // }

    public function kategori_guna_tenaga(){
        return $this->belongsTo('App\Models\KategoriGunaTenaga', 'kategori_guna_tenaga_id');

    }

    public function formb()
    {
        return $this->hasOne('App\Models\FormB','id','formbs_id');
    }
}
