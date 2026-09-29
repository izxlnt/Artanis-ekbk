<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Read-only consistency check for everything that hangs off `daerahs`.
 * Writes nothing. Exits non-zero when it finds a problem, so it can be run
 * after any user/kilang/district change (or from CI).
 *
 *     php artisan daerah:audit
 */
class AuditDaerah extends Command
{
    protected $signature = 'daerah:audit';

    protected $description = 'Read-only check that users, kilang and announcements all point at valid, consistent daerahs rows.';

    private $problems = 0;

    public function handle()
    {
        $hasUserId = Schema::hasColumn('users', 'daerah_id');
        if (!$hasUserId) {
            $this->warn('users.daerah_id is missing - run "php artisan migrate", then the FixDaerahIntegritySeeder.');
        }

        $this->check(
            'Kilang (shuttle 3/4/5) whose daerah_id is not a valid district',
            "SELECT s.id, s.nama_kilang, s.daerah_id AS info FROM shuttles s
             WHERE s.deleted_at IS NULL AND s.shuttle_type IN ('3','4','5')
               AND (s.daerah_id IS NULL OR NOT EXISTS (SELECT 1 FROM daerahs d WHERE d.id = s.daerah_id))"
        );

        $this->check(
            "Kilang whose state (shuttles.negeri_id) differs from its district's state",
            'SELECT s.id, s.nama_kilang, CONCAT(s.negeri_id, " vs ", d.negeri) AS info
             FROM shuttles s JOIN daerahs d ON d.id = s.daerah_id
             WHERE s.deleted_at IS NULL AND s.negeri_id <> d.negeri'
        );

        $this->check(
            'PHD users with no usable district (they would see nothing)',
            $hasUserId
                ? "SELECT u.id, u.name, u.daerah AS info FROM users u
                   WHERE u.kategori_pengguna = 'PHD' AND u.deleted_at IS NULL
                     AND (u.daerah_id IS NULL OR NOT EXISTS (SELECT 1 FROM daerahs d WHERE d.id = u.daerah_id))"
                : "SELECT u.id, u.name, u.daerah AS info FROM users u
                   WHERE u.kategori_pengguna = 'PHD' AND u.deleted_at IS NULL
                     AND (u.daerah IS NULL OR NOT EXISTS (SELECT 1 FROM daerahs d WHERE d.daerah_hutan = u.daerah))"
        );

        if ($hasUserId) {
            $this->check(
                "PHD users whose stored district name / state differs from their district row",
                "SELECT u.id, u.name, CONCAT(u.daerah, ' / ', u.negeri, ' vs ', d.daerah_hutan, ' / ', d.negeri) AS info
                 FROM users u JOIN daerahs d ON d.id = u.daerah_id
                 WHERE u.kategori_pengguna = 'PHD' AND u.deleted_at IS NULL
                   AND (u.daerah <> d.daerah_hutan OR u.negeri <> d.negeri)"
            );

            $this->check(
                'Kilang in a district that no PHD user covers (nobody can verify their forms)',
                "SELECT s.id, s.nama_kilang, s.daerah_id AS info FROM shuttles s
                 WHERE s.deleted_at IS NULL AND s.shuttle_type IN ('3','4','5') AND s.daerah_id IS NOT NULL
                   AND NOT EXISTS (
                       SELECT 1 FROM users u JOIN daerahs d2
                         ON d2.daerah_hutan = (SELECT daerah_hutan FROM daerahs WHERE id = s.daerah_id)
                       WHERE u.kategori_pengguna = 'PHD' AND u.deleted_at IS NULL AND u.daerah_id = d2.id)"
            );
        }

        $this->check(
            'JPN users whose state is not a known state (they would see nothing)',
            "SELECT u.id, u.name, u.negeri AS info FROM users u
             WHERE u.kategori_pengguna = 'JPN' AND u.deleted_at IS NULL
               AND (u.negeri IS NULL OR NOT EXISTS (SELECT 1 FROM daerahs d WHERE d.negeri = u.negeri))"
        );

        $this->check(
            'Announcements (pengumuman) for a district name that no longer exists',
            "SELECT p.id, p.tajuk AS name, p.daerah_hutan AS info FROM pengumuman p
             WHERE p.daerah_hutan IS NOT NULL AND p.daerah_hutan <> ''
               AND NOT EXISTS (SELECT 1 FROM daerahs d WHERE d.daerah_hutan = p.daerah_hutan)"
        );

        if ($this->problems === 0) {
            $this->info('daerah audit: OK, no problems found.');
            return 0;
        }

        $this->error("daerah audit: {$this->problems} kind(s) of problem found.");
        return 1;
    }

    private function check($label, $sql)
    {
        $rows = DB::select($sql);
        if (!$rows) {
            $this->line("<info>OK</info>   {$label}");
            return;
        }

        $this->problems++;
        $this->line('<error>FAIL</error> ' . $label . ' (' . count($rows) . ')');
        foreach (array_slice($rows, 0, 15) as $r) {
            $this->line("       #{$r->id} " . ($r->nama_kilang ?? $r->name ?? '') . ' - ' . var_export($r->info, true));
        }
        if (count($rows) > 15) {
            $this->line('       ... and ' . (count($rows) - 15) . ' more');
        }
    }
}
