<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Form4E extends Model implements Auditable
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
        'total_export',
        'total_export_laporan',
        'jumlah_pasaran_tempatan',
        'jumlah_pasaran_tempatan_laporan',
        'jumlah_venier_eksport',
        'jumlah_venier_eksport_laporan',
        'jumlah_venier_tempatan',
        'jumlah_venier_tempatan_laporan',
        'status',
        'status_catatan',
        'total_export_cleaning'



    ];

    public function shuttle()
    {
        return $this->hasOne('App\Models\Shuttle','id','shuttle_id');
    }
}
