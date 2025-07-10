<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $cast = ['data_laporan' => 'array'];

    protected $fillable = [
        'laporan_num',
        'tahun',
        'tahun_akhir',
        'suku_tahun',
        'suku_tahun_akhir',
        'shuttle_type',
        'spesis',
        'data_laporan'
    ];
}


