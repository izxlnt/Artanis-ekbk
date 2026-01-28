<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Get the authenticated user's shuttle_id (replace with actual user email or shuttle info)
echo "Enter user email to check: ";
$email = trim(fgets(STDIN));

$user = \App\Models\User::where('email', $email)->first();

if (!$user) {
    echo "User not found!\n";
    exit;
}

echo "\n=== User Info ===\n";
echo "Name: " . $user->name . "\n";
echo "Email: " . $user->email . "\n";
echo "Shuttle ID: " . $user->shuttle_id . "\n";
echo "Created at: " . $user->created_at . "\n";
echo "Shuttle Type: " . $user->shuttle_type . "\n";

// Check Form A records for this shuttle
$formAs = \App\Models\FormA::where('shuttle_id', $user->shuttle_id)->get();

echo "\n=== Form A Records ===\n";
if ($formAs->count() > 0) {
    foreach ($formAs as $forma) {
        echo "ID: {$forma->id}, Year: {$forma->tahun}, Status: {$forma->status}, Created: {$forma->created_at}\n";
    }
} else {
    echo "No Form A records found for this shuttle!\n";
}

// Check what forms are required
echo "\n=== Required Forms ===\n";
$requirements = \App\Services\FormRequirementService::getRequiredForms($user->created_at);
echo "Current Year: " . $requirements['current_year'] . "\n";
echo "Registration Year: " . $requirements['registration_year'] . "\n";
echo "Years to fill: " . implode(', ', $requirements['years_to_fill']) . "\n";
echo "Form A required for years: " . implode(', ', $requirements['forma_required']) . "\n";
echo "Message: " . $requirements['message'] . "\n";

echo "\n=== Shuttle Info ===\n";
$shuttle = \App\Models\Shuttle::where('id', $user->shuttle_id)->first();
if ($shuttle) {
    echo "Shuttle ID: {$shuttle->id}\n";
    echo "Nama Kilang: {$shuttle->nama_kilang}\n";
    echo "Tahun: " . ($shuttle->tahun ?? 'NULL') . "\n";
}
