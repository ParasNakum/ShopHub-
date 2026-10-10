@extends('layouts.seller')

@section('title', 'Sales & Orders')
@section('page_title', 'Customer Orders for Your Products')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom">
        <h6 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-primary"></i>All Item Orders</h6>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Order #</th>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Earnings</th>
                        <th>Customer</th>
                        <th>Order Status</th>
                        <th class="text-end">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orderItems as $item)
                        <tr>
                            <td class="fw-bold text-primary">
                                {{ $item->order ? $item->order->order_number : 'N/A' }}
                            </td>
                            <td class="text-muted small">
                                {{ $item->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                <span class="fw-semibold">{{ $item->product_name }}</span>
                            </td>
                            <td>{{ $item->quantity }}</td>
                            <td class="fw-bold text-success">${{ number_format($item->subtotal, 2) }}</td>
                            <td>
                                <div>{{ $item->order ? $item->order->shipping_name : 'Customer' }}</div>
                                <small class="text-muted">{{ $item->order ? $item->order->shipping_city : '' }}</small>
                            </td>
                            <td>
                                @if($item->order)
                                    <span class="badge {{ $item->order->status_badge_class }}">{{ ucfirst($item->order->status) }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($item->order)
                                    <a href="{{ route('seller.orders.show', $item->order_id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i> View
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-receipt fs-1 d-block mb-2 text-secondary"></i>
                                No customer orders recorded for your items yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $orderItems->links('pagination::bootstrap-5') }}
</div>
@endsection
