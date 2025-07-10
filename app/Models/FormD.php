<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class FormD extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table='form_d_s';

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
        'total_export_cleaning',
        'total_export_laporan',
        'jumlah_pasaran_tempatan',
        'jumlah_pasaran_tempatan_cleaning',
        'jumlah_pasaran_tempatan_laporan',
        'status_catatan',

    ];

    public function shuttle(){
        return $this->belongsTo(Shuttle::class, 'shuttle_id');

    }
}
