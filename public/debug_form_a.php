<?php
// Debug script to check Form A data
// Run this via browser: http://127.0.0.1:8000/debug_form_a.php?login_id=640101066291

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$loginId = $_GET['login_id'] ?? null;

if (!$loginId) {
    die("Please provide login ID: ?login_id=640101066291");
}

// Find user by login_id
$user = App\Models\User::where('login_id', $loginId)->first();

if (!$user) {
    die("User not found with login_id: $loginId");
}

echo "<h2>User Information (Login ID: {$loginId})</h2>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Field</th><th>Value</th></tr>";
echo "<tr><td>User ID</td><td>{$user->id}</td></tr>";
echo "<tr><td>Name</td><td>{$user->name}</td></tr>";
echo "<tr><td>Email</td><td>{$user->email}</td></tr>";
echo "<tr><td>Shuttle ID</td><td>" . ($user->shuttle_id ?? '<strong style="color:red">NULL</strong>') . "</td></tr>";
echo "<tr><td>Shuttle Type</td><td>{$user->shuttle_type}</td></tr>";
echo "</table>";

if ($user->shuttle_id) {
    $shuttle = App\Models\Shuttle::find($user->shuttle_id);
    
    if ($shuttle) {
        echo "<h3>Shuttle/Kilang Information</h3>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        echo "<tr><td>Shuttle ID</td><td>{$shuttle->id}</td></tr>";
        echo "<tr><td>Nama Kilang</td><td>{$shuttle->nama_kilang}</td></tr>";
        echo "<tr><td>Shuttle Type</td><td>{$shuttle->shuttle_type}</td></tr>";
        echo "</table>";
        
        // Get all FormA records for this shuttle
        echo "<h3>Form A Records for This Shuttle</h3>";
        $formAs = App\Models\FormA::where('shuttle_id', $shuttle->id)
            ->orderBy('tahun', 'desc')
            ->get();
        
        if ($formAs->count() > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>Tahun</th><th>Status</th><th>Created At</th><th>Updated At</th></tr>";
            foreach ($formAs as $formA) {
                echo "<tr>";
                echo "<td>{$formA->id}</td>";
                echo "<td><strong>{$formA->tahun}</strong></td>";
                echo "<td>{$formA->status}</td>";
                echo "<td>{$formA->created_at}</td>";
                echo "<td>{$formA->updated_at}</td>";
                echo "</tr>";
            }
            echo "</table>";
            
            // Show details of the most recent FormA
            $latestFormA = $formAs->first();
            echo "<h3>Latest Form A Details (ID: {$latestFormA->id}, Year: {$latestFormA->tahun})</h3>";
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>Field</th><th>Value</th></tr>";
            
            $reflection = new ReflectionClass($latestFormA);
            $properties = $reflection->getProperties(ReflectionProperty::IS_PUBLIC | ReflectionProperty::IS_PROTECTED);
            
            foreach ($latestFormA->getAttributes() as $key => $value) {
                if (!in_array($key, ['created_at', 'updated_at'])) {
                    $displayValue = $value ?? '<em style="color:gray">NULL</em>';
                    if (is_numeric($displayValue)) {
                        $displayValue = number_format($displayValue, 2);
                    }
                    echo "<tr><td>{$key}</td><td>{$displayValue}</td></tr>";
                }
            }
            echo "</table>";
            
        } else {
            echo "<p style='color:red;font-weight:bold'>⚠ No Form A records found for this shuttle</p>";
        }
        
    } else {
        echo "<p style='color:red;font-weight:bold'>⚠ Shuttle record NOT FOUND</p>";
    }
} else {
    echo "<p style='color:red;font-weight:bold'>⚠ User has NO shuttle_id assigned</p>";
}

echo "<br><hr>";
echo "<p><a href='?login_id={$loginId}'>Refresh</a></p>";
echo "<p><em>Delete this file after debugging for security!</em></p>";
?>
