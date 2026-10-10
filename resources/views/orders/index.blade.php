@extends('layouts.app')

@section('title', 'My Orders - ShopHub')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0"><i class="bi bi-bag-check me-2 text-primary"></i>My Orders</h3>
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-cart-plus me-1"></i> Shop More
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="card border-0 shadow-sm p-5 text-center">
            <i class="bi bi-box2 text-muted" style="font-size: 4rem;"></i>
            <h4 class="fw-bold mt-3">No Orders Yet</h4>
            <p class="text-muted">You haven't placed any orders with ShopHub yet.</p>
            <div>
                <a href="{{ route('products.index') }}" class="btn btn-primary px-4">Browse Catalog</a>
            </div>
        </div>
    @else
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="fw-bold text-primary">{{ $order->order_number }}</td>
                                <td class="text-muted small">{{ $order->created_at->format('M d, Y') }}</td>
                                <td>{{ $order->items->sum('quantity') }} item(s)</td>
                                <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                                <td>
                                    <span class="badge {{ $order->status_badge_class }}">{{ ucfirst($order->status) }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border text-uppercase">{{ $order->payment_method }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
