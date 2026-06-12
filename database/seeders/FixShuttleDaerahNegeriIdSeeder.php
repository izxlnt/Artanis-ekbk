<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Daerah;

/**
 * daerah_id  → resolve to the correct daerahs.id (handles both text and already-numeric values)
 * negeri_id  → always keep/restore as full state name text, sourced from alamat_kilang_poskod
 *
 * Matching order for daerah_id:
 *   1. Match daerahs.daerah_hutan = text, narrowed by state (negeri_id text).
 *   2. If still multiple, match alamat_kilang_daerah → negeris.bandar → daerahs.daerah_sivil.
 *   3. If still ambiguous, lowest daerahs.id in the narrowed set (with a WARN).
 *   4. If daerah_hutan text has NO match at all → first daerahs.id for the state.
 *   5. Last resort → global first daerahs.id.
 *
 * Matching order for negeri_id (text restoration):
 *   1. alamat_kilang_poskod → negeris.negeri abbreviation → NEGERI_ABBR_MAP → full state name.
 *   2. Fallback: existing daerahs record (if negeri_id was numeric).
 */
class FixShuttleDaerahNegeriIdSeeder extends Seeder
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
        $daerahFixed   = 0;
        $negeriFixed   = 0;
        $daerahSkipped = 0;

        $allDaerah = Daerah::whereNull('deleted_at')->get();

        // daerah_hutan (lowercase) → collection of daerahs with that name
        $byDaerahHutan = $allDaerah->groupBy(fn($d) => strtolower(trim($d->daerah_hutan)));

        // negeri (lowercase) → first (lowest id) daerahs record for that state
        $firstByNegeri = $allDaerah->groupBy(fn($d) => strtolower(trim($d->negeri)))
                                   ->map(fn($group) => $group->sortBy('id')->first());

        $globalFirst = $allDaerah->sortBy('id')->first();

        // Include soft-deleted records so numeric IDs are fixed regardless of status
        $shuttles = DB::table('shuttles')
                      ->get(['id', 'daerah_id', 'negeri_id', 'alamat_kilang_daerah', 'alamat_kilang_poskod']);

        foreach ($shuttles as $shuttle) {
            $updates = [];

            // ── daerah_id → resolve to correct daerahs.id ─────────────────────────────
            if (!empty($shuttle->daerah_id)) {
                if (!is_numeric($shuttle->daerah_id)) {
                    $textToMatch = trim($shuttle->daerah_id);
                } else {
                    // Already numeric — get daerah_hutan text to re-resolve
                    $existing    = Daerah::find((int) $shuttle->daerah_id);
                    $textToMatch = $existing ? trim($existing->daerah_hutan) : null;
                }

                if ($textToMatch) {
                    $needle  = strtolower($textToMatch);
                    $matches = $byDaerahHutan->get($needle);

                    if ($matches && $matches->isNotEmpty()) {
                        $resolved = $this->disambiguate($matches, $shuttle);
                    } else {
                        // No daerah_hutan match — fall back to first daerahs.id for state
                        $stateHint = $this->resolveStateHint($shuttle);
                        $resolved  = $stateHint
                            ? ($firstByNegeri->get(strtolower($stateHint)) ?? $globalFirst)
                            : $globalFirst;
                        $this->command->warn(
                            "  Shuttle #{$shuttle->id}: daerah_id \"{$textToMatch}\" — no daerah_hutan match, using first for state → id={$resolved->id} ({$resolved->negeri} / {$resolved->daerah_hutan})"
                        );
                    }

                    if ((int) $shuttle->daerah_id !== $resolved->id) {
                        $updates['daerah_id'] = $resolved->id;
                        $this->command->line(
                            "  Shuttle #{$shuttle->id}: daerah_id \"{$shuttle->daerah_id}\" → {$resolved->id} ({$resolved->negeri} / {$resolved->daerah_hutan} / {$resolved->daerah_sivil})"
                        );
                        $daerahFixed++;
                    }
                } else {
                    $this->command->warn(
                        "  Shuttle #{$shuttle->id}: daerah_id \"{$shuttle->daerah_id}\" — could not resolve, skipped"
                    );
                    $daerahSkipped++;
                }
            }

            // ── negeri_id → restore/set as full state name text ───────────────────────
            // Only update if currently numeric, or if poskod lookup gives a better value
            if (!empty($shuttle->negeri_id) && is_numeric($shuttle->negeri_id)) {
                $negeriText = $this->resolveNegeriFromPoskod($shuttle->alamat_kilang_poskod);

                // Fallback: derive from the daerahs record that was stored
                if (!$negeriText) {
                    $daerah     = Daerah::find((int) $shuttle->negeri_id);
                    $negeriText = $daerah ? $daerah->negeri : null;
                }

                if ($negeriText) {
                    $updates['negeri_id'] = $negeriText;
                    $this->command->line(
                        "  Shuttle #{$shuttle->id}: negeri_id {$shuttle->negeri_id} → \"{$negeriText}\" (from poskod)"
                    );
                    $negeriFixed++;
                } else {
                    $this->command->warn(
                        "  Shuttle #{$shuttle->id}: negeri_id {$shuttle->negeri_id} — could not resolve, skipped"
                    );
                }
            }

            if (!empty($updates)) {
                DB::table('shuttles')->where('id', $shuttle->id)->update($updates);
            }
        }

        $this->command->info("Done.");
        $this->command->info("  daerah_id fixed: {$daerahFixed}, skipped: {$daerahSkipped}");
        $this->command->info("  negeri_id reverted to text: {$negeriFixed}");
    }

    /**
     * Pick the best daerahs record from a collection sharing the same daerah_hutan.
     * Order: state narrowing → daerah_sivil / bandar match → lowest id fallback.
     */
    private function disambiguate($matches, object $shuttle)
    {
        if ($matches->count() === 1) {
            return $matches->first();
        }

        // Narrow by state
        $stateHint = $this->resolveStateHint($shuttle);
        if ($stateHint) {
            $stateMatches = $matches->filter(
                fn($d) => strtolower(trim($d->negeri)) === strtolower($stateHint)
            );
            if ($stateMatches->isNotEmpty()) {
                $matches = $stateMatches;
            }
        }

        if ($matches->count() === 1) {
            return $matches->first();
        }

        // Narrow by daerah_sivil using bandar from alamat_kilang_daerah
        $bandar = $this->resolveBandar($shuttle);
        if ($bandar) {
            $bandarLower  = strtolower($bandar);
            $sivilMatches = $matches->filter(
                fn($d) => strtolower(trim($d->daerah_sivil)) === $bandarLower
            );
            if ($sivilMatches->isEmpty()) {
                $sivilMatches = $matches->filter(
                    fn($d) => str_contains(strtolower(trim($d->daerah_sivil)), $bandarLower)
                           || str_contains($bandarLower, strtolower(trim($d->daerah_sivil)))
                );
            }
            if ($sivilMatches->isNotEmpty()) {
                return $sivilMatches->sortBy('id')->first();
            }
        }

        // Fallback — lowest id, flag for manual review
        $fallback = $matches->sortBy('id')->first();
        $this->command->warn(
            "  Shuttle #{$shuttle->id}: multiple matches remain, using fallback id={$fallback->id} ({$fallback->daerah_sivil}). Verify manually."
        );
        return $fallback;
    }

    /**
     * Returns the full state name (matching daerahs.negeri) for the shuttle.
     * Uses negeri_id text first, then alamat_kilang_poskod, then alamat_kilang_daerah abbreviation.
     */
    private function resolveStateHint(object $shuttle): ?string
    {
        // negeri_id is already a text state name
        if (!empty($shuttle->negeri_id) && !is_numeric($shuttle->negeri_id)) {
            return trim($shuttle->negeri_id);
        }

        // Derive from postal code
        $fromPoskod = $this->resolveNegeriFromPoskod($shuttle->alamat_kilang_poskod ?? null);
        if ($fromPoskod) {
            return $fromPoskod;
        }

        // Derive from alamat_kilang_daerah → negeris.negeri abbreviation
        if (!empty($shuttle->alamat_kilang_daerah) && is_numeric($shuttle->alamat_kilang_daerah)) {
            $row = DB::table('negeris')->where('id', $shuttle->alamat_kilang_daerah)->first(['negeri']);
            if ($row && isset(self::NEGERI_ABBR_MAP[trim($row->negeri)])) {
                return self::NEGERI_ABBR_MAP[trim($row->negeri)];
            }
        }

        return null;
    }

    /**
     * Resolve the full state name from the factory postal code via negeris table.
     */
    private function resolveNegeriFromPoskod(?string $poskod): ?string
    {
        if (empty($poskod)) return null;

        $row = DB::table('negeris')
                 ->where('poskod', trim($poskod))
                 ->first(['negeri']);

        if (!$row) {
            $row = DB::table('negeris')
                     ->whereRaw("TRIM(poskod) = ?", [trim($poskod)])
                     ->first(['negeri']);
        }

        if ($row && isset(self::NEGERI_ABBR_MAP[trim($row->negeri)])) {
            return self::NEGERI_ABBR_MAP[trim($row->negeri)];
        }

        return null;
    }

    /**
     * Returns the bandar (town) name from alamat_kilang_daerah → negeris.bandar,
     * used to match against daerahs.daerah_sivil.
     */
    private function resolveBandar(object $shuttle): ?string
    {
        if (!empty($shuttle->alamat_kilang_daerah) && is_numeric($shuttle->alamat_kilang_daerah)) {
            $row = DB::table('negeris')->where('id', $shuttle->alamat_kilang_daerah)->first(['bandar']);
            return $row ? trim($row->bandar) : null;
        }

        if (!empty($shuttle->alamat_kilang_daerah) && !is_numeric($shuttle->alamat_kilang_daerah)) {
            return trim($shuttle->alamat_kilang_daerah);
        }

        return null;
    }
}
