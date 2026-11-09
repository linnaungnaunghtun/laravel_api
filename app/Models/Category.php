<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $fillable = ['category_name', 'slug', "user_id", "product_type_id", "is_archive"];


    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }

    public function sizes()
    {
        return $this->hasMany(Size::class);
    }

    public function fits()
    {
        return $this->hasMany(Fit::class);
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
