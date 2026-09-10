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

    /**
     * "Ditutup" is the placeholder status a quarter is seeded with before its
     * window opens (see PermohonanPenggunaController). IBK's own fill-page
     * controllers flip a single row from "Ditutup" to "Tidak Diisi" the
     * moment they visit it - but listing pages read rows directly and never
     * trigger that, and their views have no "Ditutup" branch at all, so a
     * quarter still sitting at "Ditutup" renders as a blank cell instead of
     * an icon, even when it genuinely hasn't opened yet and *should* show
     * the closed/calendar icon.
     *
     * This always normalizes "Ditutup" to "Tidak Diisi" for the given year
     * (not just once its window has opened) - safe because nothing else
     * ever treats the two differently: FormFlowService::checkFormB() and
     * every listing view's own "Tidak Diisi" branch already re-derive
     * "is this quarter actually open" from tarikh_buka_borang/the buffer
     * settings, not from which of these two placeholder strings is stored.
     * "Tidak Diisi" is simply the one status value every view already knows
     * how to render correctly in both the open and not-yet-open case.
     */
    public static function reopenDueQuarters($year, \Closure $shuttleScope = null): void
    {
        $query = static::where('tahun', $year)->where('status', 'Ditutup');

        if ($shuttleScope) {
            $query->whereHas('shuttle', $shuttleScope);
        }

        $query->update(['status' => 'Tidak Diisi']);
    }

}
