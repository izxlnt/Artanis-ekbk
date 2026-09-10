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

    /**
     * Same seeded-placeholder problem as FormB::reopenDueQuarters() (see
     * that method's docblock for the full rationale) - always normalizes
     * "Ditutup" to "Tidak Diisi" for the given year, not just once the
     * month has opened. Safe because FormFlowService::checkFormC() already
     * treats the two identically and re-derives real openness from
     * tarikh_buka_borang/the buffer settings - and every listing view's own
     * "Tidak Diisi" branch does the same date check to pick between the
     * "belum diisi" and "ditutup" icons, so it renders correctly either way
     * once the row is no longer sitting on a status these views don't know
     * how to draw at all.
     */
    public static function reopenDueMonths($year, \Closure $shuttleScope = null): void
    {
        $query = static::where('tahun', $year)->where('status', 'Ditutup');

        if ($shuttleScope) {
            $query->whereHas('shuttle', $shuttleScope);
        }

        $query->update(['status' => 'Tidak Diisi']);
    }
}
