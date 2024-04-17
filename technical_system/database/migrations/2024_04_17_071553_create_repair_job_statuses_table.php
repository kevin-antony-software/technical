<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repair_job_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->timestamps();
        });

        DB::table('repair_job_statuses')->insert([
            ['status' => 'Job-Created'],
            ['status' => 'Job-Started'],
            ['status' => 'Job-Estimated'],
            ['status' => 'Job-Closed'],
            ['status' => 'Job-Delivered'],

        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repair_job_statuses');
    }
};
