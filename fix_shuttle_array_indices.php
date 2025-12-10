<?php

// Script to fix hardcoded [0] array indices in Shuttle controllers

$files = [
    '/home/muhammad-faiz-abdullah/Documents/Development/Artanis-ekbk/app/Http/Controllers/ShuttleFour/FormCController.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        
        // Fix the specific pattern: total_kayu_dibawa_bulan_hadapan[0]
        // Replace with $keySpecies variable
        $patterns = [
            "/(\s+)'total_kayu_dibawa_bulan_hadapan' => \$request->total_kayu_dibawa_bulan_hadapan\[0\]/",
            "/(\s+)\$data->total_kayu_dibawa_bulan_hadapan = \$request->total_kayu_dibawa_bulan_hadapan\[0\]/"
        ];
        
        $replacements = [
            "$1'total_kayu_dibawa_bulan_hadapan' => \$request->total_kayu_dibawa_bulan_hadapan[\$keySpecies]",
            "$1\$data->total_kayu_dibawa_bulan_hadapan = \$request->total_kayu_dibawa_bulan_hadapan[\$keySpecies]"
        ];
        
        $original_content = $content;
        $content = preg_replace($patterns, $replacements, $content);
        
        if ($content !== $original_content) {
            file_put_contents($file, $content);
            echo "Fixed: $file\n";
            
            // Count fixes
            $fixes = [];
            preg_match_all($patterns[0], $original_content, $matches1);
            preg_match_all($patterns[1], $original_content, $matches2);
            $total_fixes = count($matches1[0]) + count($matches2[0]);
            echo "  - Applied $total_fixes fixes\n";
        } else {
            echo "No changes needed: $file\n";
        }
    } else {
        echo "File not found: $file\n";
    }
}

echo "Fix script completed.\n";
?>