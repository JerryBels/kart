<?php

namespace Tests\Feature\Models;

use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function testAddRandomProducts()
    {
        // API call are faked in CreatesApplication.php
        $cart = Cart::factory()->create();
        $cart->addRandomProducts(2);
        $this->assertDatabaseCount('cart_products', 2);
    }

    public function testRemoveProduct()
    {
        $cart = Cart::factory()->create();
        $cartProduct = CartProduct::factory(['cart_id' => $cart->id])->create();
        $cart->removeProduct($cartProduct->id);

        $this->assertDatabaseCount('cart_products', 0);
    }

    public function testIncrementProduct()
    {
        $cart = Cart::factory()->create();
        $cartProduct = CartProduct::factory(['cart_id' => $cart->id, 'quantity' => 2])->create();
        $cart->incrementProduct($cartProduct->id);

        $this->assertSame(3, $cart->cartProducts->where('id', 1)->first()->quantity);
    }

    public function testDecrementProduct()
    {
        $cart = Cart::factory()->create();
        $cartProduct = CartProduct::factory(['cart_id' => $cart->id, 'quantity' => 2])->create();
        $cart->decrementProduct($cartProduct->id);
        $cart->refresh();

        $this->assertSame(1, $cart->cartProducts->where('id', 1)->first()->quantity);
    }

    public function testDecrementProductWithZeroQuantity()
    {
        $cart = Cart::factory()->create();
        $cartProduct = CartProduct::factory(['cart_id' => $cart->id, 'quantity' => 2])->create();
        $cart->decrementProduct($cartProduct->id);
        $cart->refresh();

        $this->assertSame(1, $cart->cartProducts->where('id', 1)->first()->quantity);
    }

    public function testSubtotal()
    {
        $cart = Cart::factory()->create();
        CartProduct::factory(['cart_id' => $cart->id, 'price' => 10])->create();
        CartProduct::factory(['cart_id' => $cart->id, 'price' => 20])->create();

        $this->assertEquals(30, $cart->subtotal());
    }

    public function testGst()
    {
        $cart = Cart::factory()->create();
        CartProduct::factory(['cart_id' => $cart->id, 'price' => 40])->create();
        CartProduct::factory(['cart_id' => $cart->id, 'price' => 60])->create();

        $this->assertEquals(Cart::$gstPercentage, $cart->gst());
    }

    public function testQst()
    {
        $cart = Cart::factory()->create();
        CartProduct::factory(['cart_id' => $cart->id, 'price' => 40])->create();
        CartProduct::factory(['cart_id' => $cart->id, 'price' => 60])->create();

        $this->assertEquals(Cart::$qstPercentage, $cart->qst());
    }

    public function testTotal()
    {
        $cart = Cart::factory()->create();
        CartProduct::factory(['cart_id' => $cart->id, 'price' => 40])->create();
        CartProduct::factory(['cart_id' => $cart->id, 'price' => 60])->create();

        $this->assertEquals(100 + Cart::$gstPercentage + Cart::$qstPercentage, $cart->total());
    }
}
