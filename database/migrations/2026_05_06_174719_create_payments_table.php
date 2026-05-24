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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_tax_id')->constrained('property_taxes')->onDelete('cascade');
            $table->foreignId('citizen_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount_paid', 15, 2);
            $table->enum('payment_method', ['online', 'cash', 'cheque']);
            $table->string('transaction_id')->nullable();
            $table->timestamp('payment_date');
            $table->string('receipt_number')->unique();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
