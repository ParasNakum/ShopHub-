@extends('layouts.app')

@section('title', 'Secure Checkout - ShopHub')

@section('content')
<div class="container py-4">
    <h3 class="fw-bold mb-4"><i class="bi bi-shield-lock-fill me-2 text-primary"></i>Checkout</h3>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Shipping Information & Payment -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt me-2 text-primary"></i>Shipping Details</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="shipping_name" class="form-label small fw-bold">Full Name</label>
                            <input type="text" name="shipping_name" id="shipping_name" class="form-control" value="{{ old('shipping_name', $user->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="shipping_phone" class="form-label small fw-bold">Phone Number</label>
                            <input type="text" name="shipping_phone" id="shipping_phone" class="form-control" value="{{ old('shipping_phone', $user->phone) }}" required placeholder="+91 98765 43210">
                        </div>

                        <div class="col-12">
                            <label for="shipping_email" class="form-label small fw-bold">Email Address</label>
                            <input type="email" name="shipping_email" id="shipping_email" class="form-control" value="{{ old('shipping_email', $user->email) }}" required>
                        </div>

                        <div class="col-12">
                            <label for="shipping_address" class="form-label small fw-bold">Street Address</label>
                            <textarea name="shipping_address" id="shipping_address" class="form-control" rows="2" required placeholder="House/Flat number, building name, street">{{ old('shipping_address', $user->address) }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="shipping_city" class="form-label small fw-bold">City</label>
                            <input type="text" name="shipping_city" id="shipping_city" class="form-control" value="{{ old('shipping_city', 'Ahmedabad') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="shipping_postal_code" class="form-label small fw-bold">Postal / PIN Code</label>
                            <input type="text" name="shipping_postal_code" id="shipping_postal_code" class="form-control" value="{{ old('shipping_postal_code', '380001') }}" required>
                        </div>

                        <div class="col-12">
                            <label for="order_notes" class="form-label small fw-bold">Order Notes <span class="text-muted fw-normal">(Optional)</span></label>
                            <textarea name="order_notes" id="order_notes" class="form-control" rows="2" placeholder="Special delivery instructions or landmark">{{ old('order_notes') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3"><i class="bi bi-wallet2 me-2 text-primary"></i>Payment Method</h5>

                    <div class="d-flex flex-column gap-3">
                        <div class="form-check p-3 border rounded-3">
                            <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="pay_cod" value="cod" checked>
                            <label class="form-check-label w-100" for="pay_cod">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold"><i class="bi bi-cash-stack text-success me-2"></i>Cash on Delivery (COD)</span>
                                    <span class="badge bg-light text-dark border">Pay upon receipt</span>
                                </div>
                                <small class="text-muted d-block mt-1">Pay with cash or card upon delivery at your doorstep.</small>
                            </label>
                        </div>

                        <div class="form-check p-3 border rounded-3">
                            <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="pay_card" value="card">
                            <label class="form-check-label w-100" for="pay_card">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold"><i class="bi bi-credit-card-2-front text-primary me-2"></i>Credit / Debit Card</span>
                                    <span class="badge bg-primary-subtle text-primary">Instant</span>
                                </div>
                                <small class="text-muted d-block mt-1">Visa, MasterCard, RuPay, Maestro accepted.</small>
                            </label>
                        </div>

                        <div class="form-check p-3 border rounded-3">
                            <input class="form-check-input ms-0 me-3" type="radio" name="payment_method" id="pay_upi" value="upi">
                            <label class="form-check-label w-100" for="pay_upi">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold"><i class="bi bi-qr-code text-warning me-2"></i>UPI / QR Code</span>
                                    <span class="badge bg-warning-subtle text-dark">Fast</span>
                                </div>
                                <small class="text-muted d-block mt-1">Google Pay, PhonePe, Paytm, BHIM UPI.</small>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Review Sidebar -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3">Order Items ({{ $cartItems->count() }})</h5>

                    <div class="d-flex flex-column gap-3 mb-4 max-h-300 overflow-y-auto" style="max-height: 280px;">
                        @foreach($cartItems as $item)
                            <div class="d-flex align-items-center justify-content-between border-bottom pb-2">
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item->product ? $item->product->image_url : '' }}" alt="" class="rounded border me-2" style="width: 45px; height: 45px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0 text-truncate small fw-bold" style="max-width: 180px;">{{ $item->product ? $item->product->name : '' }}</h6>
                                        <small class="text-muted">Qty: {{ $item->quantity }} × ${{ number_format($item->product ? $item->product->price : 0, 2) }}</small>
                                    </div>
                                </div>
                                <span class="fw-bold small">${{ number_format($item->subtotal, 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-semibold">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Estimated Tax (5%)</span>
                        <span class="fw-semibold">${{ number_format($tax, 2) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping</span>
                        @if($shipping == 0)
                            <span class="text-success fw-bold">FREE</span>
                        @else
                            <span class="fw-semibold">${{ number_format($shipping, 2) }}</span>
                        @endif
                    </div>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between mb-4">
                        <span class="fw-bold fs-5">Total Amount</span>
                        <span class="fw-bold fs-5 text-primary">${{ number_format($total, 2) }}</span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">
                        <i class="bi bi-lock-fill me-1"></i> Confirm & Place Order
                    </button>

                    <p class="text-muted text-center small mt-3 mb-0">
                        <i class="bi bi-shield-check me-1"></i> Guaranteed 256-Bit SSL Encrypted Checkout
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
