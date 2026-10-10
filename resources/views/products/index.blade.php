@extends('layouts.app')

@section('title', 'Product Catalog - ShopHub')

@section('content')
<div class="container py-3">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Products</li>
        </ol>
    </nav>

    <div class="row g-4">
        <!-- Sidebar Filters -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm p-3 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"><i class="bi bi-funnel me-1 text-primary"></i> Filters</h5>
                    @if(request()->anyFilled(['q', 'category', 'min_price', 'max_price', 'sort']))
                        <a href="{{ route('products.index') }}" class="badge bg-light text-danger text-decoration-none border">Clear All</a>
                    @endif
                </div>

                <form action="{{ route('products.index') }}" method="GET">
                    <!-- Search input -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Keyword</label>
                        <input type="text" name="q" class="form-control form-control-sm" placeholder="e.g. Headphones" value="{{ request('q') }}">
                    </div>

                    <!-- Category filter -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Category</label>
                        <select name="category" class="form-select form-select-sm">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->products_count }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price Range -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Price Range ($)</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <input type="number" name="min_price" class="form-control form-control-sm" placeholder="Min" value="{{ request('min_price') }}">
                            </div>
                            <div class="col-6">
                                <input type="number" name="max_price" class="form-control form-control-sm" placeholder="Max" value="{{ request('max_price') }}">
                            </div>
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Sort By</label>
                        <select name="sort" class="form-select form-select-sm">
                            <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Newest</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name: A to Z</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                        Apply Filters
                    </button>
                </form>
            </div>
        </div>

        <!-- Product Listings -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="text-muted mb-0 small">
                    Showing <strong>{{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> products
                </p>
            </div>

            @if($products->isEmpty())
                <div class="card border-0 shadow-sm p-5 text-center">
                    <i class="bi bi-search fs-1 text-muted mb-3"></i>
                    <h5 class="fw-bold">No Products Found</h5>
                    <p class="text-muted">We couldn't find any products matching your selected criteria. Try adjusting your search or filters.</p>
                    <div>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm">Reset Filters</a>
                    </div>
                </div>
            @else
                <div class="row g-4">
                    @foreach($products as $product)
                        <div class="col-6 col-md-4">
                            <div class="card product-card">
                                <div class="product-img-wrapper">
                                    @if($product->discount_percentage > 0)
                                        <span class="badge-discount">-{{ $product->discount_percentage }}%</span>
                                    @endif
                                    <a href="{{ route('products.show', $product->slug) }}">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy">
                                    </a>
                                </div>
                                <div class="card-body d-flex flex-column p-3">
                                    <div class="text-muted small mb-1">
                                        {{ $product->category ? $product->category->name : 'General' }}
                                    </div>
                                    <h6 class="card-title fw-bold text-truncate mb-2">
                                        <a href="{{ route('products.show', $product->slug) }}" class="text-decoration-none text-dark">
                                            {{ $product->name }}
                                        </a>
                                    </h6>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="text-warning small me-2">
                                            <i class="bi bi-star-fill"></i>
                                            <span class="text-dark fw-bold ms-1">{{ number_format($product->averageRating(), 1) }}</span>
                                        </div>
                                        <span class="text-muted small">({{ $product->reviews->count() }})</span>
                                    </div>
                                    <div class="mt-auto d-flex align-items-center justify-content-between pt-2 border-top">
                                        <div>
                                            <span class="fw-bold text-primary fs-5">${{ number_format($product->price, 2) }}</span>
                                            @if($product->compare_price)
                                                <span class="text-muted text-decoration-line-through small ms-1">${{ number_format($product->compare_price, 2) }}</span>
                                            @endif
                                        </div>
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary rounded-circle" title="Add to Cart">
                                                <i class="bi bi-cart-plus"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-4 d-flex justify-content-center">
                    {{ $products->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
