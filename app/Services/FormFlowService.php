<?php

namespace App\Services;

use App\Models\Buffer;
use App\Models\Form4D;
use App\Models\Form4E;
use App\Models\Form5D;
use App\Models\Form5E;
use App\Models\FormA;
use App\Models\FormB;
use App\Models\FormC;
use App\Models\FormD;
use App\Models\KemasukanBahan;

/**
 * Single source of truth for form filling eligibility across all shuttle types.
 *
 * Rules (A → B → C → D → E):
 *  - Form A : must be filled (status != 'Tidak Diisi') before anything else.
 *  - Form B : Form A required. Quarterly (suku). Each suku must be filled in order
 *             before any month in that suku can have Form C filled.
 *  - Form C : Form A + Form B for the month's suku required.
 *             Sequential: previous month's C must be filled.
 *             Date window (tarikh_buka … tarikh_tutup + buffer.delay) must be open,
 *             unless it is a previous year (then always open).
 *  - Form D : Form A + Form C (same month, with KemasukanBahan) required.
 *             Sequential: previous month's D must be filled.
 *             Date window check (same logic as C).
 *  - Form E : Form A + Form D (same month) required.
 *             Sequential: previous month's E must be filled.
 *             Date window check.
 */
class FormFlowService
{
    /** Statuses that count as "filled / submitted" */
    public const FILLED = ['Sedang Diproses', 'Dihantar ke IPJPSM', 'Lulus', 'Tiada Pengeluaran', 'Tidak Lengkap', 'Sedang Diisi'];

    /** Statuses that count as "fully submitted" (not just started) */
    public const SUBMITTED = ['Sedang Diproses', 'Dihantar ke IPJPSM', 'Lulus', 'Tiada Pengeluaran'];

    public static function monthToSuku(int $month): int
    {
        return (int) ceil($month / 3);
    }

    /**
     * Compute form flow status for a shuttle for a given year.
     *
     * Returns:
     * [
     *   'formA'  => ['filled' => bool, 'status' => string|null],
     *   'formB'  => [1..4 => ['can_fill'=>bool,'filled'=>bool,'submitted'=>bool,'reason'=>string|null,'status'=>string|null]],
     *   'formC'  => [1..12 => same shape],
     *   'formD'  => [1..12 => same shape],
     *   'formE'  => [1..12 => same shape],
     * ]
     */
    public static function getStatus(int $shuttleId, int $shuttleType, int $year): array
    {
        $currentYear = (int) date('Y');
        $isPrevYear  = ($year < $currentYear);
        $today       = date('Y-m-d');

        // ── Preload all records for this year ─────────────────────────────────
        $formA = FormA::where('shuttle_id', $shuttleId)->where('tahun', $year)->first();
        $formAFilled = $formA && $formA->status !== 'Tidak Diisi';

        /** @var \Illuminate\Database\Eloquent\Collection $allB */
        $allB = FormB::where('shuttle_id', $shuttleId)->where('tahun', $year)->get()->keyBy('suku_tahun');

        // For FormC duplicates, keep the latest per bulan
        $allC = FormC::where('shuttle_id', $shuttleId)
            ->where('tahun', $year)
            ->orderBy('id', 'desc')
            ->get()
            ->unique('bulan')
            ->keyBy('bulan');

        $allD = self::loadFormD($shuttleId, $shuttleType, $year);
        $allE = self::loadFormE($shuttleId, $shuttleType, $year);

        // Previous-year December for January sequential checks
        $prevDecC = FormC::where('shuttle_id', $shuttleId)->where('bulan', 12)->where('tahun', $year - 1)
            ->whereIn('status', self::SUBMITTED)->exists();
        $prevDecD = self::loadFormDSingle($shuttleId, $shuttleType, $year - 1, 12);
        $prevDecE = self::loadFormESingle($shuttleId, $shuttleType, $year - 1, 12);

        // Preload which FormC records have KemasukanBahan (to avoid N+1)
        $cIds = $allC->filter(fn($f) => in_array($f->status, self::SUBMITTED))->pluck('id');
        $cIdsWithData = KemasukanBahan::where('shuttle_id', $shuttleId)
            ->whereIn('formcs_id', $cIds)
            ->pluck('formcs_id')
            ->unique()
            ->flip(); // O(1) lookup

        // Preload buffers
        $bufB = Buffer::where('shuttle', $shuttleType)->where('borang', 'B')->first();
        $bufC = Buffer::where('shuttle', $shuttleType)->where('borang', 'C')->first();
        $bufD = Buffer::where('shuttle', $shuttleType)->where('borang', 'D')->first();
        $bufE = Buffer::where('shuttle', $shuttleType)->where('borang', 'E')->first();

        $result = ['formA' => ['filled' => $formAFilled, 'status' => $formA ? $formA->status : null]];

        // ── Form B ────────────────────────────────────────────────────────────
        for ($suku = 1; $suku <= 4; $suku++) {
            $fb = $allB->get($suku);
            $fbFilled    = $fb && in_array($fb->status, self::FILLED);
            $fbSubmitted = $fb && in_array($fb->status, self::SUBMITTED);

            [$canFill, $reason, $dateBlocked] = self::checkFormB($formAFilled, $fb, $isPrevYear, $today, $bufB, $suku);

            $result['formB'][$suku] = [
                'can_fill'     => $canFill,
                'date_blocked' => $dateBlocked,
                'filled'       => $fbFilled,
                'submitted'    => $fbSubmitted,
                'reason'       => $reason,
                'status'       => $fb ? $fb->status : null,
            ];
        }

        // ── Form C ────────────────────────────────────────────────────────────
        for ($month = 1; $month <= 12; $month++) {
            $suku = self::monthToSuku($month);
            $sukuSubmitted = $result['formB'][$suku]['submitted'];
            $fc = $allC->get($month);
            $fcFilled    = $fc && in_array($fc->status, self::FILLED);
            $fcSubmitted = $fc && in_array($fc->status, self::SUBMITTED);

            $prevCFilled = ($month === 1)
                ? $prevDecC
                : ($allC->get($month - 1) && in_array($allC->get($month - 1)->status, self::SUBMITTED));

            [$canFill, $reason, $dateBlocked] = self::checkFormC(
                $formAFilled, $sukuSubmitted, $suku, $prevCFilled, $month,
                $fc, $isPrevYear, $today, $bufC
            );

            $result['formC'][$month] = [
                'can_fill'     => $canFill,
                'date_blocked' => $dateBlocked,
                'filled'       => $fcFilled,
                'submitted'    => $fcSubmitted,
                'reason'       => $reason,
                'status'       => $fc ? $fc->status : null,
            ];
        }

        // ── Form D ────────────────────────────────────────────────────────────
        for ($month = 1; $month <= 12; $month++) {
            $fc = $allC->get($month);
            $fcSubmitted = $fc && in_array($fc->status, self::SUBMITTED);
            $hasKemasukan = $fc && (
                isset($cIdsWithData[$fc->id]) ||
                (bool) $fc->tiada_pengeluaran ||
                in_array($fc->status, self::SUBMITTED)
            );
            $fd = $allD->get($month);
            $fdFilled    = $fd && in_array($fd->status, self::FILLED);
            $fdSubmitted = $fd && in_array($fd->status, self::SUBMITTED);

            $prevDFilled = ($month === 1)
                ? ($isPrevYear ? ($prevDecD && in_array($prevDecD->status, self::SUBMITTED)) : true)
                : ($allD->get($month - 1) && in_array($allD->get($month - 1)->status, self::SUBMITTED));

            [$canFill, $reason, $dateBlocked] = self::checkFormD(
                $formAFilled, $fcSubmitted, $hasKemasukan, $prevDFilled, $month,
                $fd, $isPrevYear, $today, $bufD
            );

            $result['formD'][$month] = [
                'can_fill'     => $canFill,
                'date_blocked' => $dateBlocked,
                'filled'       => $fdFilled,
                'submitted'    => $fdSubmitted,
                'reason'       => $reason,
                'status'       => $fd ? $fd->status : null,
            ];
        }

        // ── Form E ────────────────────────────────────────────────────────────
        for ($month = 1; $month <= 12; $month++) {
            $fd = $allD->get($month);
            $fdFilled = $fd && in_array($fd->status, self::SUBMITTED);
            $fe = $allE->get($month);
            $feFilled    = $fe && in_array($fe->status, self::FILLED);
            $feSubmitted = $fe && in_array($fe->status, self::SUBMITTED);

            $prevEFilled = ($month === 1)
                ? ($prevDecE && in_array($prevDecE->status, self::SUBMITTED))
                : ($allE->get($month - 1) && in_array($allE->get($month - 1)->status, self::SUBMITTED));

            [$canFill, $reason, $dateBlocked] = self::checkFormE(
                $formAFilled, $fdFilled, $prevEFilled, $month,
                $fe, $isPrevYear, $today, $bufE
            );

            $result['formE'][$month] = [
                'can_fill'     => $canFill,
                'date_blocked' => $dateBlocked,
                'filled'       => $feFilled,
                'submitted'    => $feSubmitted,
                'reason'       => $reason,
                'status'       => $fe ? $fe->status : null,
            ];
        }

        return $result;
    }

    // ── Rule checkers (pure logic, no DB) ─────────────────────────────────────

    /**
     * Returns [canFill, reason, dateBlocked].
     * dateBlocked=true  → date window issue (calendar icon).
     * dateBlocked=false → prerequisite missing (dimmed circle icon).
     */
    private static function checkFormB(bool $formAFilled, $fb, bool $isPrevYear, string $today, $buf, int $suku): array
    {
        if (!$formAFilled) return [false, 'Sila isi Borang A terlebih dahulu.', false];

        if (!$fb) {
            $currentMonth  = (int) date('n', strtotime($today));
            $quarterLastMonth = $suku * 3; // Q1=3, Q2=6, Q3=9, Q4=12
            if ($isPrevYear || $currentMonth >= $quarterLastMonth) return [true, null, false];
            return [false, 'Borang B suku ini belum dibuka.', true];
        }

        if (in_array($fb->status, self::SUBMITTED)) return [true, null, false];
        if ($fb->status === 'Tidak Lengkap') return [true, null, false];

        if ($isPrevYear)   return [true, null, false];

        // If dates are not configured on the record, treat the window as open
        if (!$fb->tarikh_buka_borang || !$fb->tarikh_tutup_borang) {
            return [true, null, false];
        }

        $delay = $buf ? (int) $buf->delay : 0;
        $tutup = date('Y-m-d', strtotime("+{$delay} month", strtotime($fb->tarikh_tutup_borang)));

        if ($today >= $fb->tarikh_buka_borang && $today <= $tutup) return [true, null, false];

        return [false, 'Tempoh pengisian Borang B telah ditutup.', true];
    }

    private static function checkFormC(
        bool $formAFilled, bool $sukuSubmitted, int $suku, bool $prevCFilled, int $month,
        $fc, bool $isPrevYear, string $today, $buf
    ): array {
        if (!$formAFilled)   return [false, 'Sila isi Borang A terlebih dahulu.', false];
        if (!$sukuSubmitted) return [false, "Sila isi Borang B Suku {$suku} terlebih dahulu.", false];
        if (!$prevCFilled)   return [false, 'Sila isi Borang C bulan sebelumnya terlebih dahulu.', false];

        // No record yet — auto-allow for past/current months so FormCController can
        // create it on the fly via firstOrCreate() without needing a seeder run.
        if (!$fc) {
            $currentMonth = (int) date('n', strtotime($today));
            if ($isPrevYear || $month <= $currentMonth) return [true, null, false];
            return [false, 'Borang C bulan ini belum dibuka.', true];
        }

        // PHD rejected — IBK must be able to re-fill regardless of the date window
        if ($fc->status === 'Tidak Lengkap') return [true, null, false];

        if ($isPrevYear)     return [true, null, false];

        // If dates are not configured on the record, treat the window as open
        if (!$fc->tarikh_buka_borang || !$fc->tarikh_tutup_borang) {
            return [true, null, false];
        }

        $delay = $buf ? (int) $buf->delay : 0;
        $tutup = date('Y-m-d', strtotime("+{$delay} month", strtotime($fc->tarikh_tutup_borang)));

        if ($today >= $fc->tarikh_buka_borang && $today <= $tutup) return [true, null, false];

        return [false, 'Tempoh pengisian Borang C telah ditutup.', true];
    }

    private static function checkFormD(
        bool $formAFilled, bool $fcSubmitted, bool $hasKemasukan, bool $prevDFilled, int $month,
        $fd, bool $isPrevYear, string $today, $buf
    ): array {
        if (!$formAFilled)   return [false, 'Sila isi Borang A terlebih dahulu.', false];
        if (!$fcSubmitted)   return [false, 'Sila isi Borang C bulan ini terlebih dahulu.', false];
        if (!$hasKemasukan)  return [false, 'Sila lengkapkan dan hantar Borang C bulan ini terlebih dahulu.', false];
        if (!$prevDFilled)   return [false, 'Sila isi Borang D bulan sebelumnya terlebih dahulu.', false];

        if (!$fd) {
            $currentMonth = (int) date('n', strtotime($today));
            if ($isPrevYear || $month <= $currentMonth) return [true, null, false];
            return [false, 'Borang D bulan ini belum dibuka.', true];
        }

        // PHD rejected — IBK must be able to re-fill regardless of the date window
        if ($fd->status === 'Tidak Lengkap') return [true, null, false];

        if ($isPrevYear)     return [true, null, false];

        // If dates are not configured on the record, treat the window as open
        if (!$fd->tarikh_buka_borang || !$fd->tarikh_tutup_borang) {
            return [true, null, false];
        }

        $delay = $buf ? (int) $buf->delay : 0;
        $tutup = date('Y-m-d', strtotime("+{$delay} month", strtotime($fd->tarikh_tutup_borang)));

        if ($today >= $fd->tarikh_buka_borang && $today <= $tutup) return [true, null, false];

        return [false, 'Tempoh pengisian Borang D telah ditutup.', true];
    }

    private static function checkFormE(
        bool $formAFilled, bool $fdFilled, bool $prevEFilled, int $month,
        $fe, bool $isPrevYear, string $today, $buf
    ): array {
        if (!$formAFilled) return [false, 'Sila isi Borang A terlebih dahulu.', false];
        if (!$fdFilled)    return [false, 'Sila isi Borang D bulan ini terlebih dahulu.', false];
        if (!$prevEFilled) return [false, 'Sila isi Borang E bulan sebelumnya terlebih dahulu.', false];

        if (!$fe) {
            $currentMonth = (int) date('n', strtotime($today));
            if ($isPrevYear || $month <= $currentMonth) return [true, null, false];
            return [false, 'Borang E bulan ini belum dibuka.', true];
        }

        // PHD rejected — IBK must be able to re-fill regardless of the date window
        if ($fe->status === 'Tidak Lengkap') return [true, null, false];

        if ($isPrevYear)   return [true, null, false];

        // If dates are not configured on the record, treat the window as open
        if (!$fe->tarikh_buka_borang || !$fe->tarikh_tutup_borang) {
            return [true, null, false];
        }

        $delay = $buf ? (int) $buf->delay : 0;
        $tutup = date('Y-m-d', strtotime("+{$delay} month", strtotime($fe->tarikh_tutup_borang)));

        if ($today >= $fe->tarikh_buka_borang && $today <= $tutup) return [true, null, false];

        return [false, 'Tempoh pengisian Borang E telah ditutup.', true];
    }

    // ── Model helpers ─────────────────────────────────────────────────────────

    private static function loadFormD(int $shuttleId, int $shuttleType, int $year): \Illuminate\Support\Collection
    {
        $type = (int) $shuttleType;
        if ($type === 4) return Form4D::where('shuttle_id', $shuttleId)->where('tahun', $year)->get()->keyBy('bulan');
        if ($type === 5) return Form5D::where('shuttle_id', $shuttleId)->where('tahun', $year)->get()->keyBy('bulan');
        return FormD::where('shuttle_id', $shuttleId)->where('tahun', $year)->get()->keyBy('bulan');
    }

    private static function loadFormE(int $shuttleId, int $shuttleType, int $year): \Illuminate\Support\Collection
    {
        $type = (int) $shuttleType;
        if ($type === 4) return Form4E::where('shuttle_id', $shuttleId)->where('tahun', $year)->get()->keyBy('bulan');
        if ($type === 5) return Form5E::where('shuttle_id', $shuttleId)->where('tahun', $year)->get()->keyBy('bulan');
        return collect();
    }

    private static function loadFormDSingle(int $shuttleId, int $shuttleType, int $year, int $month)
    {
        $type = (int) $shuttleType;
        if ($type === 4) return Form4D::where('shuttle_id', $shuttleId)->where('tahun', $year)->where('bulan', $month)->first();
        if ($type === 5) return Form5D::where('shuttle_id', $shuttleId)->where('tahun', $year)->where('bulan', $month)->first();
        return FormD::where('shuttle_id', $shuttleId)->where('tahun', $year)->where('bulan', $month)->first();
    }

    private static function loadFormESingle(int $shuttleId, int $shuttleType, int $year, int $month)
    {
        $type = (int) $shuttleType;
        if ($type === 4) return Form4E::where('shuttle_id', $shuttleId)->where('tahun', $year)->where('bulan', $month)->first();
        if ($type === 5) return Form5E::where('shuttle_id', $shuttleId)->where('tahun', $year)->where('bulan', $month)->first();
        return null;
    }
}
