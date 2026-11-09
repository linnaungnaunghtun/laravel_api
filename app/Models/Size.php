<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    /** @use HasFactory<\Database\Factories\SizeFactory> */
    use HasFactory;
    protected $fillable = ['size', "user_id", "category_id", "is_archive"];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
