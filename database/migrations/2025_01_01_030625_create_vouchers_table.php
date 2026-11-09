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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('voucher_no')->unique();
            $table->date('voucher_date');
            $table->foreignId('customer_id');
            $table->enum('sale_type', config('base.sale_types'));
            $table->enum('payment_method', config('base.payment_methods'));
            $table->integer('total');
            $table->integer('discount_percentage')->default(0);
            $table->integer('discount_percent_amount')->default(0);
            $table->integer('cash_discount')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('tax_amount')->default(0);
            $table->integer('net_total');
            $table->integer('net_profit')->default(0);
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
