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
        Schema::create('bank_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id');
            $table->foreignId('payment_id')->nullable();
            $table->foreignId('expense_id')->nullable();
            $table->decimal('amount',15,2);
            $table->decimal('debit_amount',15,2)->nullable();
            $table->decimal('credit_amount',15,2)->nullable();
            $table->decimal('bank_balance',15,2);
            $table->string('reason');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_details');
    }
};
