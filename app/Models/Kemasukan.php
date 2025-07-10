<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kemasukan extends Model
{
    use HasFactory;

    protected $fillable = [
        'shuttle_id',
        'tahun',
        'bulan',
        'status',
        'status_catatan',
    ];

    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
    }
}
