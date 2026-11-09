<?php

namespace Database\Seeders;

use App\Models\Slider;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SliderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sliders = [
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'desktop_image' => 'https://images.hugoboss.com/is/image/hugobosscsprod/241118_HBME_112_WI24_BOSS_Kidswear_021_1920x880?%24large%24&fmt=webp&align=0,-1&fit=crop,1&ts=1739883172215&qlt=80&wid=1980&hei=907',
                'mobile_image' => 'https://images.hugoboss.com/is/image/hugobosscsprod/241118_HBME_112_WI24_BOSS_Kidswear_021_1920x880?%24large%24&fmt=webp&align=0,-1&fit=crop,1&ts=1739883172215&qlt=80&wid=1980&hei=907',
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'desktop_image' => 'https://images.hugoboss.com/is/image/hugobosscsprod/250121_HBME_112_SP25_Tier3_Gifting_1920x880?%24large%24&fmt=webp&align=0,-1&fit=crop,1&ts=1739539196843&qlt=80&wid=1980&hei=907',
                'mobile_image' => 'https://images.hugoboss.com/is/image/hugobosscsprod/250121_HBME_112_SP25_Tier3_Gifting_1920x880?%24large%24&fmt=webp&align=0,-1&fit=crop,1&ts=1739539196843&qlt=80&wid=1980&hei=907',
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'desktop_image' => 'https://images.hugoboss.com/is/image/hugobosscsprod/250128_HR_Suits_19200x880?%24large%24&fmt=webp&align=0,-1&fit=crop,1&ts=1739884344654&qlt=80&wid=1980&hei=907',
                'mobile_image' => 'https://images.hugoboss.com/is/image/hugobosscsprod/250128_HR_Suits_19200x880?%24large%24&fmt=webp&align=0,-1&fit=crop,1&ts=1739884344654&qlt=80&wid=1980&hei=907',
            ],
            [
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'desktop_image' => 'https://images.hugoboss.com/is/image/hugobosscsprod/Responsible_Generic_nature1_1920x880?%24large%24&cropN=0,0.1279863,0.9992188,0.7389078&align=0,-1&fit=crop,1&ts=1737018645081&qlt=80&wid=2048&hei=693',
                'mobile_image' => 'https://images.hugoboss.com/is/image/hugobosscsprod/Responsible_Generic_nature1_1920x880?%24large%24&cropN=0,0.1279863,0.9992188,0.7389078&align=0,-1&fit=crop,1&ts=1737018645081&qlt=80&wid=2048&hei=693',
            ],
        ];
        Slider::insert($sliders);
    }
}
