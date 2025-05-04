<?php

namespace Database\Seeders;

use App\Models\OptionCategory;
use App\Models\OptionValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OptionValuesTableSeeder extends Seeder
{
    public function run(): void
    {
        $connection = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME);

        if ($connection === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($connection === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }

        DB::table('option_values')->truncate();

        if ($connection === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($connection === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }

        $this->seedCountries();
        $this->seedColors();
        $this->seedMaterials();
        $this->seedStyles();
        $this->seedLampCounts();
    }

    private function seedCountries(): void
    {
        $category = OptionCategory::where('name', 'Страна')->first();

        $countries = ['Италия', 'Китай', 'Германия', 'Россия', 'Испания'];

        foreach ($countries as $country) {
            OptionValue::firstOrCreate([
                'option_category_id' => $category->id,
                'value' => $country,
            ]);
        }
    }

    private function seedColors(): void
    {
        $category = OptionCategory::where('name', 'Цвет плафона')->first();

        $colors = ['Белый', 'Черный', 'Прозрачный', 'Красный', 'Синий', 'Зеленый'];

        foreach ($colors as $color) {
            OptionValue::firstOrCreate([
                'option_category_id' => $category->id,
                'value' => $color,
            ]);
        }

        $category = OptionCategory::where('name', 'Цвет арматуры')->first();

        $colors = ['Золотой', 'Серебряный', 'Черный', 'Белый', 'Бронзовый'];

        foreach ($colors as $color) {
            OptionValue::firstOrCreate([
                'option_category_id' => $category->id,
                'value' => $color,
            ]);
        }
    }

    private function seedMaterials(): void
    {
        $category = OptionCategory::where('name', 'Материал')->first();

        $materials = ['Металл', 'Стекло', 'Пластик', 'Дерево', 'Хрусталь'];

        foreach ($materials as $material) {
            OptionValue::firstOrCreate([
                'option_category_id' => $category->id,
                'value' => $material,
            ]);
        }
    }

    private function seedStyles(): void
    {
        $category = OptionCategory::where('name', 'Стиль')->first();

        $styles = ['Современный', 'Классический', 'Лофт', 'Минимализм', 'Хай-тек'];

        foreach ($styles as $style) {
            OptionValue::firstOrCreate([
                'option_category_id' => $category->id,
                'value' => $style,
            ]);
        }
    }

    private function seedLampCounts(): void
    {
        $category = OptionCategory::where('name', 'Количество ламп')->first();

        $counts = ['1', '2', '3', '4', '5', '6', '8', '10', '12'];

        foreach ($counts as $count) {
            OptionValue::firstOrCreate([
                'option_category_id' => $category->id,
                'value' => $count,
            ]);
        }
    }
}
