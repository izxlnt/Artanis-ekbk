<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class Form4D extends Model implements Auditable
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
        'rekod_veniermuka',
        'rekod_venierteras',
        'jumlah_pengeluaran',
        'status_catatan',
        'tiada_pengeluaran',
        'jumlah_besar_pengeluaran',


    ];

    public function shuttle(){
        return $this->belongsTo(Shuttle::class, 'shuttle_id');

    }
}
