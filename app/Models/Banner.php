<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    /** @use HasFactory<\Database\Factories\BannerFactory> */
    use HasFactory;
    protected $fillable = ['desktop_ads', 'mobile_ads', 'type', "button_text", "link", "user_id"];

    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
