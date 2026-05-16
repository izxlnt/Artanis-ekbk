<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$shuttle_id = 670;
$year = 2026;

// Check April's baki_stok_kehadapan (should become May's baki_stok)
$april = App\Models\FormC::where('shuttle_id', $shuttle_id)
    ->where('tahun', $year)->where('bulan', 4)->first();
echo "April FormC ID: " . ($april ? $april->id : 'NOT FOUND') . " status=" . ($april ? $april->status : '') . "\n\n";

if ($april) {
    $kb = App\Models\KemasukanBahan::where('formcs_id', $april->id)
        ->orderBy('spesis_id')
        ->get(['id','spesis_id','baki_stok','kayu_masuk','jumlah_stok_kayu_balak','proses_masuk','proses_keluar','baki_stok_kehadapan']);
    echo "April KemasukanBahan rows: " . $kb->count() . "\n";
    echo "First 5 rows:\n";
    foreach ($kb->take(5) as $row) {
        echo "  spesis_id={$row->spesis_id} baki={$row->baki_stok} masuk={$row->kayu_masuk} jumlah={$row->jumlah_stok_kayu_balak} pmasuk={$row->proses_masuk} pkeluar={$row->proses_keluar} kehadapan={$row->baki_stok_kehadapan}\n";
    }
    $hasNonZero = $kb->where('baki_stok_kehadapan', '>', 0)->count();
    echo "Rows with baki_stok_kehadapan > 0: $hasNonZero\n";
}

// Check how May's form is supposed to load baki_stok from April
echo "\n--- May FormC record ---\n";
$may = App\Models\FormC::where('shuttle_id', $shuttle_id)
    ->where('tahun', $year)->where('bulan', 5)->first();
echo "May FormC ID: " . ($may ? $may->id : 'NOT FOUND') . " status=" . ($may ? $may->status : '') . "\n";
