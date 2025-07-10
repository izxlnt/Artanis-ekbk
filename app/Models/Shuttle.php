<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Shuttle extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamp = true;

    protected $fillable = [
        'shuttle_type',
        'tahun',
        'nama_kilang',
        'alamat_kilang_1',
        'alamat_kilang_2',
        'alamat_kilang_poskod',
        'alamat_kilang_daerah',
        'alamat_surat_menyurat_1',
        'alamat_surat_menyurat_2',
        'alamat_surat_menyurat_poskod',
        'alamat_surat_menyurat_daerah',
        'longtitude_x',
        'langtitude_y',
        'no_telefon',
        'no_faks',
        'no_ssm',
        'tarikh_tubuh',
        'tarikh_operasi',
        'taraf_syarikat_catatan',
        'nilai_harta',
        'catatan_1',
        'catatan_2',
        'status',
        'daerah_id',
        'email',
        'website',
        'no_lesen',
        'status_hak_milik',
        'status_warganegara',
        'negeri_id',
        'sijil_ssm',
        'lesen_kilang'

    ];

    public function negeri()
    {
        return $this->hasOne('App\Models\Negeri','id','negeri_id');
    }

    public function kilang_daerah()
    {
        return $this->hasOne('App\Models\Negeri','id','alamat_kilang_daerah');
    }

    public function surat_menyurat_daerah()
    {
        return $this->hasOne('App\Models\Negeri','id','alamat_surat_menyurat_daerah');
    }




}

