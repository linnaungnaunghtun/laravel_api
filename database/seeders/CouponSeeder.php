<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupon = [
            [
                "title" => "New Year Sale",
                "code" => "NY2025SAVE", // Updated code
                "discount" => 20,
                "expire_date" => "2025-01-31", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Valentine's Discount",
                "code" => "LOVE2025", // Updated code
                "discount" => 25,
                "expire_date" => "2025-02-14", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Spring Savings",
                "code" => "SPRING2025", // Updated code
                "discount" => 15,
                "expire_date" => "2025-04-30", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Summer Special",
                "code" => "SUMMER2025", // Updated code
                "discount" => 30,
                "expire_date" => "2025-06-30", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Back to School",
                "code" => "SCHOOL2025", // Updated code
                "discount" => 10,
                "expire_date" => "2025-08-31", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Halloween Treat",
                "code" => "SPOOKY2025", // Updated code
                "discount" => 40,
                "expire_date" => "2025-10-31", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Black Friday Deal",
                "code" => "BLACKFRIDAY2025", // Updated code
                "discount" => 50,
                "expire_date" => "2025-11-28", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Cyber Monday Offer",
                "code" => "CYBER2025", // Updated code
                "discount" => 45,
                "expire_date" => "2025-12-01", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Christmas Special",
                "code" => "XMAS2025", // Updated code
                "discount" => 35,
                "expire_date" => "2025-12-25", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "End of Year Sale",
                "code" => "YEAREND2025", // Updated code
                "discount" => 50,
                "expire_date" => "2025-12-31", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Weekend Offer",
                "code" => "WEEKEND2025", // Updated code
                "discount" => 12,
                "expire_date" => "2025-03-01", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Festival Bonanza",
                "code" => "FESTIVAL2025", // Updated code
                "discount" => 28,
                "expire_date" => "2025-05-15", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Shopping Spree",
                "code" => "SHOP2025", // Updated code
                "discount" => 18,
                "expire_date" => "2025-07-01", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Holiday Sale",
                "code" => "HOLIDAY2025", // Updated code
                "discount" => 22,
                "expire_date" => "2025-09-15", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ],
            [
                "title" => "Early Bird Offer",
                "code" => "EARLY2025", // Updated code
                "discount" => 35,
                "expire_date" => "2025-10-10", // Updated date
                "user_id" => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'is_archive' => null,
            ]
        ];

        Coupon::insert($coupon);
    }
}
