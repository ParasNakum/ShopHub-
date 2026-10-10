@extends('layouts.admin')

@section('title', 'Manage Users')
@section('page_title', 'User Accounts & Roles')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
        <form action="{{ route('admin.users.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Search name/email..." value="{{ request('q') }}">
            <select name="role" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Roles</option>
                <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customers</option>
                <option value="seller" {{ request('role') == 'seller' ? 'selected' : '' }}>Sellers</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admins</option>
            </select>
            <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
        </form>

        <span class="text-muted small">Total: <strong>{{ $users->total() }}</strong> users</span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Change Role</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $usr)
                        <tr>
                            <td>
                                <div>
                                    <span class="fw-bold d-block">{{ $usr->name }}</span>
                                    <small class="text-muted">{{ $usr->email }}</small>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $usr->role === 'admin' ? 'bg-danger' : ($usr->role === 'seller' ? 'bg-info text-dark' : 'bg-primary') }}">
                                    {{ ucfirst($usr->role) }}
                                </span>
                            </td>
                            <td>
                                @if($usr->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-warning text-dark">Suspended</span>
                                @endif
                            </td>
                            <td class="text-muted small">
                                {{ $usr->created_at->format('M d, Y') }}
                            </td>
                            <td>
                                @if($usr->id !== auth()->id())
                                    <form action="{{ route('admin.users.role', $usr->id) }}" method="POST" class="d-inline-flex align-items-center gap-1">
                                        @csrf
                                        <select name="role" class="form-select form-select-sm" style="width: 120px;" onchange="this.form.submit()">
                                            <option value="customer" {{ $usr->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                            <option value="seller" {{ $usr->role === 'seller' ? 'selected' : '' }}>Seller</option>
                                            <option value="admin" {{ $usr->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                    </form>
                                @else
                                    <small class="text-muted">Current User</small>
                                @endif
                            </td>
                            <td class="text-end">
                                @if($usr->id !== auth()->id())
                                    <div class="d-flex justify-content-end gap-1">
                                        <!-- Toggle Status -->
                                        <form action="{{ route('admin.users.toggle-status', $usr->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $usr->status === 'active' ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $usr->status === 'active' ? 'Suspend' : 'Activate' }}">
                                                <i class="bi {{ $usr->status === 'active' ? 'bi-person-slash' : 'bi-person-check' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.users.destroy', $usr->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete User">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $users->links('pagination::bootstrap-5') }}
</div>
@endsection
