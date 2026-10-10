@extends('layouts.app')

@section('title', 'ShopHub - Discover, Shop & Sell Online')

@section('content')
<div class="container">
    <!-- Hero Banner -->
    <div class="hero-banner mb-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="badge bg-primary px-3 py-2 text-uppercase mb-3 fw-bold">Multi-Vendor E-Commerce</span>
                <h1 class="display-4 fw-extrabold mb-3">Upgrade Your Lifestyle With ShopHub</h1>
                <p class="lead mb-4 text-light opacity-75">
                    Explore thousands of quality products from certified sellers. Seamless ordering, fast shipping, and reliable service.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4 fw-semibold">
                        <i class="bi bi-bag-fill me-2"></i>Shop Catalog
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 fw-semibold">
                            <i class="bi bi-shop me-2"></i>Start Selling
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <i class="bi bi-cart-check-fill text-primary" style="font-size: 10rem; opacity: 0.85;"></i>
            </div>
        </div>
    </div>

    <!-- Trust Badges Strip -->
    <div class="row g-3 mb-5">
        <div class="col-6 col-md-3">
            <div class="card p-3 h-100 text-center">
                <i class="bi bi-truck fs-1 text-primary mb-2"></i>
                <h6 class="fw-bold mb-1">Fast Delivery</h6>
                <small class="text-muted">Free shipping on orders > ₹999</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 h-100 text-center">
                <i class="bi bi-shield-check fs-1 text-success mb-2"></i>
                <h6 class="fw-bold mb-1">Secure Payments</h6>
                <small class="text-muted">COD, Cards & UPI accepted</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 h-100 text-center">
                <i class="bi bi-arrow-repeat fs-1 text-info mb-2"></i>
                <h6 class="fw-bold mb-1">Easy Returns</h6>
                <small class="text-muted">7-day hassle-free replacement</small>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card p-3 h-100 text-center">
                <i class="bi bi-headset fs-1 text-warning mb-2"></i>
                <h6 class="fw-bold mb-1">24/7 Support</h6>
                <small class="text-muted">Dedicated customer helpdesk</small>
            </div>
        </div>
    </div>

    <!-- Explore Categories -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">Browse by Category</h3>
                <p class="text-muted small mb-0">Hand-picked categories for every shopping desire</p>
            </div>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">View All <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-3">
            @foreach($categories as $category)
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="category-card">
                        <div class="category-icon">
                            <i class="bi {{ $category->icon ?: 'bi-tag' }}"></i>
                        </div>
                        <h6 class="fw-bold mb-1 text-truncate">{{ $category->name }}</h6>
                        <small class="text-muted">{{ $category->products_count }} Products</small>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    @if($featuredProducts->isNotEmpty())
        <div class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h3 class="fw-bold mb-0">⭐ Featured Deals</h3>
                    <p class="text-muted small mb-0">Top-rated items handpicked for quality and value</p>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary btn-sm">See More <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="row g-4">
                @foreach($featuredProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
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
                                        <span class="fw-bold text-primary fs-5">₹{{ number_format($product->price, 2) }}</span>
                                        @if($product->compare_price)
                                            <span class="text-muted text-decoration-line-through small ms-1">₹{{ number_format($product->compare_price, 2) }}</span>
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
        </div>
    @endif

    <!-- Latest Arrivals -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-0">🔥 Latest Arrivals</h3>
                <p class="text-muted small mb-0">Freshly listed products from our vendors</p>
            </div>
            <a href="{{ route('products.index', ['sort' => 'newest']) }}" class="btn btn-outline-primary btn-sm">Explore All <i class="bi bi-arrow-right"></i></a>
        </div>

        <div class="row g-4">
            @foreach($latestProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
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
                                    <span class="fw-bold text-primary fs-5">₹{{ number_format($product->price, 2) }}</span>
                                    @if($product->compare_price)
                                        <span class="text-muted text-decoration-line-through small ms-1">₹{{ number_format($product->compare_price, 2) }}</span>
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
    </div>
</div>
@endsection
