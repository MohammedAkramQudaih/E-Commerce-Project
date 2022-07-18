<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public function Reviews()
    {
        return $this->hasMany(Review::class);
    }
}
