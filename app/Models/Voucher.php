<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    /** @use HasFactory<\Database\Factories\VoucherFactory> */
    protected $fillable = [
        "cash_discount",
        "customer_id",
        "discount_percent_amount",
        "discount_percentage",
        "net_total",
        "payment_method",
        "sale_type",
        "tax",
        "tax_amount",
        "total",
        "voucher_date",
        "voucher_no",
        "user_id",
        "net_profit"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function voucherItems()
    {
        return $this->hasMany(VoucherItem::class);
    }
}
