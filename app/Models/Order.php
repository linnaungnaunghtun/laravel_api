<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'item_count',
        'total',
        'net_total',
        'level_discount_percentage',
        'level_discount_amount',
        'coupon_discount_amount',
        'coupon_discount_percentage',
        'coupon_code',
        'status',
        'is_cancel',
        'cancel_message',
        'cancel_user_id',
        'confirm_message',
        'delivery_date_range',
        'order_id',
        'voucher_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, "coupon_code", "code");
    }
}
