<?php

namespace Tests\Feature\Models;

use App\Models\Cart;
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
}
