@extends('layouts.seller')

@section('title', 'Order Details')
@section('page_title', 'Order Details #' . $order->order_number)

@section('content')
<div class="mb-3">
    <a href="{{ route('seller.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Orders
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0">Your Items in this Order</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
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
                                            <img src="{{ $item->product ? $item->product->image_url : '' }}" alt="" class="rounded border me-3" style="width: 45px; height: 45px; object-fit: cover;">
                                            <span class="fw-bold">{{ $item->product_name }}</span>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end fw-bold text-success">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4 mb-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt me-1 text-primary"></i>Customer Shipping Info</h6>
            <p class="mb-1 fw-bold">{{ $order->shipping_name }}</p>
            <p class="mb-1 text-muted small">{{ $order->shipping_address }}</p>
            <p class="mb-1 text-muted small">{{ $order->shipping_city }} - {{ $order->shipping_postal_code }}</p>
            <p class="mb-2 text-muted small"><i class="bi bi-telephone me-1"></i> {{ $order->shipping_phone }}</p>
            <p class="mb-0 text-muted small"><i class="bi bi-envelope me-1"></i> {{ $order->shipping_email }}</p>

            <hr class="my-3">
            <div class="d-flex justify-content-between align-items-center">
                <span class="text-muted small">Order Status:</span>
                <span class="badge {{ $order->status_badge_class }}">{{ ucfirst($order->status) }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <span class="text-muted small">Payment Method:</span>
                <span class="badge bg-light text-dark border text-uppercase">{{ $order->payment_method }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
