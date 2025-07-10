<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'shuttle_id',
        'tahun',
        'bulan',
        'rekod_veniermuka',
        'rekod_venierteras',
        'jumlah_pengeluaran'
    ];

    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
    }
}
