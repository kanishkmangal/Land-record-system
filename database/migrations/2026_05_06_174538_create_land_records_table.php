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
        Schema::create('land_records', function (Blueprint $table) {
            $table->id();
            $table->string('record_number')->unique();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->string('plot_number');
            $table->string('survey_number');
            $table->decimal('area_sqft', 15, 2);
            $table->enum('land_type', ['residential', 'commercial', 'agricultural']);
            $table->string('location');
            $table->string('district');
            $table->string('state');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('document_path')->nullable();
            $table->enum('status', ['active', 'disputed', 'transferred'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_records');
    }
};
