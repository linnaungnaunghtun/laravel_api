<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Size;
use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stocks = [
            ['id' => 1, 'product_id' => 17, 'shop_code' => 'CLO045', 'barcode' => 'BAR64A1C2', 'user_id' => 1, "is_sold" => null],
            ['id' => 2, 'product_id' => 5, 'shop_code' => 'CLO233', 'barcode' => 'BAR7F4B6D', 'user_id' => 1, "is_sold" => null],
            ['id' => 3, 'product_id' => 13, 'shop_code' => 'CLO077', 'barcode' => 'BAR6ABF02', 'user_id' => 1, "is_sold" => null],
            ['id' => 4, 'product_id' => 9, 'shop_code' => 'CLO118', 'barcode' => 'BAR3E9C8B', 'user_id' => 1, "is_sold" => null],
            ['id' => 5, 'product_id' => 1, 'shop_code' => 'CLO502', 'barcode' => 'BAR1A72D6', 'user_id' => 1, "is_sold" => null],
            ['id' => 6, 'product_id' => 20, 'shop_code' => 'CLO362', 'barcode' => 'BAR5C2B1F', 'user_id' => 1, "is_sold" => null],
            ['id' => 7, 'product_id' => 4, 'shop_code' => 'CLO098', 'barcode' => 'BAR86D342', 'user_id' => 1, "is_sold" => null],
            ['id' => 8, 'product_id' => 19, 'shop_code' => 'CLO210', 'barcode' => 'BAR4F321D', 'user_id' => 1, "is_sold" => null],
            ['id' => 9, 'product_id' => 12, 'shop_code' => 'CLO634', 'barcode' => 'BAR31C6A7', 'user_id' => 1, "is_sold" => null],
            ['id' => 10, 'product_id' => 6, 'shop_code' => 'CLO440', 'barcode' => 'BAR94C2A6', 'user_id' => 1, "is_sold" => null],
            ['id' => 11, 'product_id' => 15, 'shop_code' => 'CLO338', 'barcode' => 'BAR72D1F3', 'user_id' => 1, "is_sold" => null],
            ['id' => 12, 'product_id' => 3, 'shop_code' => 'CLO447', 'barcode' => 'BAR58B3E9', 'user_id' => 1, "is_sold" => null],
            ['id' => 13, 'product_id' => 18, 'shop_code' => 'CLO293', 'barcode' => 'BAR6C4F9A', 'user_id' => 1, "is_sold" => null],
            ['id' => 14, 'product_id' => 10, 'shop_code' => 'CLO527', 'barcode' => 'BAR8A342B', 'user_id' => 1, "is_sold" => null],
            ['id' => 15, 'product_id' => 7, 'shop_code' => 'CLO169', 'barcode' => 'BAR4D72C5', 'user_id' => 1, "is_sold" => null],
            ['id' => 16, 'product_id' => 2, 'shop_code' => 'CLO856', 'barcode' => 'BAR6F2C1B', 'user_id' => 1, "is_sold" => null],
            ['id' => 17, 'product_id' => 11, 'shop_code' => 'CLO920', 'barcode' => 'BAR4A6B2E', 'user_id' => 1, "is_sold" => null],
            ['id' => 18, 'product_id' => 8, 'shop_code' => 'CLO309', 'barcode' => 'BAR3E4F1C', 'user_id' => 1, "is_sold" => null],
            ['id' => 19, 'product_id' => 14, 'shop_code' => 'CLO772', 'barcode' => 'BAR7F8C3A', 'user_id' => 1, "is_sold" => null],
            ['id' => 20, 'product_id' => 16, 'shop_code' => 'CLO681', 'barcode' => 'BAR56D21F', 'user_id' => 1, "is_sold" => null],
            ['id' => 21, 'product_id' => 5, 'shop_code' => 'CLO144', 'barcode' => 'BAR8A3C9E', 'user_id' => 1, "is_sold" => null],
            ['id' => 22, 'product_id' => 20, 'shop_code' => 'CLO442', 'barcode' => 'BAR3D572F1', 'user_id' => 1, "is_sold" => null],
            ['id' => 23, 'product_id' => 13, 'shop_code' => 'CLO295', 'barcode' => 'BAR6F39C3E', 'user_id' => 1, "is_sold" => null],
            ['id' => 24, 'product_id' => 9, 'shop_code' => 'CLO775', 'barcode' => 'BAR48C82F7', 'user_id' => 1, "is_sold" => null],
            ['id' => 25, 'product_id' => 1, 'shop_code' => 'CLO620', 'barcode' => 'BAR4D07A36', 'user_id' => 1, "is_sold" => null],
            ['id' => 26, 'product_id' => 17, 'shop_code' => 'CLO851', 'barcode' => 'BAR62B64F8', 'user_id' => 1, "is_sold" => null],
            ['id' => 27, 'product_id' => 4, 'shop_code' => 'CLO920', 'barcode' => 'BAR8C79D5B', 'user_id' => 1, "is_sold" => null],
            ['id' => 28, 'product_id' => 6, 'shop_code' => 'CLO523', 'barcode' => 'BAR7A54C1E', 'user_id' => 1, "is_sold" => null],
            ['id' => 29, 'product_id' => 12, 'shop_code' => 'CLO437', 'barcode' => 'BAR792F7B3', 'user_id' => 1, "is_sold" => null],
            ['id' => 30, 'product_id' => 18, 'shop_code' => 'CLO982', 'barcode' => 'BAR48F3D8E', 'user_id' => 1, "is_sold" => null],
            ['id' => 31, 'product_id' => 5, 'shop_code' => 'CLO982', 'barcode' => 'BAR45F3D8E', 'user_id' => 1, "is_sold" => null],
            ['id' => 32, 'product_id' => 6, 'shop_code' => 'CLO982', 'barcode' => 'BAR4F93D8E', 'user_id' => 1, "is_sold" => null],
            ['id' => 33, 'product_id' => 20, 'shop_code' => 'CLO442', 'barcode' => 'BAR3D72F1', 'user_id' => 1, "is_sold" => null],
            ['id' => 34, 'product_id' => 13, 'shop_code' => 'CLO295', 'barcode' => 'BAR6F9C3E', 'user_id' => 1, "is_sold" => null],
            ['id' => 35, 'product_id' => 9, 'shop_code' => 'CLO775', 'barcode' => 'BAR48C2F7', 'user_id' => 1, "is_sold" => null],
            ['id' => 36, 'product_id' => 1, 'shop_code' => 'CLO620', 'barcode' => 'BAR4D7A36', 'user_id' => 1, "is_sold" => null],
            ['id' => 37, 'product_id' => 17, 'shop_code' => 'CLO851', 'barcode' => 'BAR629B4F8', 'user_id' => 1, "is_sold" => null],
            ['id' => 38, 'product_id' => 4, 'shop_code' => 'CLO920', 'barcode' => 'BA2R8C7D5B', 'user_id' => 1, "is_sold" => null],
            ['id' => 39, 'product_id' => 6, 'shop_code' => 'CLO523', 'barcode' => 'BAR7A46C1E', 'user_id' => 1, "is_sold" => null],
            ['id' => 40, 'product_id' => 12, 'shop_code' => 'CLO437', 'barcode' => 'BAR992F7B3', 'user_id' => 1, "is_sold" => null],
            ['id' => 41, 'product_id' => 18, 'shop_code' => 'CLO982', 'barcode' => 'BAR4F83D8E', 'user_id' => 1, "is_sold" => null],
            ['id' => 42, 'product_id' => 5, 'shop_code' => 'CLO982', 'barcode' => 'BAR44F3D8E', 'user_id' => 1, "is_sold" => null],
            ['id' => 43, 'product_id' => 6, 'shop_code' => 'CLO982', 'barcode' => 'BAR49F3D8E', 'user_id' => 1, "is_sold" => null],
            ['id' => 44, 'product_id' => 17, 'shop_code' => 'CLO851', 'barcode' => 'BAR62B4F8', 'user_id' => 1, "is_sold" => null],
            ['id' => 45, 'product_id' => 4, 'shop_code' => 'CLO920', 'barcode' => 'BAR8C7D5B', 'user_id' => 1, "is_sold" => null],
            ['id' => 46, 'product_id' => 6, 'shop_code' => 'CLO523', 'barcode' => 'BAR7A4C1E', 'user_id' => 1, "is_sold" => null],
            ['id' => 47, 'product_id' => 12, 'shop_code' => 'CLO437', 'barcode' => 'BAR92F7B3', 'user_id' => 1, "is_sold" => null],
            ['id' => 48, 'product_id' => 18, 'shop_code' => 'CLO982', 'barcode' => 'BAR4F3D8E', 'user_id' => 1, "is_sold" => null],
            ['id' => 49, 'product_id' => 5, 'shop_code' => 'CLO982', 'barcode' => 'BAR4F3D08E', 'user_id' => 1, "is_sold" => null],
            ['id' => 50, 'product_id' => 6, 'shop_code' => 'CLO982', 'barcode' => 'BAR45F3D8E', 'user_id' => 1, "is_sold" => null],
            ['id' => 51, 'product_id' => 1, 'shop_code' => 'CLO983', 'barcode' => 'BAR45F3D8F', 'user_id' => 1, 'is_sold' => null],
            ['id' => 52, 'product_id' => 2, 'shop_code' => 'CLO984', 'barcode' => 'BAR45F3D90', 'user_id' => 1, 'is_sold' => null],
            ['id' => 53, 'product_id' => 3, 'shop_code' => 'CLO985', 'barcode' => 'BAR45F3D91', 'user_id' => 1, 'is_sold' => null],
            ['id' => 54, 'product_id' => 4, 'shop_code' => 'CLO986', 'barcode' => 'BAR45F3D92', 'user_id' => 1, 'is_sold' => null],
            ['id' => 55, 'product_id' => 5, 'shop_code' => 'CLO987', 'barcode' => 'BAR45F3D93', 'user_id' => 1, 'is_sold' => null],
            ['id' => 56, 'product_id' => 6, 'shop_code' => 'CLO988', 'barcode' => 'BAR45F3D94', 'user_id' => 1, 'is_sold' => null],
            ['id' => 57, 'product_id' => 7, 'shop_code' => 'CLO989', 'barcode' => 'BAR45F3D95', 'user_id' => 1, 'is_sold' => null],
            ['id' => 58, 'product_id' => 8, 'shop_code' => 'CLO990', 'barcode' => 'BAR45F3D96', 'user_id' => 1, 'is_sold' => null],
            ['id' => 59, 'product_id' => 9, 'shop_code' => 'CLO991', 'barcode' => 'BAR45F3D97', 'user_id' => 1, 'is_sold' => null],
            ['id' => 60, 'product_id' => 10, 'shop_code' => 'CLO992', 'barcode' => 'BAR45F3D98', 'user_id' => 1, 'is_sold' => null],
            ['id' => 61, 'product_id' => 11, 'shop_code' => 'CLO993', 'barcode' => 'BAR45F3D99', 'user_id' => 1, 'is_sold' => null],
            ['id' => 62, 'product_id' => 12, 'shop_code' => 'CLO994', 'barcode' => 'BAR45F3D9A', 'user_id' => 1, 'is_sold' => null],
            ['id' => 63, 'product_id' => 13, 'shop_code' => 'CLO995', 'barcode' => 'BAR45F3D9B', 'user_id' => 1, 'is_sold' => null],
            ['id' => 64, 'product_id' => 14, 'shop_code' => 'CLO996', 'barcode' => 'BAR45F3D9C', 'user_id' => 1, 'is_sold' => null],
            ['id' => 65, 'product_id' => 15, 'shop_code' => 'CLO997', 'barcode' => 'BAR45F3D9D', 'user_id' => 1, 'is_sold' => null],
            ['id' => 66, 'product_id' => 16, 'shop_code' => 'CLO998', 'barcode' => 'BAR45F3D9E', 'user_id' => 1, 'is_sold' => null],
            ['id' => 67, 'product_id' => 17, 'shop_code' => 'CLO999', 'barcode' => 'BAR45F3D9F', 'user_id' => 1, 'is_sold' => null],
            ['id' => 68, 'product_id' => 18, 'shop_code' => 'CLO1000', 'barcode' => 'BAR45F3DA0', 'user_id' => 1, 'is_sold' => null],
            ['id' => 69, 'product_id' => 19, 'shop_code' => 'CLO1001', 'barcode' => 'BAR45F3DA1', 'user_id' => 1, 'is_sold' => null],
            ['id' => 70, 'product_id' => 20, 'shop_code' => 'CLO1002', 'barcode' => 'BAR45F3DA2', 'user_id' => 1, 'is_sold' => null],
            ['id' => 71, 'product_id' => 21, 'shop_code' => 'CLO1003', 'barcode' => 'BAR45F3DA3', 'user_id' => 1, 'is_sold' => null],
            ['id' => 72, 'product_id' => 22, 'shop_code' => 'CLO1004', 'barcode' => 'BAR45F3DA4', 'user_id' => 1, 'is_sold' => null],
            ['id' => 73, 'product_id' => 23, 'shop_code' => 'CLO1005', 'barcode' => 'BAR45F3DA5', 'user_id' => 1, 'is_sold' => null],
            ['id' => 74, 'product_id' => 24, 'shop_code' => 'CLO1006', 'barcode' => 'BAR45F3DA6', 'user_id' => 1, 'is_sold' => null],
            ['id' => 75, 'product_id' => 25, 'shop_code' => 'CLO1007', 'barcode' => 'BAR45F3DA7', 'user_id' => 1, 'is_sold' => null],
            ['id' => 76, 'product_id' => 26, 'shop_code' => 'CLO1008', 'barcode' => 'BAR45F3DA8', 'user_id' => 1, 'is_sold' => null],
            ['id' => 77, 'product_id' => 27, 'shop_code' => 'CLO1009', 'barcode' => 'BAR45F3DA9', 'user_id' => 1, 'is_sold' => null],
            ['id' => 78, 'product_id' => 28, 'shop_code' => 'CLO1010', 'barcode' => 'BAR45F3DAA', 'user_id' => 1, 'is_sold' => null],
            ['id' => 79, 'product_id' => 29, 'shop_code' => 'CLO1011', 'barcode' => 'BAR45F3DAB', 'user_id' => 1, 'is_sold' => null],
            ['id' => 80, 'product_id' => 30, 'shop_code' => 'CLO1012', 'barcode' => 'BAR45F3DAC', 'user_id' => 1, 'is_sold' => null],
            ['id' => 81, 'product_id' => 1, 'shop_code' => 'CLO1013', 'barcode' => 'BAR45F3DAD', 'user_id' => 1, 'is_sold' => null],
            ['id' => 82, 'product_id' => 22, 'shop_code' => 'CLO1014', 'barcode' => 'BAR45F3DAE', 'user_id' => 1, 'is_sold' => null],
            ['id' => 83, 'product_id' => 23, 'shop_code' => 'CLO1015', 'barcode' => 'BAR45F3DAF', 'user_id' => 1, 'is_sold' => null],
            ['id' => 84, 'product_id' => 24, 'shop_code' => 'CLO1016', 'barcode' => 'BAR45F3DAG', 'user_id' => 1, 'is_sold' => null],
            ['id' => 85, 'product_id' => 25, 'shop_code' => 'CLO1017', 'barcode' => 'BAR45F3DAH', 'user_id' => 1, 'is_sold' => null],
            ['id' => 86, 'product_id' => 26, 'shop_code' => 'CLO1018', 'barcode' => 'BAR45F3DAI', 'user_id' => 1, 'is_sold' => null],
            ['id' => 87, 'product_id' => 27, 'shop_code' => 'CLO1019', 'barcode' => 'BAR45F3DAJ', 'user_id' => 1, 'is_sold' => null],
            ['id' => 88, 'product_id' => 28, 'shop_code' => 'CLO1020', 'barcode' => 'BAR45F3DAK', 'user_id' => 1, 'is_sold' => null],
            ['id' => 89, 'product_id' => 29, 'shop_code' => 'CLO1021', 'barcode' => 'BAR45F3DAL', 'user_id' => 1, 'is_sold' => null],
            ['id' => 90, 'product_id' => 30, 'shop_code' => 'CLO1022', 'barcode' => 'BAR45F3DAM', 'user_id' => 1, 'is_sold' => null],
            ['id' => 91, 'product_id' => 30, 'shop_code' => 'CLO1023', 'barcode' => 'BAR45F3DAN', 'user_id' => 1, 'is_sold' => null],
            ['id' => 92, 'product_id' => 31, 'shop_code' => 'CLO1024', 'barcode' => 'BAR45F3DAO', 'user_id' => 1, 'is_sold' => null],
            ['id' => 93, 'product_id' => 31, 'shop_code' => 'CLO1025', 'barcode' => 'BAR45F3DAP', 'user_id' => 1, 'is_sold' => null],
            ['id' => 94, 'product_id' => 32, 'shop_code' => 'CLO1026', 'barcode' => 'BAR45F3DAQ', 'user_id' => 1, 'is_sold' => null],
            ['id' => 95, 'product_id' => 32, 'shop_code' => 'CLO1027', 'barcode' => 'BAR45F3DAR', 'user_id' => 1, 'is_sold' => null],
            ['id' => 96, 'product_id' => 33, 'shop_code' => 'CLO1028', 'barcode' => 'BAR45F3DAS', 'user_id' => 1, 'is_sold' => null],
            ['id' => 97, 'product_id' => 33, 'shop_code' => 'CLO1029', 'barcode' => 'BAR45F3DAT', 'user_id' => 1, 'is_sold' => null],
            ['id' => 98, 'product_id' => 34, 'shop_code' => 'CLO1030', 'barcode' => 'BAR45F3DAU', 'user_id' => 1, 'is_sold' => null],
            ['id' => 99, 'product_id' => 34, 'shop_code' => 'CLO1031', 'barcode' => 'BAR45F3DAV', 'user_id' => 1, 'is_sold' => null],
            ['id' => 100, 'product_id' => 35, 'shop_code' => 'CLO1032', 'barcode' => 'BAR45F3DAW', 'user_id' => 1, 'is_sold' => null],
            ['id' => 101, 'product_id' => 35, 'shop_code' => 'CLO1033', 'barcode' => 'BAR45F3DAX', 'user_id' => 1, 'is_sold' => null],
            ['id' => 102, 'product_id' => 36, 'shop_code' => 'CLO1034', 'barcode' => 'BAR45F3DAY', 'user_id' => 1, 'is_sold' => null],
            ['id' => 103, 'product_id' => 36, 'shop_code' => 'CLO1035', 'barcode' => 'BAR45F3DAZ', 'user_id' => 1, 'is_sold' => null],
            ['id' => 104, 'product_id' => 37, 'shop_code' => 'CLO1036', 'barcode' => 'BAR45F3DB1', 'user_id' => 1, 'is_sold' => null],
            ['id' => 105, 'product_id' => 37, 'shop_code' => 'CLO1037', 'barcode' => 'BAR45F3DB2', 'user_id' => 1, 'is_sold' => null],
            ['id' => 106, 'product_id' => 38, 'shop_code' => 'CLO1038', 'barcode' => 'BAR45F3DB3', 'user_id' => 1, 'is_sold' => null],
            ['id' => 107, 'product_id' => 38, 'shop_code' => 'CLO1039', 'barcode' => 'BAR45F3DB4', 'user_id' => 1, 'is_sold' => null],
            ['id' => 108, 'product_id' => 39, 'shop_code' => 'CLO1040', 'barcode' => 'BAR45F3DB5', 'user_id' => 1, 'is_sold' => null],
            ['id' => 109, 'product_id' => 39, 'shop_code' => 'CLO1041', 'barcode' => 'BAR45F3DB6', 'user_id' => 1, 'is_sold' => null],
            ['id' => 110, 'product_id' => 40, 'shop_code' => 'CLO1042', 'barcode' => 'BAR45F3DB7', 'user_id' => 1, 'is_sold' => null],
            ['id' => 111, 'product_id' => 40, 'shop_code' => 'CLO1043', 'barcode' => 'BAR45F3DB8', 'user_id' => 1, 'is_sold' => null],
            ['id' => 112, 'product_id' => 41, 'shop_code' => 'CLO1044', 'barcode' => 'BAR45F3DB9', 'user_id' => 1, 'is_sold' => null],
            ['id' => 113, 'product_id' => 41, 'shop_code' => 'CLO1045', 'barcode' => 'BAR45F3DBA', 'user_id' => 1, 'is_sold' => null],
            ['id' => 114, 'product_id' => 42, 'shop_code' => 'CLO1046', 'barcode' => 'BAR45F3DBB', 'user_id' => 1, 'is_sold' => null],
            ['id' => 115, 'product_id' => 42, 'shop_code' => 'CLO1047', 'barcode' => 'BAR45F3DBC', 'user_id' => 1, 'is_sold' => null],
            ['id' => 116, 'product_id' => 30, 'shop_code' => 'CLO1048', 'barcode' => 'BAR45F3DBD', 'user_id' => 1, 'is_sold' => null],
            ['id' => 117, 'product_id' => 31, 'shop_code' => 'CLO1049', 'barcode' => 'BAR45F3DBE', 'user_id' => 1, 'is_sold' => null],
            ['id' => 118, 'product_id' => 32, 'shop_code' => 'CLO1050', 'barcode' => 'BAR45F3DBF', 'user_id' => 1, 'is_sold' => null],
            ['id' => 119, 'product_id' => 33, 'shop_code' => 'CLO1051', 'barcode' => 'BAR45F3DBG', 'user_id' => 1, 'is_sold' => null],
        ];

        $seedStock = [];

        foreach ($stocks as $stock) {

            $currentProductId = $stock['product_id'];
            $currentProductCategoryId = Product::find($currentProductId)->category_id;
            $currentSizeId = Size::where("category_id", $currentProductCategoryId)->get()->random()->id;

            $seedStock[] = [
                'id' => $stock["id"],
                'product_id' => $currentProductId,
                'shop_code' => $stock['shop_code'],
                'barcode' => $stock['barcode'],
                'size_id' => $currentSizeId,
                'user_id' => 1,
                "is_sold" => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Stock::insert($seedStock);


        $products = Product::withCount(['stocks as sc'])->get();

        foreach ($products as $product) {
            $product->update(["stocks_count" => $product->sc]);
        }
    }
}
