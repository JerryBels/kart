<div wire:init="loadCartIfNew">
    <h1>Hello FortNine!</h1>
    @empty($cart->cartProducts)
        <h4>CREATING YOUR SURPRISE!!</h4>
    @endempty
    @if($cart?->cartProducts)
        @json($cart->cartProducts)
    @endif
    <p>
        Give me
        <input type="number" wire:model="numberOfSurpriseProductsToAdd" min="1" max="10">
        surprise(s)!
        <button wire:click="addSurpriseProducts">Add a surprise Product</button>
    </p>
</div>
