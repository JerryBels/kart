<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use Livewire\Component;

class Kart extends Component
{
    public ?Cart $cart = null;
    public int $numberOfSurpriseProductsToAdd = 1;

    public static int $numberOfProductsByDefault = 2;

    public function mount()
    {
        $this->cart = Cart::where('uuid', session('uuid'))->first();
    }

    public function loadCartIfNew()
    {
        if (is_null($this->cart)) {
            $cart = Cart::create([
                'uuid' => uniqid(),
            ]);

            session(['uuid' => $cart->uuid]);
            $cart->addRandomProducts(static::$numberOfProductsByDefault);
            $this->cart = $cart;
        }
    }

    public function addSurpriseProducts()
    {
        $this->cart->addRandomProducts($this->numberOfSurpriseProductsToAdd);
    }

    public function render()
    {
        return view('livewire.kart');
    }
}
