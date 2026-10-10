@extends('layouts.admin')

@section('title', 'Manage Products')
@section('page_title', 'Product Catalog Moderation')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
        <form action="{{ route('admin.products.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="q" class="form-control form-control-sm" placeholder="Search product..." value="{{ request('q') }}">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            <button type="submit" class="btn btn-sm btn-outline-secondary">Filter</button>
        </form>

        <span class="text-muted small">Total: <strong>{{ $products->total() }}</strong> products</span>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th>Seller</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Featured</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $product->image_url }}" alt="" class="rounded border me-3" style="width: 44px; height: 44px; object-fit: cover;">
                                    <div>
                                        <a href="{{ route('products.show', $product->slug) }}" class="fw-bold small text-decoration-none text-dark" target="_blank">
                                            {{ $product->name }}
                                        </a>
                                        <small class="text-muted d-block">SKU: {{ $product->sku }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="small fw-semibold">{{ $product->seller ? $product->seller->name : 'N/A' }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $product->category ? $product->category->name : 'Uncategorized' }}</span>
                            </td>
                            <td class="fw-bold">${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <form action="{{ route('admin.products.toggle-featured', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm p-0 border-0 bg-transparent" title="Toggle Featured">
                                        @if($product->is_featured)
                                            <i class="bi bi-star-fill text-warning fs-5"></i>
                                        @else
                                            <i class="bi bi-star text-muted fs-5"></i>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.products.toggle-status', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="badge border-0 {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}" title="Click to toggle status">
                                        {{ ucfirst($product->status) }}
                                    </button>
                                </form>
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Product">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection
