<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Spesis extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table ='spesis';

    protected $fillable = [
        'nama_tempatan',
        'nama_saintifik',
        'kumpulan_kayu_id',
        'aktif',
        'catatan',
        'kod',
        'ringkasan',
    ];


    public function kumpulan_kayu()
    {
        return $this->hasOne('App\Models\KumpulanKayu','id','kumpulan_kayu_id');
    }
}

