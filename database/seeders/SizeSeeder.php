<?php

namespace Database\Seeders;

use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{

    public function run(): void
    {


        $sizeStringArray = [
            "XS,S,M,L,XL,XXL,3XL",
            "XS,S,M,L,XL,XXL,3XL",
            "XS,S,M,L,XL,XXL,3XL",
            "XS,S,M,L,XL,XXL,3XL",
            "XS,S,M,L,XL,XXL,3XL",
            "XS,S,M,L,XL,XXL,3XL",
            "XS,S,M,L,XL,XXL,3XL",
            "Free Size",
            "One Size",
            "One Size",
            "80 Cm 30 Inch,85 Cm 32 Inch,90 Cm 34 Inch,95 Cm 36 Inch,100 Cm 38 Inch,105 Cm 40 Inch,110 Cm 42 Inch,106 Cm 40 Inch,102 Cm 38 Inch,Free Size",
            "One Size",
            "EU 35,EU 36,EU 37,EU 38,EU 39,EU 40,EU 41,EU 42,EU 43,EU 44,EU 45,EU 46,EU 47,EU 48",
            "EU 35,EU 36,EU 37,EU 38,EU 39,EU 40,EU 41,EU 42,EU 43,EU 44,EU 45,EU 46,EU 47,EU 48",
            "Free Size"
        ];

        $sizes = [];

        foreach ($sizeStringArray as $index => $sizesString) {

            $sizesStringToArray = explode(',', $sizesString);

            foreach ($sizesStringToArray as $size) {
                $sizes[] = [
                    "user_id" => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'size' => $size,
                    'category_id' => $index + 1,
                    'is_archive' => null,
                ];
            }
        }


        Size::insert($sizes);
    }
}
