@extends('layouts.app')

@section('title', 'Order Placed Successfully - ShopHub')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm p-4 p-md-5 text-center mb-4">
                <div class="mb-3">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4.5rem;"></i>
                </div>
                <h2 class="fw-bold mb-2">Thank You for Your Order!</h2>
                <p class="text-muted lead mb-4">Your order has been received and is currently being processed by our verified sellers.</p>

                <div class="alert alert-light border py-3 mb-4">
                    <span class="text-muted d-block small">Order Number:</span>
                    <strong class="fs-4 text-primary">{{ $order->order_number }}</strong>
                </div>

                <div class="row text-start mb-4 g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <h6 class="fw-bold mb-2"><i class="bi bi-geo-alt me-1 text-primary"></i> Shipping Destination</h6>
                            <p class="mb-1 fw-semibold">{{ $order->shipping_name }}</p>
                            <p class="mb-1 text-muted small">{{ $order->shipping_address }}, {{ $order->shipping_city }} - {{ $order->shipping_postal_code }}</p>
                            <p class="mb-0 text-muted small"><i class="bi bi-telephone me-1"></i> {{ $order->shipping_phone }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100">
                            <h6 class="fw-bold mb-2"><i class="bi bi-receipt me-1 text-primary"></i> Order Details</h6>
                            <p class="mb-1 text-muted small">Date: <span class="text-dark fw-semibold">{{ $order->created_at->format('M d, Y h:i A') }}</span></p>
                            <p class="mb-1 text-muted small">Payment Method: <span class="text-dark fw-semibold text-uppercase">{{ $order->payment_method }}</span></p>
                            <p class="mb-1 text-muted small">Order Status: <span class="badge {{ $order->status_badge_class }}">{{ ucfirst($order->status) }}</span></p>
                            <p class="mb-0 text-muted small">Total Paid: <span class="text-primary fw-bold">${{ number_format($order->total_amount, 2) }}</span></p>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold text-start mb-3">Purchased Items</h5>
                <div class="table-responsive mb-4 text-start">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <span class="fw-semibold">{{ $item->product_name }}</span>
                                    </td>
                                    <td class="text-center">${{ number_format($item->price, 2) }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end fw-bold">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" class="text-end fw-bold">Total:</td>
                                <td class="text-end fw-bold text-primary fs-5">${{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-3">
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary px-4 fw-semibold">
                        <i class="bi bi-eye me-1"></i> Track Order Details
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-primary px-4 fw-semibold">
                        <i class="bi bi-cart-plus me-1"></i> Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
