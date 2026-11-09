<?php

namespace Database\Seeders;

use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'brand_name' => 'Boss',
                'slug' => 'boss',
                'brand_image' => 'https://upload.wikimedia.org/wikipedia/commons/7/7a/SUNTORY_BOSS.png?20230629165611',
                'is_archive' => null,
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'brand_name' => 'Versace',
                'slug' => 'versace',
                'brand_image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Emblema_Grupo_Versace.png/640px-Emblema_Grupo_Versace.png',
                'is_archive' => null,
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'brand_name' => 'Versace Jeans Couture',
                'slug' => 'versace-jeans-couture',
                'brand_image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Versace.png/640px-Versace.png',
                'is_archive' => null,
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'brand_name' => 'Louis Vuitton',
                'slug' => 'louis-vuitton',
                'brand_image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cb/Louis_Vuitton_LV_logo.png/640px-Louis_Vuitton_LV_logo.png',
                'is_archive' => null,
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'brand_name' => 'Emporio Armani',
                'slug' => 'emporio-armani',
                'brand_image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Emporio_Armani_logo.svg/640px-Emporio_Armani_logo.svg.png',
                'is_archive' => null,
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'brand_name' => 'Burberry',
                'slug' => 'burberry',
                'brand_image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/b/b4/Logo_Burberry_01.svg/640px-Logo_Burberry_01.svg.png',
                'is_archive' => null,
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'brand_name' => 'Under Armour',
                'slug' => 'under-armour',
                'brand_image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/44/Under_armour_logo.svg/640px-Under_armour_logo.svg.png',
                'is_archive' => null,
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'brand_name' => 'CR7',
                'slug' => 'cr7',
                'brand_image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/a4/CR7-Logo-1.png/640px-CR7-Logo-1.png',
                'is_archive' => null,
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'brand_name' => 'Arrow',
                'slug' => 'arrow',
                'brand_image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/Logo_arrows_bk.svg/1024px-Logo_arrows_bk.svg.png?20221022131157',
                'is_archive' => null,
            ],

        ];
        Brand::insert($brands);
    }
}
