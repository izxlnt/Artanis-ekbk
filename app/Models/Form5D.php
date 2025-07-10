<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Form5D extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'shuttle_type',
        'status',
        'tahun',
        'bulan',
        'tarikh_buka_borang',
        'tarikh_tutup_borang',
        'nama_kilang',
        'no_ssm',
        'no_lesen',
        'shuttle_id',
        'total_jumlah_pengeluaran',
        'tiada_pengeluaran',


        'status',
        'status_catatan',


    ];

    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
    }
}
