<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use Livewire\Component;

class Kart extends Component
{
    public ?Cart $cart = null;

    private int $numberOfProductsByDefault = 2;

    protected $listeners = ['cartInitialized' => '$refresh'];

    public function mount()
    {
        $this->cart = Cart::where('uuid', session('uuid'))->first();
    }

    public function loadCartIfNew()
    {
        if (is_null($this->cart)) {
            $this->initNewCart();
        }
    }

    public function initNewCart()
    {
        $cart = Cart::create([
            'uuid' => uniqid(),
        ]);
        session(['uuid' => $cart->uuid]);
        $cart->addRandomProducts($this->numberOfProductsByDefault);
        $cart->refresh();
        $this->cart = $cart;
    }

    public function render()
    {
        return view('livewire.kart');
    }
}
