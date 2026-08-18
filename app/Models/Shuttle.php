<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Shuttle extends Model
{
    use HasFactory;
    use SoftDeletes;
    public $timestamp = true;

    protected $fillable = [
        'shuttle_type',
        'tahun',
        'nama_kilang',
        'alamat_kilang_1',
        'alamat_kilang_2',
        'alamat_kilang_poskod',
        'alamat_kilang_daerah',
        'alamat_surat_menyurat_1',
        'alamat_surat_menyurat_2',
        'alamat_surat_menyurat_poskod',
        'alamat_surat_menyurat_daerah',
        'longtitude_x',
        'langtitude_y',
        'no_telefon',
        'no_faks',
        'no_ssm',
        'tarikh_tubuh',
        'tarikh_operasi',
        'taraf_syarikat_catatan',
        'nilai_harta',
        'catatan_1',
        'catatan_2',
        'status',
        'daerah_id',
        'email',
        'website',
        'no_lesen',
        'status_hak_milik',
        'status_warganegara',
        'negeri_id',
        'sijil_ssm',
        'lesen_kilang'

    ];

    public function setShuttleTypeAttribute($value)
    {
        $this->attributes['shuttle_type'] = trim($value);
    }

    public function setNoSsmAttribute($value)
    {
        $this->attributes['no_ssm'] = implode('/', array_slice(explode('/', trim($value)), 0, 2));
    }


    public function negeri()
    {
        return $this->hasOne('App\Models\Negeri','id','negeri_id');
    }

    /**
     * shuttles.negeri_id stores the full state name as text (e.g. "Selangor"), not a
     * negeris.id FK — the negeri() relation above can never match it (negeris is a
     * postcode/town lookup keyed by state abbreviation, not a state list). Every view
     * reads the state via `$shuttle->negeri->negeri`, so this accessor returns that
     * text directly, keeping the same access pattern working without touching negeri_id
     * itself (a prior attempt to normalize negeri_id to a numeric FK broke ~45 raw-SQL
     * report queries and had to be reverted).
     */
    public function getNegeriAttribute()
    {
        return (object) ['negeri' => $this->attributes['negeri_id'] ?? null];
    }

    public function kilang_daerah()
    {
        return $this->hasOne('App\Models\Negeri','id','alamat_kilang_daerah');
    }

    public function surat_menyurat_daerah()
    {
        return $this->hasOne('App\Models\Negeri','id','alamat_surat_menyurat_daerah');
    }

    public function daerah()
    {
        return $this->belongsTo('App\Models\Daerah', 'daerah_id');
    }




}

