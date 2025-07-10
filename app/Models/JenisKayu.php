<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JenisKayu extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'keterangan',
        'aktif',

    ];
}
