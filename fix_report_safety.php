<?php

/**
 * Quick fix for report array access issues
 * Run this after backing up the original file
 */

$file = '/home/muhammad-faiz-abdullah/Documents/Development/Artanis-ekbk/app/Http/Controllers/Laporan/ExcelController.php';

echo "Creating backup...\n";
copy($file, $file . '.backup.' . date('Y-m-d-H-i-s'));

$content = file_get_contents($file);

// Add safe array access method if not already present
if (strpos($content, 'getFirstResult') === false) {
    $helper_method = "    /**\n     * Helper function to safely get first result from DB query\n     */\n    private function getFirstResult(\$query_result) {\n        return !empty(\$query_result) ? \$query_result[0] : null;\n    }\n\n";
    
    $content = str_replace('class ExcelController extends Controller
{', "class ExcelController extends Controller\n{\n$helper_method", $content);
}

// Replace dangerous patterns with safer ones
$patterns = [
    // Replace ")[0]; with safer access
    '/\)\"\)\[0\];/' => '");
        if (!empty($query_result)) {
            $result = $query_result[0];
        } else {
            $result = null;
        }',
    
    // Replace specific variable assignments with null-safe versions
    '/\$data_form_b_s\[\$data_shuttle->id\] = DB::select\(/' => '$query_result = DB::select(',
    '/\$data_kemasukan_bahans\[\$data_shuttle->id\] = DB::select\(/' => '$query_result = DB::select(',
    '/\$data_form_d_s\[\$data_shuttle->id\] = DB::select\(/' => '$query_result = DB::select('
];

foreach ($patterns as $pattern => $replacement) {
    $content = preg_replace($pattern, $replacement, $content);
}

file_put_contents($file, $content);
echo "Report controller updated with safer array access patterns\n";