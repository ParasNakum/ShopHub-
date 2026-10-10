@extends('layouts.app')

@section('title', 'Your Shopping Cart - ShopHub')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-cart3 me-2 text-primary"></i>Shopping Cart</h3>

    @if($cartItems->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center my-4">
            <i class="bi bi-cart-x text-muted" style="font-size: 4rem;"></i>
            <h4 class="fw-bold mt-3">Your Cart is Currently Empty</h4>
            <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
            <div class="mt-2">
                <a href="{{ route('products.index') }}" class="btn btn-primary px-4 fw-semibold">
                    <i class="bi bi-bag-plus me-1"></i> Start Shopping
                </a>
            </div>
        </div>
    @else
        <div class="row g-4">
            <!-- Cart Items List -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <span class="fw-bold">{{ $cartItems->count() }} Item(s) in Cart</span>
                        <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear your cart?');">
                            @csrf
                            <button type="submit" class="btn btn-link text-danger text-decoration-none btn-sm p-0">
                                <i class="bi bi-trash3 me-1"></i> Clear Cart
                            </button>
                        </form>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" style="min-width: 250px;">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col" style="min-width: 140px;">Quantity</th>
                                        <th scope="col">Subtotal</th>
                                        <th scope="col" class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $item->product ? $item->product->image_url : '' }}" alt="" class="rounded border me-3" style="width: 60px; height: 60px; object-fit: cover;">
                                                    <div>
                                                        @if($item->product)
                                                            <a href="{{ route('products.show', $item->product->slug) }}" class="text-decoration-none text-dark fw-semibold d-block">
                                                                {{ $item->product->name }}
                                                            </a>
                                                            <small class="text-muted">Seller: {{ $item->product->seller ? $item->product->seller->name : 'Official Store' }}</small>
                                                        @else
                                                            <span class="text-danger">Product Unavailable</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="fw-semibold">
                                                ${{ number_format($item->product ? $item->product->price : 0, 2) }}
                                            </td>
                                            <td>
                                                @if($item->product)
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center">
                                                        @csrf
                                                        <div class="input-group input-group-sm" style="max-width: 110px;">
                                                            <input type="number" name="quantity" class="form-control text-center" value="{{ $item->quantity }}" min="1" max="{{ $item->product->stock }}" onchange="this.form.submit()">
                                                            <button class="btn btn-outline-secondary" type="submit" title="Update"><i class="bi bi-arrow-repeat"></i></button>
                                                        </div>
                                                    </form>
                                                @endif
                                            </td>
                                            <td class="fw-bold text-primary">
                                                ${{ number_format($item->subtotal, 2) }}
                                            </td>
                                            <td class="text-end">
                                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle" title="Remove Item">
                                                        <i class="bi bi-x-lg"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('products.index') }}" class="btn btn-link text-decoration-none ps-0">
                        <i class="bi bi-arrow-left me-1"></i> Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Order Summary Sidebar -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3">Order Summary</h5>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Estimated Tax (5%)</span>
                        <span class="fw-semibold">${{ number_format($tax, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping Fee</span>
                        @if($shipping == 0 && $subtotal > 0)
                            <span class="text-success fw-bold">FREE</span>
                        @else
                            <span class="fw-semibold">${{ number_format($shipping, 2) }}</span>
                        @endif
                    </div>

                    @if($subtotal < 100 && $subtotal > 0)
                        <div class="alert alert-info py-2 small my-2">
                            <i class="bi bi-info-circle me-1"></i> Add <strong>${{ number_format(100 - $subtotal, 2) }}</strong> more to get <strong>FREE SHIPPING</strong>!
                        </div>
                    @endif

                    <hr class="my-3">

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Estimated Total</span>
                        <span class="fw-bold fs-5 text-primary">${{ number_format($total, 2) }}</span>
                    </div>

                    <a href="{{ route('checkout') }}" class="btn btn-primary w-100 py-2 fw-semibold">
                        <i class="bi bi-credit-card me-1"></i> Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
