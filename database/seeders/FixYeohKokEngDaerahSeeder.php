<?php

namespace Database\Seeders;

use App\Models\Daerah;
use App\Models\Shuttle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Fixes the daerah for Yeoh Kok Eng Sawmill Sdn Bhd.
 * Correct daerah_sivil: Seberang Prai Tengah
 * (under daerah_hutan: Seberang Prai Utara - Tengah, negeri: Pulau Pinang)
 */
class FixYeohKokEngDaerahSeeder extends Seeder
{
    public function run()
    {
        $shuttle = Shuttle::withTrashed()
            ->where('nama_kilang', 'like', '%Yeoh Kok Eng%')
            ->first();

        if (! $shuttle) {
            $this->command->error('Shuttle not found: Yeoh Kok Eng Sawmill Sdn Bhd');
            return;
        }

        $this->command->line("Found shuttle #{$shuttle->id}: {$shuttle->nama_kilang}");
        $this->command->line("  Current daerah_id : {$shuttle->daerah_id}");
        $this->command->line("  Current negeri_id : {$shuttle->negeri_id}");

        $daerah = Daerah::where('daerah_sivil', 'Seberang Prai Tengah')->first();

        if (! $daerah) {
            $this->command->error('Daerah record for "Seberang Prai Tengah" not found in daerahs table.');
            return;
        }

        $this->command->line("Target daerah: id={$daerah->id}, {$daerah->negeri} / {$daerah->daerah_hutan} / {$daerah->daerah_sivil}");

        DB::table('shuttles')
            ->where('id', $shuttle->id)
            ->update([
                'daerah_id' => $daerah->id,
                'negeri_id' => $daerah->negeri,
            ]);

        $this->command->info("Updated shuttle #{$shuttle->id}:");
        $this->command->info("  daerah_id : {$shuttle->daerah_id} → {$daerah->id}");
        $this->command->info("  negeri_id : {$shuttle->negeri_id} → {$daerah->negeri}");
    }
}
