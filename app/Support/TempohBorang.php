<?php

namespace App\Support;

use App\Models\Buffer;

/**
 * Whether a not-yet-filled form is outside its filling period ("Borang ditutup"): its period has
 * not opened yet, or the buffer (when active) has run out. Same rule the JPN/PHD month grids use,
 * so the PHD task lists show future months as closed instead of "belum diisi".
 */
class TempohBorang
{
    /** per request: "shuttleType-borang" => Buffer|null */
    private static $buffers = [];

    public static function ditutup($form): bool
    {
        if (!is_object($form) || ($form->status ?? null) !== 'Tidak Diisi') {
            return false;
        }

        $today = date('Y-m-d');
        if (!empty($form->tarikh_buka_borang) && $today < $form->tarikh_buka_borang) {
            return true;
        }

        // FormB / FormC / FormD / Form4D / Form4E / Form5D / Form5E -> b, c, d, e
        $borang = strtolower(substr(class_basename($form), -1));
        $type = (string) ($form->shuttle_type ?? '');
        if ($type === '' || empty($form->tarikh_tutup_borang) || !in_array($borang, ['b', 'c', 'd', 'e'], true)) {
            return false;
        }

        $key = $type . '-' . $borang;
        if (!array_key_exists($key, self::$buffers)) {
            self::$buffers[$key] = Buffer::where('borang', $borang)->where('shuttle', $type)->first();
        }
        $buffer = self::$buffers[$key];
        if (!$buffer || !$buffer->aktif) {
            return false;
        }

        $tutup = date('Y-m-d', strtotime('+' . (int) $buffer->delay . ' month', strtotime($form->tarikh_tutup_borang)));

        return $today > $tutup;
    }
}
