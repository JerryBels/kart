<?php

namespace Tests\Feature;

use App\Http\Livewire\Kart;
use App\Models\Cart;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class KartTest extends TestCase
{
    use LazilyRefreshDatabase;

    function testTheComponentCanRender()
    {
        $component = Livewire::test(Kart::class);
        $component->assertStatus(200);
    }

    function testRootPageContainsLivewireComponent()
    {
        $this->get('/')->assertSeeLivewire(Kart::class);
    }

    public function testUserHavingKartGetsItWhenVisiting()
    {
        $cart = Cart::factory()->create();
        $this->session(['uuid' => $cart->uuid]);

        Livewire::test(Kart::class)
            ->assertSet('cart.id', $cart->id);
    }

    public function testNewUserHaveAKartCreated()
    {
        $response = Livewire::test(Kart::class)
            ->call('loadCartIfNew');

        $cart = Cart::first();
        $response->assertSet('cart.id', $cart->id)
            ->assertSessionHas('uuid', $cart->uuid);

        $this->assertDatabaseCount('cart_products', Kart::$numberOfProductsByDefault);
    }

    public function testUserCanAddAProducts()
    {
        $cart = Cart::factory()->create();
        $this->session(['uuid' => $cart->uuid]);

        $response = Livewire::test(Kart::class)
            ->set('numberOfSurpriseProductsToAdd', 3)
            ->call('addSurpriseProducts');

        $this->assertDatabaseCount('cart_products', 3);
    }
}
