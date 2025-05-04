<?php

namespace Database\Factories;

use App\Models\OptionValue;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductOption>
 */
class ProductOptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $optionValue = OptionValue::inRandomOrder()->first();

        return [
            'product_id' => $product->id,
            'option_value_id' => $optionValue->id,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
