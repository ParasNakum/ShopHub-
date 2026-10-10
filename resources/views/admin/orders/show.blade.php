@extends('layouts.admin')

@section('title', 'Order #' . $order->order_number)
@section('page_title', 'Order Management #' . $order->order_number)

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Orders
    </a>

    <div class="d-flex gap-2">
        <!-- Status change forms -->
        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="d-flex align-items-center gap-1">
            @csrf
            <label class="small fw-bold text-muted mb-0">Status:</label>
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </form>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="fw-bold mb-0">Purchased Items Breakdown</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Seller</th>
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
                                    <td>
                                        <span class="small">{{ $item->seller ? $item->seller->name : 'N/A' }}</span>
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

    <div class="col-lg-4">
        <div class="card border-0 shadow-sm p-4 mb-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-geo-alt me-1 text-primary"></i>Shipping Details</h6>
            <p class="mb-1 fw-bold">{{ $order->shipping_name }}</p>
            <p class="mb-1 text-muted small">{{ $order->shipping_address }}</p>
            <p class="mb-1 text-muted small">{{ $order->shipping_city }} - {{ $order->shipping_postal_code }}</p>
            <p class="mb-2 text-muted small"><i class="bi bi-telephone me-1"></i> {{ $order->shipping_phone }}</p>
            <p class="mb-0 text-muted small"><i class="bi bi-envelope me-1"></i> {{ $order->shipping_email }}</p>

            @if($order->order_notes)
                <hr class="my-3">
                <h6 class="fw-bold mb-1 small">Customer Notes:</h6>
                <p class="text-muted small mb-0">{{ $order->order_notes }}</p>
            @endif
        </div>

        <div class="card border-0 shadow-sm p-4">
            <h6 class="fw-bold mb-3">Invoice Summary</h6>
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
    </div>
</div>
@endsection
