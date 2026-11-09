<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;

    protected $fillable = [
        'address_detail',
        'city',
        'township',
        'phone',
        'note',
        'is_default',
        'user_id',
        'is_archive',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
