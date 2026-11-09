<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        "name",
        "age",
        "email",
        "address",
        "phone",
        "gender",
        "remark",
        "age_range",
        "level_id",
        "user_id",
        "city",
        "township",
        "is_archive",
    ];


    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
