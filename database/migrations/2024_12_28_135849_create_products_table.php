<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('slug')->unique();
            $table->string('product_code')->nullable();
            $table->text('description');
            $table->enum('gender', ['men', 'women', 'unisex']);
            $table->foreignId('brand_id');
            $table->foreignId('product_type_id');
            $table->foreignId('category_id');
            $table->foreignId('fit_id')->nullable();
            $table->float('original_price')->default(0);
            $table->float('display_price')->default(0);
            $table->float('discount')->default(0);
            $table->float('sale_price')->default(0);
            $table->timestamp('is_archive')->nullable();
            $table->boolean("is_ecommerce")->default(1);
            $table->foreignId('user_id');
            $table->integer("stocks_count")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
