<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Model;

class FormB extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $table='formbs';

    protected $fillable = [
        'shuttle_type',
        'status',
        'tahun',
        'suku_tahun',
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
