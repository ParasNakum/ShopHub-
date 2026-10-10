@extends('layouts.app')

@section('title', 'Order #' . $order->order_number . ' - ShopHub')

@section('content')
<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('orders.index') }}" class="btn btn-link text-decoration-none ps-0 mb-1">
                <i class="bi bi-arrow-left me-1"></i> Back to All Orders
            </a>
            <h3 class="fw-bold mb-0">Order <span class="text-primary">#{{ $order->order_number }}</span></h3>
            <span class="text-muted small">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</span>
        </div>

        <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
            <span class="badge {{ $order->status_badge_class }} fs-6 px-3 py-2">{{ ucfirst($order->status) }}</span>
            @if($order->status === 'pending')
                <form action="{{ route('orders.cancel', $order->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this order?');">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="bi bi-x-circle me-1"></i> Cancel Order
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Status Progress Steps -->
    <div class="card border-0 shadow-sm p-4 mb-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-truck me-2 text-primary"></i>Delivery Timeline</h6>
        @php
            $steps = ['pending' => 'Order Placed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered'];
            $currentIndex = match($order->status) {
                'pending' => 0,
                'processing' => 1,
                'shipped' => 2,
                'delivered' => 3,
                default => -1,
            };
        @endphp

        @if($order->status === 'cancelled')
            <div class="alert alert-danger mb-0">
                <i class="bi bi-x-circle-fill me-2"></i> This order was cancelled.
            </div>
        @else
            <div class="row text-center position-relative">
                @foreach(array_values($steps) as $idx => $label)
                    <div class="col-3">
                        <div class="d-flex flex-column align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white mb-2 {{ $idx <= $currentIndex ? 'bg-success' : 'bg-secondary' }}" style="width: 38px; height: 38px;">
                                @if($idx < $currentIndex)
                                    <i class="bi bi-check-lg fs-5"></i>
                                @else
                                    <span class="fw-bold">{{ $idx + 1 }}</span>
                                @endif
                            </div>
                            <span class="small fw-semibold {{ $idx <= $currentIndex ? 'text-success' : 'text-muted' }}">{{ $label }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="row g-4">
        <!-- Order Items -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0">Ordered Items</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product ? $item->product->image_url : '' }}" alt="" class="rounded border me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <span class="fw-bold d-block">{{ $item->product_name }}</span>
                                                    <small class="text-muted">Seller: {{ $item->seller ? $item->seller->name : 'Official' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td class="text-end fw-bold">${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary & Shipping -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h6 class="fw-bold mb-3">Order Cost Breakdown</h6>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-semibold">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Tax</span>
                    <span class="fw-semibold">${{ number_format($order->tax, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Shipping</span>
                    <span class="fw-semibold">${{ number_format($order->shipping_fee, 2) }}</span>
                </div>
                <hr class="my-2">
                <div class="d-flex justify-content-between">
                    <span class="fw-bold fs-5">Total</span>
                    <span class="fw-bold fs-5 text-primary">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <div class="card border-0 shadow-sm p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt me-1 text-primary"></i>Delivery Information</h6>
                <p class="mb-1 fw-bold">{{ $order->shipping_name }}</p>
                <p class="mb-1 text-muted small">{{ $order->shipping_address }}</p>
                <p class="mb-1 text-muted small">{{ $order->shipping_city }} - {{ $order->shipping_postal_code }}</p>
                <p class="mb-2 text-muted small"><i class="bi bi-telephone me-1"></i> {{ $order->shipping_phone }}</p>
                <p class="mb-0 text-muted small"><i class="bi bi-envelope me-1"></i> {{ $order->shipping_email }}</p>

                @if($order->order_notes)
                    <hr class="my-3">
                    <h6 class="fw-bold mb-1 small">Special Instructions:</h6>
                    <p class="text-muted small mb-0">{{ $order->order_notes }}</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
