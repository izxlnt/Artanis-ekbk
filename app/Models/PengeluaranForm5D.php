<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranForm5D extends Model
{
    use HasFactory;

    protected $fillable = [
        'form5ds_id',
        'jenis_kayu_id',
        'catatan',
        'pengeluaran_kayu',
        'total_jumlah_pengeluaran'
    ];

    public function pengeluaran5D_id()
    {
        return $this->hasOne('App\Models\Form5D','id','form5ds_id');
    }

    public function pembelian_id()
    {
        return $this->hasOne('App\Models\JenisKayu','id','jenis_kayu_id');
    }
}
