@extends('layouts.seller')

@section('title', 'Seller Dashboard')
@section('page_title', 'Seller Dashboard Overview')

@section('content')
<!-- KPI Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-white border-0 shadow-sm">
            <div class="stat-icon bg-success-subtle text-success">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div>
                <span class="text-muted small">Total Revenue</span>
                <h4 class="fw-bold mb-0">${{ number_format($totalRevenue, 2) }}</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-white border-0 shadow-sm">
            <div class="stat-icon bg-primary-subtle text-primary">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <span class="text-muted small">Total Products</span>
                <h4 class="fw-bold mb-0">{{ $totalProducts }}</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-white border-0 shadow-sm">
            <div class="stat-icon bg-info-subtle text-info">
                <i class="bi bi-bag-check"></i>
            </div>
            <div>
                <span class="text-muted small">Items Sold</span>
                <h4 class="fw-bold mb-0">{{ $totalItemsSold }}</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-white border-0 shadow-sm">
            <div class="stat-icon bg-warning-subtle text-warning">
                <i class="bi bi-exclamation-octagon"></i>
            </div>
            <div>
                <span class="text-muted small">Out of Stock</span>
                <h4 class="fw-bold mb-0">{{ $outOfStockProducts }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Recent Sold Order Items -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Recent Item Sales</h6>
                <a href="{{ route('seller.orders.index') }}" class="btn btn-sm btn-link text-decoration-none">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrderItems as $item)
                                <tr>
                                    <td>
                                        <a href="{{ route('seller.orders.show', $item->order_id) }}" class="fw-bold text-decoration-none text-primary">
                                            {{ $item->order ? $item->order->order_number : '#' . $item->order_id }}
                                        </a>
                                    </td>
                                    <td class="text-truncate" style="max-width: 160px;">{{ $item->product_name }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="fw-semibold">${{ number_format($item->subtotal, 2) }}</td>
                                    <td>
                                        @if($item->order)
                                            <span class="badge {{ $item->order->status_badge_class }}">{{ ucfirst($item->order->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">No sales recorded yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-box-seam me-2 text-primary"></i>Your Listings</h6>
                <a href="{{ route('seller.products.create') }}" class="btn btn-sm btn-primary">+ Add New</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProducts as $prod)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $prod->image_url }}" alt="" class="rounded border me-2" style="width: 38px; height: 38px; object-fit: cover;">
                                            <span class="text-truncate fw-semibold small" style="max-width: 120px;">{{ $prod->name }}</span>
                                        </div>
                                    </td>
                                    <td class="small fw-bold">${{ number_format($prod->price, 2) }}</td>
                                    <td>
                                        @if($prod->stock > 0)
                                            <span class="badge bg-success-subtle text-success">{{ $prod->stock }}</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">0</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('seller.products.edit', $prod->id) }}" class="btn btn-sm btn-light border py-0 px-2" title="Edit">
                                            <i class="bi bi-pencil small"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No products created yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
