<?php

namespace Database\Factories;

use App\Models\OptionCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OptionValue>
 */
class OptionValueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = OptionCategory::inRandomOrder()->first();
        $values = [
            'Страна' => ['Россия', 'США', 'Китай', 'Германия', 'Франция', 'Голландия', 'Канада', 'Великобритания', 'Испания', 'Италия'],
            'Цвет плафона' => ['Бежевый', 'Белый', 'Серый', 'Черный', 'Коричневый', 'Голубой', 'Фиолетовый', 'Золотой', 'Серебряный', 'Бронзовый', 'Неокрашенный'],
            'Цвет арматуры' => ['Бежевый', 'Белый', 'Серый', 'Черный', 'Коричневый', 'Голубой', 'Фиолетовый', 'Золотой', 'Серебряный', 'Бронзовый', 'Неокрашенный'],
            'Количество ламп' => ['1', '2', '3', '4', '5', '6', '7', '8', '9 и более'],
        ];

        return [
            'option_category_id' => $category->id,
            'value' => $this->faker->randomElement($values[$category->name] ?? [$this->faker->word]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
