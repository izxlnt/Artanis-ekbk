<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdukPengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'form4ds_id',
        'produk',
        'produk_ketebalan',
        'produk_isipadumr',
        'produk_isipaduwbp',
        'jumlah_mr',
        'jumlah_wbp',

        'jumlah_kecil_1_mr',
        'jumlah_kecil_1_wbp',
        'jumlah_kecil_2_mr',
        'jumlah_kecil_2_wbp',
        'jumlah_besar_mr',
        'jumlah_besar_wbp',




    ];

    public function penngeluaran_id()
    {
        return $this->hasOne('App\Models\Form4D','id','form4ds_id');
    }
}

