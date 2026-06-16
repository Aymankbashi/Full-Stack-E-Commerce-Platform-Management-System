<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'price', 'old_price', 'image', 'description', 'category', 'min_quantity', 'offer_end'
    ];
    
    protected $casts = [
        'offer_end' => 'datetime',
    ];

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }
}
