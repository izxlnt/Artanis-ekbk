<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Daerah;

/**
 * Reverts shuttles.daerah_id and shuttles.negeri_id from numeric daerahs.id
 * back to their original text values.
 *
 * daerah_id : numeric → daerahs.daerah_hutan text
 * negeri_id : numeric → full state name resolved via alamat_kilang_poskod → negeris.negeri
 *             (falls back to daerahs.negeri if postal lookup fails)
 *
 * Run this BEFORE FixShuttleDaerahNegeriIdSeeder if the wrong seeder was already
 * executed and needs to be undone.
 */
class RevertShuttleDaerahNegeriIdSeeder extends Seeder
{
    private const NEGERI_ABBR_MAP = [
        'PHG' => 'Pahang',
        'KTN' => 'Kelantan',
        'TRG' => 'Terengganu',
        'SGR' => 'Selangor',
        'KDH' => 'Kedah',
        'PRK' => 'Perak',
        'JHR' => 'Johor',
        'MLK' => 'Melaka',
        'PLS' => 'Perlis',
        'PNG' => 'Pulau Pinang',
        'NSN' => 'Negeri Sembilan',
        'KUL' => 'W.P Kuala Lumpur',
        'SBH' => 'Sabah',
        'SWK' => 'Sarawak',
        'LBN' => 'W.P Labuan',
        'PTJ' => 'W.P Putrajaya',
    ];

    public function run()
    {
        $daerahReverted = 0;
        $negeriReverted = 0;
        $skipped        = 0;

        // Include soft-deleted records so numeric IDs are reverted regardless of status
        $shuttles = DB::table('shuttles')
                      ->get(['id', 'daerah_id', 'negeri_id', 'alamat_kilang_poskod']);

        foreach ($shuttles as $shuttle) {
            $updates = [];

            // Revert daerah_id: numeric → daerahs.daerah_hutan text
            if (!empty($shuttle->daerah_id) && is_numeric($shuttle->daerah_id)) {
                $daerah = Daerah::find((int) $shuttle->daerah_id);
                if ($daerah) {
                    $updates['daerah_id'] = $daerah->daerah_hutan;
                    $this->command->line(
                        "  Shuttle #{$shuttle->id}: daerah_id {$shuttle->daerah_id} → \"{$daerah->daerah_hutan}\""
                    );
                    $daerahReverted++;
                } else {
                    $this->command->warn(
                        "  Shuttle #{$shuttle->id}: daerah_id {$shuttle->daerah_id} — daerahs record not found, skipped"
                    );
                    $skipped++;
                }
            }

            // Revert negeri_id: numeric → full state name from postal code lookup
            if (!empty($shuttle->negeri_id) && is_numeric($shuttle->negeri_id)) {
                $negeriText = $this->resolveNegeriFromPoskod($shuttle->alamat_kilang_poskod);

                // Fallback: derive from the daerahs record that was stored
                if (!$negeriText) {
                    $daerah = Daerah::find((int) $shuttle->negeri_id);
                    $negeriText = $daerah ? $daerah->negeri : null;
                }

                if ($negeriText) {
                    $updates['negeri_id'] = $negeriText;
                    $this->command->line(
                        "  Shuttle #{$shuttle->id}: negeri_id {$shuttle->negeri_id} → \"{$negeriText}\""
                    );
                    $negeriReverted++;
                } else {
                    $this->command->warn(
                        "  Shuttle #{$shuttle->id}: negeri_id {$shuttle->negeri_id} — could not resolve, skipped"
                    );
                    $skipped++;
                }
            }

            if (!empty($updates)) {
                DB::table('shuttles')->where('id', $shuttle->id)->update($updates);
            }
        }

        $this->command->info("Revert done.");
        $this->command->info("  daerah_id reverted: {$daerahReverted}");
        $this->command->info("  negeri_id reverted: {$negeriReverted}");
        $this->command->info("  skipped: {$skipped}");
        $this->command->info("You can now run FixShuttleDaerahNegeriIdSeeder.");
    }

    private function resolveNegeriFromPoskod(?string $poskod): ?string
    {
        if (empty($poskod)) return null;

        $row = DB::table('negeris')
                 ->where('poskod', trim($poskod))
                 ->first(['negeri']);

        if (!$row) {
            // Try with trimmed DB values (some entries have trailing spaces)
            $row = DB::table('negeris')
                     ->whereRaw("TRIM(poskod) = ?", [trim($poskod)])
                     ->first(['negeri']);
        }

        if ($row && isset(self::NEGERI_ABBR_MAP[trim($row->negeri)])) {
            return self::NEGERI_ABBR_MAP[trim($row->negeri)];
        }

        return null;
    }
}
