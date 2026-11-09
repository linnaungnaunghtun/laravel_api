<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'desktop_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'mobile_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'type' => 'portrait',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'desktop_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'mobile_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'type' => 'portrait',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'desktop_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'mobile_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'type' => 'landscape',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'desktop_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'mobile_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'type' => 'landscape',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'desktop_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'mobile_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'type' => 'portrait',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'desktop_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'mobile_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'type' => 'portrait',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'desktop_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'mobile_ads' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/1b/Adidas_2022_logo.svg/225px-Adidas_2022_logo.svg.png',
                'type' => 'landscape',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ];

        Banner::insert($banners);
    }
}
