<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $connection = DB::connection()->getPdo()->getAttribute(\PDO::ATTR_DRIVER_NAME);

        if ($connection === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } elseif ($connection === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        }

        $this->call(OptionCategoriesTableSeeder::class);
        $this->call(OptionValuesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductOptionsTableSeeder::class);

        if ($connection === 'mysql') {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        } elseif ($connection === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        }
    }
}
