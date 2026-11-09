<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'code',
        'discount',
        'expire_date',
        'user_id',
        "is_archive",
    ];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
