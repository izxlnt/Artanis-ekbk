<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Form5E extends Model implements Auditable
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
        'jumlah_jualan_pasaran_tempatan',
        'jumlah_jualan_pasaran_tempatan_laporan',
        'jumlah_jualan_pasaran_tempatan_cleaning',
        'jumlah_jualan_eksport',
        'jumlah_jualan_eksport_cleaning',
        'jumlah_jualan_eksport_laporan',


        'status',
        'status_catatan',



    ];

    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
    }
}
