<?php

namespace Database\Seeders;

use App\Models\OptionCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionCategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        $connection = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME);

        if ($connection === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($connection === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }

        DB::table('option_categories')->truncate();

        if ($connection === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($connection === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }

        $categories = [
            'Страна',
            'Цвет плафона',
            'Цвет арматуры',
            'Количество ламп',
            'Материал',
            'Стиль',
        ];

        foreach ($categories as $category) {
            OptionCategory::firstOrCreate(['name' => $category]);
        }
    }
}
