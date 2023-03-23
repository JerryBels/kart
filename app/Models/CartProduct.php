<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_title',
        'product_description',
        'product_image_url',
        'quantity',
        'price',
        'remote_product_id',
    ];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
