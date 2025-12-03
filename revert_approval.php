<?php
/**
 * Script to revert accidentally approved FormB
 * Usage: php revert_approval.php [form_id]
 */

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\FormB;
use App\Models\UlasanIpjpsm;
use App\Models\GunaTenaga;
use Illuminate\Support\Facades\DB;

if ($argc < 2) {
    echo "Usage: php revert_approval.php [form_id]\n";
    echo "Example: php revert_approval.php 123\n";
    exit(1);
}

$formId = $argv[1];

if (!is_numeric($formId)) {
    echo "Error: Form ID must be a number\n";
    exit(1);
}

try {
    DB::beginTransaction();
    
    // 1. Find the form
    $form = FormB::find($formId);
    if (!$form) {
        echo "Error: Form with ID {$formId} not found\n";
        exit(1);
    }
    
    echo "Found FormB ID: {$formId}\n";
    echo "Current Status: {$form->status}\n";
    echo "Factory: {$form->shuttle->nama_kilang}\n\n";
    
    if ($form->status !== 'Lulus') {
        echo "Warning: This form is not in 'Lulus' status. Current status: {$form->status}\n";
        echo "Do you want to continue? (y/n): ";
        $handle = fopen("php://stdin", "r");
        $confirmation = trim(fgets($handle));
        fclose($handle);
        
        if (strtolower($confirmation) !== 'y') {
            echo "Operation cancelled.\n";
            exit(0);
        }
    }
    
    // 2. Revert status to 'Dihantar ke IPJPSM'
    $form->status = 'Dihantar ke IPJPSM';
    $form->save();
    echo "✓ Status reverted to 'Dihantar ke IPJPSM'\n";
    
    // 3. Remove IPJPSM comments (keep the most recent one, delete others)
    $ulasanCount = UlasanIpjpsm::where('formbs_id', $formId)->count();
    if ($ulasanCount > 0) {
        // Keep the oldest comment, remove newer ones (in case of multiple reviews)
        $latestUlasan = UlasanIpjpsm::where('formbs_id', $formId)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if ($latestUlasan) {
            $latestUlasan->delete();
            echo "✓ Removed latest IPJPSM comment (ID: {$latestUlasan->id})\n";
        }
    }
    
    // 4. Clear finalized laporan data (optional)
    echo "Do you want to clear the finalized laporan data to allow re-editing? (y/n): ";
    $handle = fopen("php://stdin", "r");
    $clearData = trim(fgets($handle));
    fclose($handle);
    
    if (strtolower($clearData) === 'y') {
        $gunaTenagas = GunaTenaga::where('formbs_id', $formId)->get();
        foreach ($gunaTenagas as $gt) {
            $gt->pekerja_wargabumi_lelaki_laporan = null;
            $gt->pekerja_wargabumi_perempuan_laporan = null;
            $gt->pekerja_bukan_wargabumi_lelaki_laporan = null;
            $gt->pekerja_bukan_wargabumi_perempuan_laporan = null;
            $gt->pekerja_asing_lelaki_laporan = null;
            $gt->pekerja_asing_perempuan_laporan = null;
            $gt->save();
        }
        echo "✓ Cleared finalized laporan data for re-editing\n";
    }
    
    DB::commit();
    
    echo "\n✅ Successfully reverted FormB ID {$formId}\n";
    echo "The form is now back in 'Dihantar ke IPJPSM' status and will appear in the pending list again.\n";
    
} catch (Exception $e) {
    DB::rollback();
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}