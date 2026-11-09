<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    /** @use HasFactory<\Database\Factories\LevelFactory> */
    use HasFactory;
    protected $fillable = ['level', 'discount', 'user_id', "is_archive"];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
