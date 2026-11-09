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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('address_id');
            $table->integer('item_count');
            $table->integer('total');
            $table->integer('net_total');
            $table->integer('level_discount_percentage')->default(0);
            $table->integer('level_discount_amount')->default(0);
            $table->integer('coupon_discount_amount')->default(0);
            $table->integer('coupon_discount_percentage')->default(0);
            $table->string('coupon_code')->nullable();
            $table->enum('status', config("base.order_status"))->default('pending');
            $table->boolean("is_cancel")->default(false);
            $table->string('cancel_message')->nullable();
            $table->integer('cancel_user_id')->nullable();
            $table->string("confirm_message")->nullable();
            $table->string("delivery_date_range")->nullable();
            $table->string("order_id")->nullable();
            $table->integer("voucher_id")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
