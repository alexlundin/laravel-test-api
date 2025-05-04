<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    public function run(): void
    {
        $connection = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME);

        if ($connection === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($connection === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }

        DB::table('products')->truncate();

        if ($connection === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($connection === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }

        $products = [
            [
                'name' => 'Люстра Хрустальная',
                'description' => 'Роскошная хрустальная люстра для гостиной',
                'price' => 15000,
            ],
            [
                'name' => 'Светильник настенный Модерн',
                'description' => 'Современный настенный светильник для спальни',
                'price' => 3500,
            ],
            [
                'name' => 'Торшер Классика',
                'description' => 'Классический торшер с абажуром',
                'price' => 7800,
            ],
            [
                'name' => 'Люстра Минимализм',
                'description' => 'Минималистичная люстра для кухни',
                'price' => 5200,
            ],
            [
                'name' => 'Бра Лофт',
                'description' => 'Настенное бра в стиле лофт',
                'price' => 2300,
            ],
            [
                'name' => 'Подвесной светильник Хай-тек',
                'description' => 'Современный подвесной светильник',
                'price' => 4700,
            ],
            [
                'name' => 'Люстра Италия',
                'description' => 'Итальянская люстра ручной работы',
                'price' => 18500,
            ],
            [
                'name' => 'Настольная лампа Тиффани',
                'description' => 'Настольная лампа в стиле Тиффани',
                'price' => 6300,
            ],
            [
                'name' => 'Потолочный светильник LED',
                'description' => 'Современный LED светильник для потолка',
                'price' => 3900,
            ],
            [
                'name' => 'Люстра Венеция',
                'description' => 'Венецианская люстра из муранского стекла',
                'price' => 25000,
            ],
            [
                'name' => 'Бра Классика Золото',
                'description' => 'Классическое бра с золотым покрытием',
                'price' => 4200,
            ],
            [
                'name' => 'Торшер Модерн',
                'description' => 'Современный торшер с регулируемой высотой',
                'price' => 8500,
            ],
            [
                'name' => 'Люстра Прованс',
                'description' => 'Люстра в стиле прованс для столовой',
                'price' => 12300,
            ],
            [
                'name' => 'Светильник для ванной',
                'description' => 'Влагозащищенный светильник для ванной комнаты',
                'price' => 2800,
            ],
            [
                'name' => 'Подвесной светильник Лофт',
                'description' => 'Индустриальный подвесной светильник',
                'price' => 5600,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
