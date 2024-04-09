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
        Schema::create('repair_job_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repair_job_id');
            $table->foreignId('component_id');
            $table->bigInteger('qty');
            $table->decimal('sub_total', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_job_details');
    }
};
