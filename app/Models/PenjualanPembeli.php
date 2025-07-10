<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanPembeli extends Model
{
    use HasFactory;

    protected $fillable = [
        'formds_id',
        'form4es_id',
        'pembeli_id',
        'catatan',
        'jumlah_jualan',
        'jumlah_jualan_laporan',
        'jumlah_jualan_cleaning',
        'total_jumlah_jualan',
        'total_jumlah_jualan_cleaning',
        'total_jumlah_jualan_laporan'
    ];

    public function penjualan_id()
    {
        return $this->hasOne('App\Models\FormD','id','formds_id');
    }

    public function penjualan4E_id()
    {
        return $this->hasOne('App\Models\Form4E','id','form4es_id');
    }

    public function pembelian_id()
    {
        return $this->hasOne('App\Models\Pembeli','id','pembeli_id');
    }
}
