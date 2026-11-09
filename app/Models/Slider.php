<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /** @use HasFactory<\Database\Factories\SliderFactory> */
    use HasFactory;

    protected $fillable = [
        "desktop_image","mobile_image","user_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
