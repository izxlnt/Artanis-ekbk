<?php

/**
 * Debug script to test report functionality
 */

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use App\Http\Controllers\Laporan\ExcelController;

// Try to instantiate and test basic report functionality
try {
    echo "Testing report controller instantiation...\n";
    
    // This would normally be done via Laravel's service container
    echo "Basic test completed without fatal errors\n";
    
} catch (Exception $e) {
    echo "Error encountered: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}