@extends('layouts.app')

@section('title', $product->name . ' - ShopHub')

@section('content')
<div class="container py-3">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Products</a></li>
            @if($product->category)
                <li class="breadcrumb-item"><a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
            @endif
            <li class="breadcrumb-item active text-truncate" style="max-width: 300px;">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="card border-0 shadow-sm p-4 mb-5">
        <div class="row g-4">
            <!-- Product Image -->
            <div class="col-md-5">
                <div class="border rounded-3 overflow-hidden bg-light text-center p-2" style="max-height: 450px;">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid rounded-3" style="max-height: 430px; object-fit: contain;">
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-7">
                <div class="d-flex align-items-center gap-2 mb-2">
                    @if($product->category)
                        <span class="badge bg-light text-primary border">{{ $product->category->name }}</span>
                    @endif
                    <span class="badge bg-light text-secondary border">
                        <i class="bi bi-shop me-1"></i>Seller: {{ $product->seller ? $product->seller->name : 'Official Store' }}
                    </span>
                    @if($product->stock > 0)
                        <span class="badge bg-success-subtle text-success border border-success-subtle">In Stock ({{ $product->stock }})</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Out of Stock</span>
                    @endif
                </div>

                <h2 class="fw-bold mb-3">{{ $product->name }}</h2>

                <!-- Rating -->
                <div class="d-flex align-items-center mb-3">
                    <div class="text-warning fs-5 me-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= round($product->averageRating()) ? '-fill' : '' }}"></i>
                        @endfor
                    </div>
                    <span class="fw-bold">{{ number_format($product->averageRating(), 1) }}</span>
                    <span class="text-muted ms-2 small">({{ $product->reviews->count() }} reviews)</span>
                    <span class="text-muted ms-3 small">SKU: {{ $product->sku }}</span>
                </div>

                <!-- Price -->
                <div class="mb-4 p-3 bg-light rounded-3 d-flex align-items-baseline gap-3">
                    <span class="fs-2 fw-bold text-primary">₹{{ number_format($product->price, 2) }}</span>
                    @if($product->compare_price)
                        <span class="fs-5 text-muted text-decoration-line-through">₹{{ number_format($product->compare_price, 2) }}</span>
                        <span class="badge bg-danger fs-6">Save {{ $product->discount_percentage }}%</span>
                    @endif
                </div>

                @if($product->short_description)
                    <p class="text-secondary mb-4">{{ $product->short_description }}</p>
                @endif

                <!-- Add to Cart Form -->
                @if($product->stock > 0)
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="quantity" class="form-label mb-0 fw-bold">Quantity:</label>
                            </div>
                            <div class="col-auto" style="width: 120px;">
                                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary px-4 fw-semibold">
                                    <i class="bi bi-cart-plus-fill me-2"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-secondary mb-4">
                        <i class="bi bi-info-circle me-1"></i> This item is currently unavailable. Please check back later.
                    </div>
                @endif

                <!-- Shipping / Guarantee bullets -->
                <div class="border-top pt-3 text-muted small">
                    <div class="row g-2">
                        <div class="col-sm-6"><i class="bi bi-truck text-primary me-2"></i>Free standard delivery over ₹999</div>
                        <div class="col-sm-6"><i class="bi bi-shield-check text-success me-2"></i>Verified seller guarantee</div>
                        <div class="col-sm-6"><i class="bi bi-arrow-repeat text-info me-2"></i>7-day return policy</div>
                        <div class="col-sm-6"><i class="bi bi-credit-card text-warning me-2"></i>Multiple payment options</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Description & Reviews Tabs -->
    <div class="card border-0 shadow-sm p-4 mb-5">
        <ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active fw-bold" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">
                    Product Description
                </button>
            </li>
            <li class="nav-item">
                <button class="nav-link fw-bold" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">
                    Customer Reviews ({{ $product->reviews->count() }})
                </button>
            </li>
        </ul>

        <div class="tab-content" id="productTabsContent">
            <!-- Description Tab -->
            <div class="tab-pane fade show active" id="desc" role="tabpanel">
                <div class="lh-lg">
                    {!! nl2br(e($product->description)) !!}
                </div>
            </div>

            <!-- Reviews Tab -->
            <div class="tab-pane fade" id="reviews" role="tabpanel">
                <div class="row g-4">
                    <div class="col-md-7">
                        <h5 class="fw-bold mb-3">Feedback from verified customers</h5>
                        @if($product->reviews->isEmpty())
                            <p class="text-muted">No reviews yet for this product. Be the first to review it!</p>
                        @else
                            <div class="d-flex flex-column gap-3">
                                @foreach($product->reviews as $review)
                                    <div class="border-bottom pb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="fw-bold">{{ $review->user ? $review->user->name : 'Anonymous Customer' }}</span>
                                            <span class="text-muted small">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="text-warning small mb-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                            @endfor
                                        </div>
                                        <p class="mb-0 text-secondary">{{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Submit Review Form -->
                    <div class="col-md-5">
                        <div class="card bg-light border-0 p-3">
                            <h6 class="fw-bold mb-3">Write a Customer Review</h6>
                            @auth
                                <form action="{{ route('products.reviews.store', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="rating" class="form-label small fw-bold">Rating</label>
                                        <select name="rating" id="rating" class="form-select form-select-sm" required>
                                            <option value="5">⭐⭐⭐⭐⭐ 5 Stars - Excellent</option>
                                            <option value="4">⭐⭐⭐⭐ 4 Stars - Very Good</option>
                                            <option value="3">⭐⭐⭐ 3 Stars - Average</option>
                                            <option value="2">⭐⭐ 2 Stars - Below Average</option>
                                            <option value="1">⭐ 1 Star - Poor</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="comment" class="form-label small fw-bold">Review Comment</label>
                                        <textarea name="comment" id="comment" class="form-control form-control-sm" rows="3" required placeholder="Share your experience with this item..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm w-100">Submit Review</button>
                                </form>
                            @else
                                <p class="small text-muted mb-3">You must be logged in to leave a review.</p>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Sign In to Review</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->isNotEmpty())
        <div class="mb-4">
            <h4 class="fw-bold mb-3">Related Products</h4>
            <div class="row g-4">
                @foreach($relatedProducts as $rel)
                    <div class="col-6 col-md-3">
                        <div class="card product-card">
                            <div class="product-img-wrapper">
                                <a href="{{ route('products.show', $rel->slug) }}">
                                    <img src="{{ $rel->image_url }}" alt="{{ $rel->name }}" loading="lazy">
                                </a>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="card-title fw-bold text-truncate mb-1">
                                    <a href="{{ route('products.show', $rel->slug) }}" class="text-decoration-none text-dark">{{ $rel->name }}</a>
                                </h6>
                                <span class="fw-bold text-primary">₹{{ number_format($rel->price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
