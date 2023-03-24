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

    public static int $gstPercentage = 5;
    public static float $qstPercentage = 9.975;

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
    }

    public function removeProduct($id)
    {
        $this->cartProducts()->where('id', $id)->delete();
    }

    public function incrementProduct($id)
    {
        $this->cartProducts()->where('id', $id)->increment('quantity');
    }

    public function decrementProduct($id)
    {
        $cartProduct = $this->cartProducts->where('id', $id)->first();
        if ($cartProduct->quantity > 1) {
            $this->cartProducts()->where('id', $id)->decrement('quantity');
        }
    }

    public function subtotal()
    {
        $subtotal = $this->cartProducts->sum(function ($cartProduct) {
            return $cartProduct->quantity * $cartProduct->price;
        });
        return $subtotal;
    }

    public function gst()
    {
        return $this->subtotal() * static::$gstPercentage / 100;
    }

    public function qst()
    {
        return $this->subtotal() * static::$qstPercentage / 100;
    }

    public function total()
    {
        return $this->subtotal() + $this->gst() + $this->qst();
    }
}
