<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $reviewArray = [
            [
                "user_id" => 1,
                "product_id" => 1,
                "review" => "This Product is good",
                "rating" => 4,
                "is_show" => 1,
            ],
            [
                "user_id" => 1,
                "product_id" => 2,
                "review" => "This Product is bad",
                "rating" => 2,
                "is_show" => 0,
            ],
            [
                "user_id" => 2,
                "product_id" => 5,
                "review" => "This Product is best",
                "rating" => 5,
                "is_show" => 0,
            ],
            [
                "user_id" => 3,
                "product_id" => 5,
                "review" => "This Product is best",
                "rating" => 5,
                "is_show" => 0,
            ],
            [
                "user_id" => 2,
                "product_id" => 7,
                "review" => "This Product is average",
                "rating" => 3,
                "is_show" => 1,
            ],
            [
                "user_id" => 3,
                "product_id" => 10,
                "review" => "This Product is excellent",
                "rating" => 5,
                "is_show" => 1,
            ],
            [
                "user_id" => 1,
                "product_id" => 15,
                "review" => "This Product is disappointing",
                "rating" => 1,
                "is_show" => 0,
            ],
            [
                "user_id" => 2,
                "product_id" => 20,
                "review" => "This Product is worth the price",
                "rating" => 4,
                "is_show" => 1,
            ],
            [
                "user_id" => 3,
                "product_id" => 25,
                "review" => "This Product is overpriced",
                "rating" => 2,
                "is_show" => 0,
            ],
            [
                "user_id" => 1,
                "product_id" => 30,
                "review" => "This Product is amazing",
                "rating" => 5,
                "is_show" => 1,
            ],
            [
                "user_id" => 2,
                "product_id" => 35,
                "review" => "This Product is not worth it",
                "rating" => 2,
                "is_show" => 0,
            ],
            [
                "user_id" => 3,
                "product_id" => 40,
                "review" => "This Product is fantastic",
                "rating" => 5,
                "is_show" => 1,
            ],
            [
                "user_id" => 1,
                "product_id" => 3,
                "review" => "This Product is decent",
                "rating" => 3,
                "is_show" => 1,
            ],
            [
                "user_id" => 2,
                "product_id" => 8,
                "review" => "This Product is terrible",
                "rating" => 1,
                "is_show" => 0,
            ],
            [
                "user_id" => 3,
                "product_id" => 12,
                "review" => "This Product is awesome",
                "rating" => 5,
                "is_show" => 1,
            ],
            [
                "user_id" => 1,
                "product_id" => 18,
                "review" => "This Product is okay",
                "rating" => 3,
                "is_show" => 1,
            ],
            [
                "user_id" => 2,
                "product_id" => 22,
                "review" => "This Product is not good",
                "rating" => 2,
                "is_show" => 0,
            ],
            [
                "user_id" => 3,
                "product_id" => 28,
                "review" => "This Product is great",
                "rating" => 4,
                "is_show" => 1,
            ],
            [
                "user_id" => 1,
                "product_id" => 33,
                "review" => "This Product is poor",
                "rating" => 1,
                "is_show" => 0,
            ],
            [
                "user_id" => 2,
                "product_id" => 37,
                "review" => "This Product is satisfactory",
                "rating" => 3,
                "is_show" => 1,
            ],
            [
                "user_id" => 3,
                "product_id" => 42,
                "review" => "This Product is outstanding",
                "rating" => 5,
                "is_show" => 1,
            ],
            [
                "user_id" => 1,
                "product_id" => 4,
                "review" => "This Product is mediocre",
                "rating" => 2,
                "is_show" => 0,
            ],
            [
                "user_id" => 2,
                "product_id" => 9,
                "review" => "This Product is superb",
                "rating" => 5,
                "is_show" => 1,
            ],
            [
                "user_id" => 3,
                "product_id" => 14,
                "review" => "This Product is below average",
                "rating" => 2,
                "is_show" => 0,
            ],
            [
                "user_id" => 1,
                "product_id" => 19,
                "review" => "This Product is excellent value",
                "rating" => 4,
                "is_show" => 1,
            ],
            [
                "user_id" => 2,
                "product_id" => 24,
                "review" => "This Product is not recommended",
                "rating" => 1,
                "is_show" => 0,
            ],
            [
                "user_id" => 3,
                "product_id" => 29,
                "review" => "This Product is top-notch",
                "rating" => 5,
                "is_show" => 1,
            ],
            [
                "user_id" => 1,
                "product_id" => 34,
                "review" => "This Product is disappointing",
                "rating" => 1,
                "is_show" => 0,
            ],
            [
                "user_id" => 2,
                "product_id" => 38,
                "review" => "This Product is good for the price",
                "rating" => 3,
                "is_show" => 1,
            ],
            [
                "user_id" => 3,
                "product_id" => 41,
                "review" => "This Product is exceptional",
                "rating" => 5,
                "is_show" => 1,
            ],
            [
                "user_id" => 1,
                "product_id" => 6,
                "review" => "This Product is not bad",
                "rating" => 3,
                "is_show" => 1,
            ],
            [
                "user_id" => 2,
                "product_id" => 11,
                "review" => "This Product is disappointing",
                "rating" => 1,
                "is_show" => 0,
            ],
            [
                "user_id" => 3,
                "product_id" => 16,
                "review" => "This Product is amazing",
                "rating" => 5,
                "is_show" => 1,
            ],
            [
                "user_id" => 1,
                "product_id" => 21,
                "review" => "This Product is just okay",
                "rating" => 3,
                "is_show" => 1,
            ],
            [
                "user_id" => 2,
                "product_id" => 26,
                "review" => "This Product is not worth the money",
                "rating" => 2,
                "is_show" => 0,
            ],
            [
                "user_id" => 3,
                "product_id" => 31,
                "review" => "This Product is fantastic",
                "rating" => 5,
                "is_show" => 1,
            ],
        ];

        $reviews = array_map(fn($el) => [
            "user_id" => $el['user_id'],
            "product_id" => $el['product_id'],
            "review" => $el["review"],
            "rating" => $el["rating"],
            "is_show" => $el["is_show"],
            "created_at" => now(),
            "updated_at" => now()
        ], $reviewArray);

        Review::insert($reviews);
    }
}
