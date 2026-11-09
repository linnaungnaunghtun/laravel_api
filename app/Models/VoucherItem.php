<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherItem extends Model
{
    /** @use HasFactory<\Database\Factories\VoucherItemFactory> */
    use HasFactory;

    protected $fillable = [
        "voucher_id",
        "product_id",
        "product_name",
        "product_code",
        "barcode",
        "size_name",
        "size_id",
        "original_price",
        "display_price",
        "discount",
        "sale_price",
        "profit",
        "user_id",
        "voucher_id_code",
        "customer_name",
        "customer_phone",
        "customer_id",
        "sale_type",
        "brand_name",
        "brand_id",
        "category_name",
        "category_id",
        "fit_name",
        "fit_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
