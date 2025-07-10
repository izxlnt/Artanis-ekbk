<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'tahun',
        'bulan',
        'borang_a',
        'borang_b',
        'borang_c',
        'borang_d',
        'borang_e',
        'shuttle_id',
    ];

    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle', 'id', 'shuttle_id');
    }
}
