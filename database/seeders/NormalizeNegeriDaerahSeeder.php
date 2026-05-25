<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Daerah;

class NormalizeNegeriDaerahSeeder extends Seeder
{
    public function run()
    {
        $fixed = 0;

        $shuttles = DB::table('shuttles')->whereNull('deleted_at')->get(['id', 'negeri_id', 'daerah_id']);

        foreach ($shuttles as $shuttle) {
            $updates = [];

            // Fix daerah_id if it is a numeric ID
            if (is_numeric($shuttle->daerah_id) && $shuttle->daerah_id !== null && $shuttle->daerah_id !== '') {
                $daerah = Daerah::find((int) $shuttle->daerah_id);
                if ($daerah) {
                    $updates['daerah_id'] = $daerah->daerah_hutan;
                    $this->command->line("  Shuttle #{$shuttle->id}: daerah_id {$shuttle->daerah_id} → {$daerah->daerah_hutan}");
                } else {
                    $this->command->warn("  Shuttle #{$shuttle->id}: daerah_id {$shuttle->daerah_id} — Daerah record not found, skipped");
                }
            }

            // Fix negeri_id if it is a numeric ID
            if (is_numeric($shuttle->negeri_id) && $shuttle->negeri_id !== null && $shuttle->negeri_id !== '') {
                $daerah = Daerah::find((int) $shuttle->negeri_id);
                if ($daerah) {
                    $updates['negeri_id'] = $daerah->negeri;
                    $this->command->line("  Shuttle #{$shuttle->id}: negeri_id {$shuttle->negeri_id} → {$daerah->negeri}");
                } else {
                    $this->command->warn("  Shuttle #{$shuttle->id}: negeri_id {$shuttle->negeri_id} — Daerah record not found, skipped");
                }
            }

            if (!empty($updates)) {
                DB::table('shuttles')->where('id', $shuttle->id)->update($updates);
                $fixed++;
            }
        }

        $this->command->info("Done. Total shuttles fixed: {$fixed}");
    }
}
