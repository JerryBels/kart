<div wire:init="loadCartIfNew">
    <h1>Hello FortNine!</h1>
    @empty($cart->cartProducts)
        <h4>CREATING YOUR SURPRISE!!</h4>
    @endempty
    @if($cart?->cartProducts)
        @json($cart->cartProducts)
    @endif
</div>
