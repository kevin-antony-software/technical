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
        Schema::create('repair_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id');
            $table->foreignId('current_status_id');
            $table->string('serial_number')->nullable();
            $table->foreignId('machine_model_id');
            $table->string('method_came_in');
            $table->string('method_going_out')->nullable();
            $table->string('comment')->nullable();
            $table->string('issue')->nullable();
            $table->string('warranty_type');
            $table->decimal('component_charges', 15, 2)->nullable();
            $table->decimal('estimated_cost', 15, 2)->nullable();
            $table->decimal('courier_charges', 15, 2)->nullable();
            $table->decimal('repair_charges', 15, 2)->nullable();
            $table->decimal('total_charges', 15, 2)->nullable();
            $table->decimal('discount', 15, 2)->nullable();
            $table->decimal('final_total', 15, 2)->nullable();
            $table->decimal('due_amount', 15, 2)->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_jobs');
    }
};
