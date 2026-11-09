<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voucher_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id');
            $table->string("product_name");
            $table->string('product_code');
            $table->string('barcode')->index();
            $table->string('size_name');
            $table->foreignId('size_id');
            $table->integer('original_price');
            $table->integer('display_price');
            $table->integer('discount');
            $table->integer('sale_price');
            $table->integer('profit')->default(0);
            $table->foreignId('user_id');

            $table->string("voucher_id_code")->nullable();
            $table->string("customer_name")->nullable();
            $table->string("customer_phone")->nullable();
            $table->string("customer_id")->nullable();
            $table->string("sale_type")->nullable();
            $table->string("brand_name")->nullable();
            $table->string("brand_id")->nullable();
            $table->string("category_name")->nullable();
            $table->string("category_id")->nullable();
            $table->string("fit_name")->nullable();
            $table->string("fit_id")->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voucher_items');
    }
};
