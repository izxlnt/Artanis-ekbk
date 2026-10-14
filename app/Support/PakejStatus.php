<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Explains why a month's package ("pakej") has not been sent to IPJPSM yet: which forms of that
 * month are not yet approved by PHD. Used as the tooltip of the "Pakej belum dihantar" icon, so
 * PHD/JPN/IPJPSM see e.g. "Pakej belum dihantar - Borang D belum diisi" instead of guessing.
 */
class PakejStatus
{
    private const APPROVED = ['Dihantar ke IPJPSM', 'Lulus'];

    /** per request: "shuttleId-tahun" => statuses of every form of that kilang/year */
    private static $cache = [];

    public static function tooltip($form): string
    {
        $default = 'Pakej belum dihantar';

        if (!is_object($form) || empty($form->shuttle_id) || empty($form->tahun)) {
            return $default;
        }

        if (!empty($form->bulan)) {
            $month = (int) $form->bulan;
        } elseif (!empty($form->suku_tahun)) {
            $month = (int) $form->suku_tahun * 3;   // Borang B travels with its quarter-end month
        } else {
            return $default;                         // Borang A travels with the first package sent
        }

        $missing = self::missing((int) $form->shuttle_id, (int) $form->tahun, $month);

        return $missing ? $default . ' - ' . implode(', ', $missing) : $default;
    }

    /** @return string[] e.g. ["Borang D belum diisi"] */
    public static function missing(int $shuttleId, int $tahun, int $month): array
    {
        $s = self::statuses($shuttleId, $tahun);
        $required = ['A' => $s['A']];
        if (in_array($month, [3, 6, 9, 12], true)) {
            $required['B'] = $s['B'][$month / 3] ?? null;
        }
        $required['C'] = $s['C'][$month] ?? null;
        $required['D'] = $s['D'][$month] ?? null;
        if ($s['type'] !== 3) {
            $required['E'] = $s['E'][$month] ?? null;
        }

        $out = [];
        foreach ($required as $label => $status) {
            if (in_array($status, self::APPROVED, true)) {
                continue;
            }
            if (in_array($status, ['Sedang Diproses', 'Tiada Pengeluaran'], true)) {
                $out[] = "Borang $label perlu disahkan PHD";
            } elseif ($status === 'Tidak Lengkap') {
                $out[] = "Borang $label tidak lengkap";
            } else {
                $out[] = "Borang $label belum diisi";
            }
        }

        return $out;
    }

    private static function statuses(int $shuttleId, int $tahun): array
    {
        $key = $shuttleId . '-' . $tahun;
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $type = (int) DB::table('shuttles')->where('id', $shuttleId)->value('shuttle_type');
        $dTable = [3 => 'form_d_s', 4 => 'form4_d_s', 5 => 'form5_d_s'][$type] ?? 'form_d_s';
        $eTable = [4 => 'form4_e_s', 5 => 'form5_e_s'][$type] ?? null;

        $byMonth = function ($table) use ($shuttleId, $tahun) {
            return DB::table($table)->where('shuttle_id', $shuttleId)->where('tahun', $tahun)
                ->pluck('status', 'bulan')->mapWithKeys(fn ($v, $k) => [(int) $k => $v])->all();
        };

        return self::$cache[$key] = [
            'type' => $type,
            'A' => DB::table('form_a_s')->where('shuttle_id', $shuttleId)->where('tahun', $tahun)->value('status'),
            'B' => DB::table('formbs')->where('shuttle_id', $shuttleId)->where('tahun', $tahun)
                ->pluck('status', 'suku_tahun')->mapWithKeys(fn ($v, $k) => [(int) $k => $v])->all(),
            'C' => $byMonth('form_c_s'),
            'D' => $byMonth($dTable),
            'E' => $eTable ? $byMonth($eTable) : [],
        ];
    }
}
