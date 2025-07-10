<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UlasanIpjpsm extends Model
{
    use HasFactory;

    protected $fillable = [
        'ulasan',
        'user_id',
        'formas_id',
        'formcs_id',
        'formds_id',
        'form4ds_id',
        'form4es_id',
        'form5ds_id',
        'form5es_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id');
    }
    public function formas_id()
    {
        return $this->hasOne('App\Models\FormA','id','formas_id');
    }

    public function formbs_id()
    {
        return $this->hasOne('App\Models\FormB','id','formbs_id');
    }

    public function formcs_id()
    {
        return $this->hasOne('App\Models\FormC','id','formcs_id');
    }

    public function formds_id()
    {
        return $this->hasOne('App\Models\FormD','id','formds_id');
    }

    public function form4ds_id()
    {
        return $this->hasOne('App\Models\Form4D','id','form4ds_id');
    }

    public function form4es_id()
    {
        return $this->hasOne('app\models\Form4D','id','form4es_id');
    }

    public function form5ds_id()
    {
        return $this->hasOne('app\models\Form5D','id','form5ds_id');
    }

    public function form5es_id()
    {
        return $this->hasOne('app\models\Form5E','id','form5es_id');
    }
}
