<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Warganegara extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $table = 'warganegaras';
    protected $fillable = [
        'keterangan',
        'aktif',

    ];
}
