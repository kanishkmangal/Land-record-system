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
        Schema::create('land_transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('land_record_id')->constrained('land_records')->onDelete('cascade');
            $table->foreignId('from_owner_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('to_owner_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('transfer_date')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('remarks')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_transfer_requests');
    }
};
