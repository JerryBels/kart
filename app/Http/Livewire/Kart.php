<?php

namespace App\Http\Livewire;

use App\Models\Cart;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class Kart extends Component
{

    public function initNewCart()
    {
        $response = Http::post('https://dummyjson.com/test');

        $cart = Cart::create();
    }

    public function render()
    {
        return view('livewire.kart');
    }
}
