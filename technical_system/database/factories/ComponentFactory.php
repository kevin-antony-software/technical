<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Component>
 */
class ComponentFactory extends Factory
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
            'cost' => $this->faker->numerify('#####'),
            'price' => $this->faker->numerify('#####'),
            'component_category_id' => $this->faker->numberBetween(1,50),
        ];
    }
}
