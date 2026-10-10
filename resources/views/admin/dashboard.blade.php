@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page_title', 'System Administration Overview')

@section('content')
<!-- KPI Cards Row -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-white border-0 shadow-sm">
            <div class="stat-icon bg-success-subtle text-success">
                <i class="bi bi-cash-coin"></i>
            </div>
            <div>
                <span class="text-muted small">Total Platform Sales</span>
                <h4 class="fw-bold mb-0">${{ number_format($stats['total_sales'], 2) }}</h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-white border-0 shadow-sm">
            <div class="stat-icon bg-primary-subtle text-primary">
                <i class="bi bi-cart-check"></i>
            </div>
            <div>
                <span class="text-muted small">Total Orders</span>
                <h4 class="fw-bold mb-0">{{ $stats['total_orders'] }} <small class="text-warning fs-6">({{ $stats['pending_orders'] }} pending)</small></h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-white border-0 shadow-sm">
            <div class="stat-icon bg-info-subtle text-info">
                <i class="bi bi-people"></i>
            </div>
            <div>
                <span class="text-muted small">Registered Users</span>
                <h4 class="fw-bold mb-0">{{ $stats['total_customers'] }} <small class="text-muted fs-6">cust / {{ $stats['total_sellers'] }} sell</small></h4>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-white border-0 shadow-sm">
            <div class="stat-icon bg-warning-subtle text-warning">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <span class="text-muted small">Active Products</span>
                <h4 class="fw-bold mb-0">{{ $stats['total_products'] }}</h4>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Recent Orders -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-receipt me-2 text-primary"></i>Recent Platform Orders</h6>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-link text-decoration-none">Manage All Orders</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $ord)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $ord->id) }}" class="fw-bold text-decoration-none text-primary">
                                            {{ $ord->order_number }}
                                        </a>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $ord->shipping_name }}</span>
                                    </td>
                                    <td class="text-muted small">{{ $ord->created_at->format('M d, H:i') }}</td>
                                    <td class="fw-bold">${{ number_format($ord->total_amount, 2) }}</td>
                                    <td>
                                        <span class="badge {{ $ord->status_badge_class }}">{{ ucfirst($ord->status) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.orders.show', $ord->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No orders yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-people me-2 text-primary"></i>Latest Users</h6>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-link text-decoration-none">View All</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($recentUsers as $usr)
                        <li class="list-group-item d-flex justify-content-between align-items-center py-3">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary rounded-circle p-2 me-2">{{ strtoupper(substr($usr->name, 0, 1)) }}</span>
                                <div>
                                    <span class="fw-bold d-block small">{{ $usr->name }}</span>
                                    <span class="text-muted" style="font-size: 0.75rem;">{{ $usr->email }}</span>
                                </div>
                            </div>
                            <span class="badge {{ $usr->role === 'admin' ? 'bg-danger' : ($usr->role === 'seller' ? 'bg-info text-dark' : 'bg-primary') }}">
                                {{ ucfirst($usr->role) }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-4 text-muted">No users found.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
