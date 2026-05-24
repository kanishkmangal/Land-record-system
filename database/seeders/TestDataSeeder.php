<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create a Test Citizen
        $citizen = \App\Models\User::firstOrCreate(
            ['email' => 'citizen@test.com'],
            [
                'name' => 'John Doe (Test Citizen)',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'citizen',
                'phone' => '1234567890',
                'address' => '123 Test Street'
            ]
        );

        // 1.5 Create a Test Admin
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'System Admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
                'phone' => '0987654321',
                'address' => 'Admin HQ'
            ]
        );

        // 2. Create a Land Record for this Citizen
        $landRecord = \App\Models\LandRecord::firstOrCreate(
            ['record_number' => 'LR-2024-TEST01'],
            [
                'owner_id' => $citizen->id,
                'plot_number' => '101A',
                'survey_number' => 'SVY-101',
                'area_sqft' => 1500,
                'land_type' => 'residential',
                'location' => 'Downtown Test Area',
                'district' => 'Central',
                'state' => 'Test State',
                'status' => 'active',
            ]
        );

        // 3. Create a Pending Property Tax for this Land Record
        \App\Models\PropertyTax::firstOrCreate(
            ['land_record_id' => $landRecord->id, 'financial_year' => '2023-2024'],
            [
                'base_amount' => 500.00,
                'penalty_amount' => 50.00,
                'total_amount' => 550.00,
                'due_date' => now()->addDays(30)->toDateString(),
                'status' => 'pending',
            ]
        );
    }
}
