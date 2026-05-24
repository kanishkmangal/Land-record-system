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
        Schema::create('property_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('land_record_id')->constrained('land_records')->onDelete('cascade');
            $table->string('financial_year');
            $table->decimal('base_amount', 15, 2);
            $table->decimal('penalty_amount', 15, 2)->default(0.00);
            $table->decimal('total_amount', 15, 2);
            $table->date('due_date');
            $table->enum('status', ['pending', 'paid', 'overdue'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('property_taxes');
    }
};
