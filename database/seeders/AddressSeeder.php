<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $address = [
            [
                "address_detail" => "No. 123, Coner of 32nd Street and 78th Street, 8mile, Mayangone Township, Yangon, Myanmar.",
                "city" => "Yangon",
                "township" => "Mayangone",
                "phone" => "0925000000",
                "note" => "Office Address",
                "is_default" => 1,
                "user_id" => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "address_detail" => "No. 456, 63rd Street, 37 Quarter, Mandalay, Myanmar.",
                "city" => "Mandalay",
                "township" => "Chan Aye Thar Zan",
                "phone" => "0940000000",
                "note" => "Home Address",
                "is_default" => 0,
                "user_id" => 3,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "address_detail" => "No. 789, University Avenue Road, Kamaryut Township, Yangon, Myanmar.",
                "city" => "Yangon",
                "township" => "Kamaryut",
                "phone" => "0955000000",
                "note" => "School Address",
                "is_default" => 0,
                "user_id" => 4,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "address_detail" => "No. 123, Coner of 32nd Street and 78th Street, 8mile, Mayangone Township, Yangon, Myanmar.",
                "city" => "Yangon",
                "township" => "Mayangone",
                "phone" => "0925000000",
                "note" => "Office Address",
                "is_default" => 1,
                "user_id" => 4,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "address_detail" => "No. 456, 63rd Street, 37 Quarter, Mandalay, Myanmar.",
                "city" => "Mandalay",
                "township" => "Chan Aye Thar Zan",
                "phone" => "0940000000",
                "note" => "Home Address",
                "is_default" => 0,
                "user_id" => 5,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "address_detail" => "No. 789, University Avenue Road, Kamaryut Township, Yangon, Myanmar.",
                "city" => "Yangon",
                "township" => "Kamaryut",
                "phone" => "0955000000",
                "note" => "School Address",
                "is_default" => 0,
                "user_id" => 6,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "address_detail" => "No. 456, 63rd Street, 37 Quarter, Mandalay, Myanmar.",
                "city" => "Mandalay",
                "township" => "Chan Aye Thar Zan",
                "phone" => "0940000000",
                "note" => "Home Address",
                "is_default" => 0,
                "user_id" => 7,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "address_detail" => "No. 789, University Avenue Road, Kamaryut Township, Yangon, Myanmar.",
                "city" => "Yangon",
                "township" => "Kamaryut",
                "phone" => "0955000000",
                "note" => "School Address",
                "is_default" => 0,
                "user_id" => 7,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "address_detail" => "No. 123, Coner of 32nd Street and 78th Street, 8mile, Mayangone Township, Yangon, Myanmar.",
                "city" => "Yangon",
                "township" => "Mayangone",
                "phone" => "0925000000",
                "note" => "Office Address",
                "is_default" => 1,
                "user_id" => 8,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "address_detail" => "No. 456, 63rd Street, 37 Quarter, Mandalay, Myanmar.",
                "city" => "Mandalay",
                "township" => "Chan Aye Thar Zan",
                "phone" => "0940000000",
                "note" => "Home Address",
                "is_default" => 0,
                "user_id" => 8,
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "address_detail" => "No. 789, University Avenue Road, Kamaryut Township, Yangon, Myanmar.",
                "city" => "Yangon",
                "township" => "Kamaryut",
                "phone" => "0955000000",
                "note" => "School Address",
                "is_default" => 0,
                "user_id" => 9,
                "created_at" => now(),
                "updated_at" => now(),
            ]
        ];

        Address::insert($address);
    }
}
