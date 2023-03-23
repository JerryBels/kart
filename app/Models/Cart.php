<?php

namespace App\Models;

use App\Services\ProductService;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
    ];

    public function cartProducts(): HasMany
    {
        return $this->hasMany(CartProduct::class);
    }

    /**
     * @throws Exception
     */
    public function addRandomProducts(int $numberOfProducts): void
    {
        $cartProducts = [];
        for ($i = 0; $i < $numberOfProducts; $i++) {
            $product = ProductService::getRandomProduct($this->cartProducts->pluck('remote_product_id')->toArray());
            $cartProducts[] = [
                'product_title' => $product->title,
                'product_description' => $product->description,
                'product_image_url' => $product->thumbnail,
                'quantity' => 1,
                'price' => $product->price,
                'remote_product_id' => $product->id,
            ];
        }
        $this->cartProducts()->createMany($cartProducts);
        $this->refresh();
    }
}
