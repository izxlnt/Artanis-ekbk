<?php

namespace Database\Seeders;

use App\Models\Daerah;
use App\Models\Shuttle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FixWoodlandorAddressSeeder extends Seeder
{
    public function run()
    {
        $shuttle = Shuttle::withTrashed()
            ->where('nama_kilang', 'like', '%Woodlandor%')
            ->first();

        if (! $shuttle) {
            $this->command->error('Shuttle not found: Woodlandor Wood Products Sdn Bhd');
            return;
        }

        $this->command->line("Found shuttle #{$shuttle->id}: {$shuttle->nama_kilang}");
        $this->command->line("  alamat_kilang_1          : {$shuttle->alamat_kilang_1}");
        $this->command->line("  alamat_kilang_2          : {$shuttle->alamat_kilang_2}");
        $this->command->line("  alamat_kilang_poskod     : {$shuttle->alamat_kilang_poskod}");
        $this->command->line("  alamat_kilang_daerah     : {$shuttle->alamat_kilang_daerah}");
        $this->command->line("  alamat_sm_1              : {$shuttle->alamat_surat_menyurat_1}");
        $this->command->line("  alamat_sm_2              : {$shuttle->alamat_surat_menyurat_2}");
        $this->command->line("  alamat_sm_poskod         : {$shuttle->alamat_surat_menyurat_poskod}");
        $this->command->line("  alamat_sm_daerah         : {$shuttle->alamat_surat_menyurat_daerah}");
        $this->command->line("  daerah_id                : {$shuttle->daerah_id}");
        $this->command->line("  negeri_id                : {$shuttle->negeri_id}");

        $daerah = Daerah::where('negeri', 'Selangor')
            ->where('daerah_hutan', 'Selangor Tengah')
            ->where('daerah_sivil', 'Hulu Langat')
            ->first();

        if (! $daerah) {
            $this->command->error('Daerah record for Hulu Langat / Selangor Tengah not found.');
            return;
        }

        $this->command->line("Target daerah: id={$daerah->id}, {$daerah->negeri} / {$daerah->daerah_hutan} / {$daerah->daerah_sivil}");

        DB::table('shuttles')
            ->where('id', $shuttle->id)
            ->update([
                'alamat_kilang_1'              => 'Lot 265, BT.22 1/2',
                'alamat_kilang_2'              => 'Sg Lalang',
                'alamat_kilang_poskod'         => '43500',
                'alamat_kilang_daerah'         => 'Hulu Langat',
                'alamat_surat_menyurat_1'      => 'Lot 265, BT.22 1/2',
                'alamat_surat_menyurat_2'      => 'Sg Lalang',
                'alamat_surat_menyurat_poskod' => '43500',
                'alamat_surat_menyurat_daerah' => 'Hulu Langat',
                'daerah_id'                    => $daerah->id,
                'negeri_id'                    => $daerah->negeri,
            ]);

        $this->command->info("Updated shuttle #{$shuttle->id}:");
        $this->command->info("  alamat_kilang_1      → Lot 265, BT.22 1/2");
        $this->command->info("  alamat_kilang_2      → Sg Lalang");
        $this->command->info("  alamat_kilang_poskod → 43500");
        $this->command->info("  alamat_kilang_daerah → Hulu Langat");
        $this->command->info("  alamat_sm_*          → (same as kilang)");
        $this->command->info("  daerah_id            : {$shuttle->daerah_id} → {$daerah->id}");
        $this->command->info("  negeri_id            : {$shuttle->negeri_id} → {$daerah->negeri}");
    }
}
