<?php

namespace Database\Seeders;

use App\Models\Component;
use App\Models\ComponentCategory;
use App\Models\Customer;
use App\Models\MachineModel;
use App\Models\Note;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Note::factory(100)->create();
        // Customer::factory(50)->create();
        // ComponentCategory::factory(50)->create();
        // Component::factory(50)->create();
        MachineModel::factory(100)->create();
    }
}
