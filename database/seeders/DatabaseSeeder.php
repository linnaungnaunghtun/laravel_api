<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PosUserSeeder::class,
            SliderSeeder::class,
            BrandSeeder::class,
            ProductTypeSeeder::class,
            ProductSeeder::class,
            CategorySeeder::class,
            SizeSeeder::class,
            FitSeeder::class,
            LevelSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
