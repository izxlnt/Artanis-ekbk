<?php
// Debug script to check user data
// Run this via browser: http://127.0.0.1:8000/debug_user.php?id=1750

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$userId = $_GET['id'] ?? null;

if (!$userId) {
    die("Please provide user ID: ?id=1750");
}

$user = App\Models\User::find($userId);

if (!$user) {
    die("User not found with ID: $userId");
}

echo "<h2>User Information (ID: {$userId})</h2>";
echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Field</th><th>Value</th></tr>";
echo "<tr><td>Name</td><td>{$user->name}</td></tr>";
echo "<tr><td>Email</td><td>{$user->email}</td></tr>";
echo "<tr><td>Login ID</td><td>{$user->login_id}</td></tr>";
echo "<tr><td>Shuttle ID</td><td>" . ($user->shuttle_id ?? '<strong style="color:red">NULL</strong>') . "</td></tr>";
echo "<tr><td>Shuttle Type</td><td>{$user->shuttle_type}</td></tr>";
echo "<tr><td>Pengguna Kilang ID</td><td>" . ($user->pengguna_kilang_id ?? '<strong style="color:red">NULL</strong>') . "</td></tr>";
echo "<tr><td>Is Approved</td><td>{$user->is_approved}</td></tr>";
echo "<tr><td>Kategori Pengguna</td><td>{$user->kategori_pengguna}</td></tr>";
echo "</table>";

if ($user->shuttle_id) {
    echo "<h3>Checking Shuttle Record...</h3>";
    $shuttle = App\Models\Shuttle::find($user->shuttle_id);
    
    if ($shuttle) {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        echo "<tr><td>Shuttle ID</td><td>{$shuttle->id}</td></tr>";
        echo "<tr><td>Nama Kilang</td><td>{$shuttle->nama_kilang}</td></tr>";
        echo "<tr><td>No. Lesen</td><td>" . ($shuttle->no_lesen ?? '<strong style="color:red">NULL</strong>') . "</td></tr>";
        echo "<tr><td>No. SSM</td><td>" . ($shuttle->no_ssm ?? '<strong style="color:red">NULL</strong>') . "</td></tr>";
        echo "<tr><td>Shuttle Type</td><td>{$shuttle->shuttle_type}</td></tr>";
        echo "</table>";
    } else {
        echo "<p style='color:red;font-weight:bold'>⚠ Shuttle record NOT FOUND with ID: {$user->shuttle_id}</p>";
        echo "<p>This is the problem! User has shuttle_id={$user->shuttle_id} but this shuttle doesn't exist in the database.</p>";
    }
} else {
    echo "<p style='color:red;font-weight:bold'>⚠ User has NO shuttle_id assigned</p>";
    echo "<p>This user needs to be assigned to a shuttle/kilang.</p>";
}

echo "<br><hr>";
echo "<p><a href='?id={$userId}'>Refresh</a> | <a href='/admin/status-permohonan-shuttle-{$user->shuttle_type}'>Back to Status Page</a></p>";
echo "<p><em>Delete this file after debugging for security!</em></p>";
?>
