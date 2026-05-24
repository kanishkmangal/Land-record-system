<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE land_records MODIFY COLUMN land_type ENUM('residential', 'commercial', 'agricultural', 'industrial') NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE land_records MODIFY COLUMN land_type ENUM('residential', 'commercial', 'agricultural') NOT NULL");
    }
};
