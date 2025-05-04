<?php

namespace Database\Seeders;

use App\Models\OptionCategory;
use App\Models\OptionValue;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductOptionsTableSeeder extends Seeder
{
    public function run(): void
    {
        $connection = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME);

        if ($connection === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($connection === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }

        DB::table('product_options')->truncate();

        if ($connection === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($connection === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }

        $products = Product::all();

        $categories = OptionCategory::all();

        foreach ($products as $product) {
            foreach ($categories as $category) {
                $optionValue = OptionValue::where('option_category_id', $category->id)
                    ->inRandomOrder()
                    ->first();

                if ($optionValue) {
                    ProductOption::create([
                        'product_id' => $product->id,
                        'option_value_id' => $optionValue->id,
                    ]);
                }
            }
        }
    }
}
