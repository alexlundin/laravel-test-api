<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OptionCategory>
 */
class OptionCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Страна', 'Цвет плафона', 'Цвет арматуры', 'Количество ламп']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
