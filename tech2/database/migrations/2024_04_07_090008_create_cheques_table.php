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
        Schema::create('cheques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id');
            $table->foreignId('customer_id');
            $table->string('cheque_number');
            $table->string('cheque_branch');
            $table->string('cheque_bank');
            $table->string('status');
            $table->decimal('amount',15,2);
            $table->decimal('balance',15,2);
            $table->date('cheque_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheques');
    }
};
