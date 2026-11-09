<?php

namespace Database\Seeders;

use App\Models\Fit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class FitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fits = [];

        $sampleFitting = ["Slim Fit", "Regular Fit", "Relaxed Fit"];

        for ($i = 1; $i <= 6; $i++) {
            foreach ($sampleFitting as $fit) {
                if( $i !== 3 || $i !== 4 ){
                    $fits[] = [
                        "name" => $fit,
                        "user_id" => 1,
                        "category_id" => $i,
                        "created_at" => now(),
                        "updated_at" => now(),
                        "is_archive" => null,
                    ];
                }
            }
        }

        Fit::insert($fits);
    }
}
