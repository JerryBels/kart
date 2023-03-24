<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use App\Models\CartProduct;
use Exception;
use Livewire\Component;

class Kart extends Component
{
    public ?Cart $cart = null;
    public int $numberOfSurpriseProductsToAdd = 1;

    public static int $numberOfProductsByDefault = 3;

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
            $this->cart->refresh();
        }
    }

    public function addSurpriseProducts()
    {
        try {
            $this->cart->addRandomProducts($this->numberOfSurpriseProductsToAdd);
            $this->cart->refresh();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function removeProduct($id)
    {
        $this->cart->removeProduct($id);
        $this->cart->refresh();
    }

    public function incrementProduct($id)
    {
        $this->cart->incrementProduct($id);
        $this->cart->refresh();
    }

    public function decrementProduct($id)
    {
        $this->cart->decrementProduct($id);
        $this->cart->refresh();
    }

    public function render()
    {
        return view('livewire.kart');
    }
}
