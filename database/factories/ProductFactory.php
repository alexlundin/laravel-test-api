<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Люстра Colosseo', 'Люстра Astro', 'Люстра Padana Lampadari', 'Люстра N-Light']),
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 500, 2500),
            'quantity' => $this->faker->numberBetween(1, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
