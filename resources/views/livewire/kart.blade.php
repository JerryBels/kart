<div class="container" wire:init="loadCartIfNew">
    <div>
        @if (session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    </div>
    <div class="row mt-5">
        @if($cart?->cartProducts)
            <div class="col-md-8">
                <div class="row mb-2 align-items-center">
                    <h2 class="col col-auto text-black-50">Cart</h2>
                    <div class="col">
                        <div class="spinner-border text-primary" role="status" wire:loading>
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    <div class="col text-end">
                        <div class="d-inline-block border border-primary-subtle p-2 rounded-2">
                            <label for="numberOfSurpriseProductsToAdd">I want</label>
                            <input class="newSurprisesButton" type="number" wire:model="numberOfSurpriseProductsToAdd" id="numberOfSurpriseProductsToAdd" min="1" max="9">
                            more surprise(s)!
                            <button class="btn btn-primary" wire:click="addSurpriseProducts" data-bs-toggle="tooltip" data-bs-title="I'm feeling lucky!">Go!</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($cart->cartProducts as $index => $cartProduct)
                        <div class="col-md-4 pb-4">
                            <div class="card">
                                <div class="img-container" style="background-image: url('{{ $cartProduct->product_image_url }}')"></div>
                                <div class="card-body">
                                    <h5 class="card-title text-truncate" title="{{ $cartProduct->product_title }}">{{ $cartProduct->product_title }}</h5>
                                    <div class="text-truncate-container">
                                        <p class="card-text">
                                            {{ $cartProduct->product_description }}
                                        </p>
                                    </div>
                                    <div class="row pt-2">
                                        <div class="col">
                                            <i @if($cartProduct->quantity > 1) role="button" @endif class="bi bi-dash-circle" wire:click="decrementProduct({{ $cartProduct->id }})"></i>
                                            <span>{{ $cartProduct->quantity }}</span>
                                            <i role="button" class="bi bi-plus-circle" wire:click="incrementProduct({{ $cartProduct->id }})"></i>
                                        </div>
                                        <div class="col text-center">
                                            <span>${{ $cartProduct->price }}</span>
                                        </div>
                                        <div class="col text-end">
                                            <i role="button" class="bi bi-trash text-danger" wire:click="removeProduct({{ $cartProduct->id }})"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4">
                    <h6>Products summary</h6>
                    @foreach($cart->cartProducts as $cartProduct)
                        <div class="mt-2">
                            <strong class="small">{{ $cartProduct->product_title }}:</strong>
                            <div class="row">
                                <span class="col">{{ $cartProduct->quantity }} x ${{ $cartProduct->price }}</span>
                                <span class="col text-end">${{ number_format($cartProduct->price * $cartProduct->quantity, 2) }}</span>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-4 border-top pt-4">
                        <div class="row">
                            <strong class="col">Subtotal</strong>
                            <span class="col text-end">${{ number_format($cart->subtotal(), 2) }}</span>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="row">
                            <strong class="col">GST:</strong>
                            <span class="col text-end">${{ number_format($cart->gst(), 2) }}</span>
                        </div>
                    </div>
                    <div class="mt-2">
                        <div class="row">
                            <strong class="col">QST:</strong>
                            <span class="col text-end">${{ number_format($cart->qst(), 2) }}</span>
                        </div>
                    </div>
                    <div class="mt-4 border-top pt-4">
                        <h5>Total:</h5>
                        <div class="row">
                            <span class="col"></span>
                            <strong class="col text-end">${{ number_format($cart->total(), 2) }}</strong>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <a class="btn btn-success" href="https://fortnine.ca/en/">All good, let's go!</a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center">
                <h2>CREATING YOUR SURPRISE cart!</h2>
                <div class="spinner-grow text-success mt-5" role="status">
                    <span class="sr-only"></span>
                </div>
            </div>
        @endif
    </div>
</div>
