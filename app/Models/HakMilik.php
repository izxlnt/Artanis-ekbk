<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HakMilik extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'hak_miliks';
    protected $fillable = [
        'keterangan',
        'aktif',

    ];
}
