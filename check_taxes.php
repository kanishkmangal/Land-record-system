<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$app->boot();

use App\Models\PropertyTax;
use App\Models\LandRecord;
use App\Models\User;

echo "=== Land Records & Owners ===\n";
foreach (LandRecord::with('owner')->get() as $r) {
    $ownerName = $r->owner ? $r->owner->name : 'N/A';
    echo "Record #{$r->id} ({$r->record_number}) - Owner: {$r->owner_id} ({$ownerName})\n";
}

echo "\n=== Property Taxes ===\n";
foreach (PropertyTax::with('landRecord.owner')->get() as $t) {
    $ownerName = ($t->landRecord && $t->landRecord->owner) ? $t->landRecord->owner->name : 'N/A';
    $ownerId = ($t->landRecord) ? $t->landRecord->owner_id : 'N/A';
    echo "Tax #{$t->id} - Land #{$t->land_record_id} - Owner: {$ownerId} ({$ownerName}) - Status: {$t->status} - Amount: {$t->total_amount}\n";
}

echo "\n=== Pending Tax per User ===\n";
foreach (User::where('role', 'citizen')->get() as $user) {
    $pending = PropertyTax::whereHas('landRecord', function($q) use ($user) {
        $q->where('owner_id', $user->id);
    })->where('status', 'pending')->sum('total_amount');
    echo "User #{$user->id} ({$user->name}) - Pending Tax: {$pending}\n";
}
