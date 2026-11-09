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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->default(1);
            $table->foreignId('product_id');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_slug');
            $table->string('product_image')->nullable();
            $table->integer('size_id');
            $table->string('size_name');
            $table->integer('stock_id')->nullable();
            $table->string('barcode')->nullable();
            $table->float('display_price')->default(0);
            $table->float('discount')->default(0);
            $table->float('sale_price')->default(0);
            $table->boolean('sold')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
