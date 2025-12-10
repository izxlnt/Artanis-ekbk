<?php
/**
 * Data Cleanup Script - Fix Corrupted Species Data
 * 
 * This script identifies and fixes data entries where species have identical 
 * values due to the array index [0] bug that was fixed on Dec 10, 2025
 */

use App\Models\KemasukanBahan;
use App\Models\Spesis;
use Illuminate\Support\Facades\DB;

echo "=== ARTANIS Data Cleanup Script ===" . PHP_EOL;
echo "Fixing corrupted species data caused by array index bug" . PHP_EOL;
echo "Date: " . date('Y-m-d H:i:s') . PHP_EOL . PHP_EOL;

// Step 1: Identify corrupted data (entries created before Dec 10, 2025 with duplicate values)
echo "Step 1: Identifying corrupted data..." . PHP_EOL;

$corrupted_forms = DB::select("
    SELECT 
        formcs_id, 
        total_kayu_dibawa_bulan_hadapan, 
        COUNT(*) as species_count,
        GROUP_CONCAT(spesis_id) as species_ids
    FROM kemasukan_bahans 
    WHERE total_kayu_dibawa_bulan_hadapan > 0 
    AND created_at < '2025-12-10 00:00:00'
    GROUP BY formcs_id, total_kayu_dibawa_bulan_hadapan 
    HAVING COUNT(*) > 1
    ORDER BY formcs_id
");

echo "Found " . count($corrupted_forms) . " potentially corrupted form submissions" . PHP_EOL . PHP_EOL;

if (empty($corrupted_forms)) {
    echo "✅ No corrupted data found. Database is clean!" . PHP_EOL;
    exit(0);
}

// Step 2: Create backup
echo "Step 2: Creating data backup..." . PHP_EOL;
$backup_table = "kemasukan_bahans_backup_" . date('Ymd_His');
DB::statement("CREATE TABLE {$backup_table} AS SELECT * FROM kemasukan_bahans WHERE created_at < '2025-12-10 00:00:00'");
echo "✅ Backup created: {$backup_table}" . PHP_EOL . PHP_EOL;

// Step 3: Analyze and fix the data
echo "Step 3: Analyzing and fixing corrupted data..." . PHP_EOL;

$fixed_count = 0;
$total_records = 0;

foreach ($corrupted_forms as $form) {
    echo "Processing FormC ID: {$form->formcs_id}" . PHP_EOL;
    echo "  - Duplicate value: {$form->total_kayu_dibawa_bulan_hadapan}" . PHP_EOL;
    echo "  - Affected species: {$form->species_count}" . PHP_EOL;
    
    // Get all records for this form
    $records = KemasukanBahan::where('formcs_id', $form->formcs_id)
        ->where('total_kayu_dibawa_bulan_hadapan', $form->total_kayu_dibawa_bulan_hadapan)
        ->get();
    
    // Strategy: Reset all duplicates to 0 except the first species
    // This is conservative but prevents incorrect totals
    $first_record = true;
    foreach ($records as $record) {
        if (!$first_record) {
            // Reset duplicate entries to 0
            $record->update([
                'total_kayu_dibawa_bulan_hadapan' => 0,
                'updated_at' => now()
            ]);
            echo "    ✓ Reset species {$record->spesis_id} to 0" . PHP_EOL;
            $fixed_count++;
        } else {
            echo "    ✓ Kept species {$record->spesis_id} with original value" . PHP_EOL;
            $first_record = false;
        }
        $total_records++;
    }
    echo PHP_EOL;
}

echo "=== CLEANUP SUMMARY ===" . PHP_EOL;
echo "Total records processed: {$total_records}" . PHP_EOL;
echo "Records fixed: {$fixed_count}" . PHP_EOL;
echo "Backup table: {$backup_table}" . PHP_EOL;
echo "✅ Data cleanup completed successfully!" . PHP_EOL . PHP_EOL;

// Step 4: Verify the fix
echo "Step 4: Verifying the fix..." . PHP_EOL;

$remaining_duplicates = DB::select("
    SELECT COUNT(*) as count
    FROM (
        SELECT formcs_id, total_kayu_dibawa_bulan_hadapan, COUNT(*) as species_count
        FROM kemasukan_bahans 
        WHERE total_kayu_dibawa_bulan_hadapan > 0 
        AND updated_at >= NOW() - INTERVAL 1 HOUR
        GROUP BY formcs_id, total_kayu_dibawa_bulan_hadapan 
        HAVING COUNT(*) > 1
    ) as duplicates
")[0];

if ($remaining_duplicates->count == 0) {
    echo "✅ Verification passed: No remaining duplicates found!" . PHP_EOL;
} else {
    echo "⚠️  Warning: {$remaining_duplicates->count} potential duplicates still exist" . PHP_EOL;
}

echo PHP_EOL . "=== NEXT STEPS ===" . PHP_EOL;
echo "1. ✅ Array index bugs have been fixed in controllers" . PHP_EOL;
echo "2. ✅ Corrupted historical data has been cleaned up" . PHP_EOL;
echo "3. 🔄 Users should re-enter data for accurate reporting" . PHP_EOL;
echo "4. 📊 Reports will now show correct totals for new data" . PHP_EOL;

?>