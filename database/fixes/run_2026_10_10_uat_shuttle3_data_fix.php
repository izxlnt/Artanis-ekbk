<?php
// Runs 2026_10_10_uat_shuttle3_data_fix.sql against the DB in .env, statement by statement,
// printing how many rows each preview finds and each fix changes.
// Usage (from the project root):  php database/fixes/run_2026_10_10_uat_shuttle3_data_fix.php
// A backup of every affected row was taken on 2026-10-10 in
// storage/app/backup/before_uat_fix_2026_10_10.json
$root = dirname(__DIR__, 2);
require $root . '/vendor/autoload.php';
$app = require_once $root . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
set_time_limit(0);

use Illuminate\Support\Facades\DB;

echo 'Database: ', DB::connection()->getDatabaseName(), "\n";
$sql = file_get_contents(__DIR__ . '/2026_10_10_uat_shuttle3_data_fix.sql');
$sql = preg_replace('/^\s*--.*$/m', '', $sql);
foreach (array_values(array_filter(array_map('trim', preg_split('/;\s*$/m', $sql)))) as $i => $stmt) {
    $kind = strtoupper(strtok($stmt, " \r\n"));
    $t0 = microtime(true);
    $msg = $kind === 'SELECT'
        ? count(DB::select($stmt)) . ' rows found'
        : DB::affectingStatement($stmt) . ' rows changed';
    printf("#%-2d %-6s %-50s -> %s (%.1fs)\n", $i + 1, $kind, substr(preg_replace('/\s+/', ' ', $stmt), 0, 50), $msg, microtime(true) - $t0);
}
