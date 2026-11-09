<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_image = [
            [
                "product_id"=> 1,
                "path_name"=> "https://upload.wikimedia.org/wikipedia/commons/thumb/f/f0/Reebok_Royal_Glide_Ripple_Clip_shoe.jpg/640px-Reebok_Royal_Glide_Ripple_Clip_shoe.jpg",
                "created_at"=> now(),
                "updated_at"=> now(),
            ],
            [
                "product_id"=> 1,
                "path_name"=> "https://upload.wikimedia.org/wikipedia/commons/thumb/d/da/2023_Nike_SB_Dunk_Low_Pro_%283%29.jpg/640px-2023_Nike_SB_Dunk_Low_Pro_%283%29.jpg",
                "created_at"=> now(),
                "updated_at"=> now(),
            ],
            [
                "product_id"=> 2,
                "path_name"=> "https://upload.wikimedia.org/wikipedia/commons/thumb/7/7a/OKM_Shirt_Back.png/640px-OKM_Shirt_Back.png",
                "created_at"=> now(),
                "updated_at"=> now(),
            ],
            [
                "product_id"=> 4,
                "path_name"=> "https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/I-CLIP_Slim_Wallet_02.jpg/640px-I-CLIP_Slim_Wallet_02.jpg",
                "created_at"=> now(),
                "updated_at"=> now(),
            ]


            ];
            ProductImage::insert($product_image);
    }
}
