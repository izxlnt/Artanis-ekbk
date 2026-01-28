<?php
/**
 * Clear Laravel Cache Script
 * Upload this file to your live server root and run it via browser
 * Then delete this file after use for security
 */

// Detect Laravel root path (one level up from public folder)
$laravelPath = dirname(__DIR__);

echo "Detected Laravel path: " . $laravelPath . "<br><br>";

// Clear view cache
$viewCachePath = $laravelPath . '/storage/framework/views';
if (is_dir($viewCachePath)) {
    $files = glob($viewCachePath . '/*');
    foreach ($files as $file) {
        if (is_file($file)) {
            unlink($file);
        }
    }
    echo "✓ View cache cleared<br>";
} else {
    echo "✗ View cache directory not found<br>";
}

// Clear compiled cache
$cachePath = $laravelPath . '/bootstrap/cache/config.php';
if (file_exists($cachePath)) {
    unlink($cachePath);
    echo "✓ Config cache cleared<br>";
} else {
    echo "✗ Config cache not found<br>";
}

// Clear route cache
$routeCachePath = $laravelPath . '/bootstrap/cache/routes-v7.php';
if (file_exists($routeCachePath)) {
    unlink($routeCachePath);
    echo "✓ Route cache cleared<br>";
} else {
    echo "✗ Route cache not found<br>";
}

echo "<br><strong>Cache clearing completed!</strong><br>";
echo "<br><em>Remember to delete this file (clear_cache.php) from your server for security!</em>";
?>
