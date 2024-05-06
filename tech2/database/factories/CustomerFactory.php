<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

                'name' => fake()->name(),
                'address' => $this->faker->address(),
                'mobile' => $this->faker->numerify('##########'),
                'land_phone' => $this->faker->numerify('##########'),
                'company' => $this->faker->company(),

        ];
    }
}
