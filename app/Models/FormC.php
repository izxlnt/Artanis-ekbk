<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class FormC extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table='form_c_s';

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

    ];


    public function shuttle(){
        return $this->belongsTo(Shuttle::class, 'shuttle_id');

    }
}
