<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $user = App\Models\User::where('role', 'citizen')->first();
    if (!$user) {
        $user = App\Models\User::create([
            'name' => 'Test Citizen',
            'email' => 'citizen@test.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'citizen',
            'phone' => '1234567890',
            'address' => 'Citizen Addr'
        ]);
    }
    
    $record = App\Models\LandRecord::where('owner_id', $user->id)->first();
    if (!$record) {
        $record = App\Models\LandRecord::create([
            'record_number' => 'LR-' . strtoupper(uniqid()),
            'owner_id' => $user->id,
            'land_type' => 'residential',
            'area_sqft' => 2000,
            'location' => 'Test Location',
            'district' => 'Test District',
            'state' => 'Test State',
            'survey_number' => '123',
            'plot_number' => '456',
            'status' => 'active',
        ]);
    }
    
    $transferee = App\Models\User::firstOrCreate(
        ['email' => 'buyer@test.com'],
        [
            'name' => 'Buyer',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'role' => 'citizen',
            'phone' => '0000',
            'address' => 'Addr'
        ]
    );
    
    $transfer = App\Models\LandTransferRequest::create([
        'land_record_id' => $record->id,
        'from_owner_id' => $user->id,
        'to_owner_id' => $transferee->id,
        'status' => 'pending',
        'remarks' => 'Test',
        'document_path' => 'test.pdf'
    ]);
    
    echo "Transfer created successfully! ID: " . $transfer->id . "\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
