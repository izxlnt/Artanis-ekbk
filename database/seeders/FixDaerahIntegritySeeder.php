<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Makes the district (daerahs.id) the single source of truth for who sees what.
 *
 *  1. users.daerah: bring the old "Seberang Prai ..." spellings up to the names
 *     now in `daerahs` (they stopped matching when the daerahs names were renamed).
 *  2. users.daerah_id: link every PHD user to their daerahs row (lowest id for that
 *     daerah_hutan; access still spans every row sharing the name).
 *  3. users.negeri: a PHD user gets their district's state. Only PHD is touched: JPN is
 *     scoped by state (not district), so a stray district on a JPN account is left alone.
 *  4. shuttles.negeri_id (which holds the state NAME as text): set it to the state
 *     of the kilang's own daerah_id wherever the two disagree.
 *
 * Idempotent (running it again changes nothing) and non-destructive: it only
 * updates the columns above, and logs every row it changes. Requires the
 * users.daerah_id column (php artisan migrate). Usage:
 *     php artisan db:seed --class=FixDaerahIntegritySeeder
 */
class FixDaerahIntegritySeeder extends Seeder
{
    /** Old (pre-2026-07-29) Pulau Pinang spellings still stored on some users. */
    private const LEGACY_NAMES = [
        'Seberang Prai Utara - Tengah'        => 'Seberang Perai Utara/Tengah',
        'Seberang Prai Selatan (Timur-Barat)' => 'Seberang Perai Selatan',
    ];

    public function run()
    {
        if (!Schema::hasColumn('users', 'daerah_id')) {
            $this->command->error('users.daerah_id does not exist - run "php artisan migrate" first.');
            return;
        }

        DB::transaction(function () {
            $this->fixLegacyUserNames();
            $this->linkUsersToDaerah();
            $this->alignUserNegeri();
            $this->alignShuttleNegeri();
        });

        $this->report();
    }

    private function fixLegacyUserNames()
    {
        foreach (self::LEGACY_NAMES as $old => $new) {
            $n = DB::table('users')->where('daerah', $old)->update(['daerah' => $new]);
            $this->command->line("users.daerah '{$old}' -> '{$new}': {$n} user(s)");
        }
    }

    private function linkUsersToDaerah()
    {
        $n = DB::update(
            'UPDATE users u
             JOIN (SELECT daerah_hutan, MIN(id) AS id FROM daerahs GROUP BY daerah_hutan) d
               ON d.daerah_hutan = u.daerah
             SET u.daerah_id = d.id
             WHERE u.daerah_id IS NULL AND u.kategori_pengguna = \'PHD\''
        );
        $this->command->info("PHD users.daerah_id linked: {$n} user(s)");
    }

    private function alignUserNegeri()
    {
        $rows = DB::select(
            'SELECT u.id, u.name, u.negeri, d.negeri AS daerah_negeri
             FROM users u JOIN daerahs d ON d.id = u.daerah_id
             WHERE u.kategori_pengguna = \'PHD\' AND (u.negeri <> d.negeri OR u.negeri IS NULL)'
        );
        foreach ($rows as $r) {
            DB::table('users')->where('id', $r->id)->update(['negeri' => $r->daerah_negeri]);
            $this->command->line("user #{$r->id} {$r->name}: negeri '{$r->negeri}' -> '{$r->daerah_negeri}'");
        }
        $this->command->info('users.negeri realigned: ' . count($rows));
    }

    private function alignShuttleNegeri()
    {
        $rows = DB::select(
            'SELECT s.id, s.nama_kilang, s.negeri_id, s.daerah_id, d.negeri AS daerah_negeri, d.daerah_hutan
             FROM shuttles s JOIN daerahs d ON d.id = s.daerah_id
             WHERE s.negeri_id <> d.negeri OR s.negeri_id IS NULL'
        );
        foreach ($rows as $r) {
            DB::table('shuttles')->where('id', $r->id)->update(['negeri_id' => $r->daerah_negeri]);
            $this->command->line(
                "shuttle #{$r->id} {$r->nama_kilang}: negeri '{$r->negeri_id}' -> '{$r->daerah_negeri}' "
                . "(district {$r->daerah_id} {$r->daerah_hutan})"
            );
        }
        $this->command->info('shuttles.negeri_id realigned to their district: ' . count($rows));
    }

    /** Things this seeder cannot decide on its own. */
    private function report()
    {
        $noDaerah = DB::select(
            "SELECT id, name, negeri FROM users WHERE kategori_pengguna = 'PHD' AND daerah_id IS NULL"
        );
        foreach ($noDaerah as $u) {
            $this->command->warn("PHD #{$u->id} {$u->name} ({$u->negeri}) has no district - set it in Pengurusan Pengguna.");
        }

        $orphans = DB::select(
            "SELECT s.id, s.nama_kilang, s.daerah_id FROM shuttles s
             WHERE s.deleted_at IS NULL AND s.shuttle_type IN ('3','4','5')
               AND (s.daerah_id IS NULL OR NOT EXISTS (SELECT 1 FROM daerahs d WHERE d.id = s.daerah_id))"
        );
        foreach ($orphans as $s) {
            $this->command->warn("shuttle #{$s->id} {$s->nama_kilang}: daerah_id " . var_export($s->daerah_id, true) . ' is not a valid district.');
        }

        $unwatched = DB::select(
            "SELECT s.id, s.nama_kilang, s.daerah_id FROM shuttles s
             WHERE s.deleted_at IS NULL AND s.shuttle_type IN ('3','4','5') AND s.daerah_id IS NOT NULL
               AND NOT EXISTS (
                   SELECT 1 FROM users u JOIN daerahs d2 ON d2.daerah_hutan = (SELECT daerah_hutan FROM daerahs WHERE id = s.daerah_id)
                   WHERE u.kategori_pengguna = 'PHD' AND u.daerah_id = d2.id)"
        );
        foreach ($unwatched as $s) {
            $this->command->warn("shuttle #{$s->id} {$s->nama_kilang} (district {$s->daerah_id}) has no PHD user assigned.");
        }
    }
}
