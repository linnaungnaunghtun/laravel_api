<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    protected $fillable = [
        'product_name',
        'product_code',
        'slug',
        'description',
        'gender',
        'brand_id',
        'product_type_id',
        'category_id',
        'fit_id',
        'original_price',
        'display_price',
        'sale_price',
        'is_archive',
        "is_ecommerce",
        'discount',
        'user_id',
        "stocks_count",
    ];





    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }
    public function fit()
    {
        return $this->belongsTo(Fit::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function productImage()
    {
        return $this->hasOne(ProductImage::class)->latest("id");
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function sizes()
    {
        return $this->hasManyThrough(
            Size::class,
            Stock::class,
            'product_id', // Foreign key on the stocks table
            'id', // Foreign key on the sizes table
            'id', // Local key on the products table
            'size_id' // Local key on the stocks table
        );
    }
}
