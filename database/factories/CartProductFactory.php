<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CartProduct>
 */
class CartProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cart_id' => Cart::factory(),
            'product_title' => $this->faker->sentence(3),
            'product_description' => $this->faker->paragraph,
            'product_image_url' => $this->faker->imageUrl,
            'quantity' => 1,
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'remote_product_id' => $this->faker->randomNumber(3),
        ];
    }
}
