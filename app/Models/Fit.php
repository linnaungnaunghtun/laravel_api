<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fit extends Model
{
    /** @use HasFactory<\Database\Factories\FitFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'category_id',
        "is_archive",
    ];


    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
