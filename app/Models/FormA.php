<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class FormA extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [

        'status',
        'tahun',
        'shuttle_id',

    ];

    public function shuttle(){
        return $this->belongsTo(Shuttle::class, 'shuttle_id');

    }
}
