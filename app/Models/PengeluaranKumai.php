<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengeluaranKumai extends Model
{
    use HasFactory;


    protected $fillable = [
        'shuttle_id',
        'bulan',
        'tahun',
        'status',
        'status_catatan',
    ];

    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
    }
}
