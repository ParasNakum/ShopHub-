<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ShopHub - Your Premium E-Commerce Destination')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <!-- Top Bar -->
    <div class="bg-dark text-white py-1 small">
        <div class="container d-flex justify-content-between align-items-center">
            <div>
                <span><i class="bi bi-truck me-1"></i> Free Shipping on orders over $100</span>
                <span class="ms-3 d-none d-md-inline"><i class="bi bi-shield-check me-1"></i> 100% Secure Checkout</span>
            </div>
            <div class="d-flex align-items-center gap-3">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="text-warning text-decoration-none fw-semibold">
                            <i class="bi bi-speedometer2 me-1"></i> Admin Dashboard
                        </a>
                    @elseif(auth()->user()->isSeller())
                        <a href="{{ route('seller.dashboard') }}" class="text-info text-decoration-none fw-semibold">
                            <i class="bi bi-shop me-1"></i> Seller Portal
                        </a>
                    @endif
                @else
                    <span class="text-light">Welcome to ShopHub!</span>
                @endauth
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top border-bottom">
        <div class="container">
            <a class="navbar-brand text-dark d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-bag-heart-fill text-primary me-2"></i>
                <span>Shop</span><span class="hub-badge ms-1">Hub</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <!-- Search Form -->
                <form action="{{ route('products.index') }}" method="GET" class="d-flex mx-lg-auto my-2 my-lg-0 col-lg-5">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search products, brands, categories..." value="{{ request('q') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold text-primary' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active fw-bold text-primary' : '' }}" href="{{ route('products.index') }}">Shop Catalog</a>
                    </li>

                    <!-- Cart Link -->
                    @php
                        $cartCount = 0;
                        if (auth()->check()) {
                            $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
                        } else {
                            $cartCount = \App\Models\CartItem::where('session_id', session()->getId())->sum('quantity');
                        }
                    @endphp
                    <li class="nav-item me-lg-2">
                        <a class="btn btn-outline-primary position-relative rounded-pill px-3 py-1 my-1" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3 me-1"></i> Cart
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>

                    <!-- User Authentication Links -->
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button" data-bs-toggle="dropdown">
                                <span class="badge bg-primary rounded-circle p-2 me-1">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                                <span class="fw-medium">{{ auth()->user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li class="dropdown-header">Signed in as <strong>{{ ucfirst(auth()->user()->role) }}</strong></li>
                                <li><hr class="dropdown-divider"></li>
                                @if(auth()->user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2 text-primary"></i>Admin Panel</a></li>
                                @endif
                                @if(auth()->user()->isSeller())
                                    <li><a class="dropdown-item" href="{{ route('seller.dashboard') }}"><i class="bi bi-shop me-2 text-info"></i>Seller Dashboard</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('orders.index') }}"><i class="bi bi-bag-check me-2 text-success"></i>My Orders</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bi bi-person me-2"></i>My Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-light border me-1" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Global Alerts -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4 mt-auto">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5 class="fw-bold mb-3 d-flex align-items-center">
                        <i class="bi bi-bag-heart-fill text-primary me-2"></i>
                        <span>Shop</span><span class="hub-badge ms-1">Hub</span>
                    </h5>
                    <p class="text-white-50">
                        A complete multi-role e-commerce web platform engineered with Laravel, PHP, MySQL, Bootstrap, and MVC architecture. Featuring distinct customer, seller, and administrator modules.
                    </p>
                    <div class="d-flex gap-2 text-white-50">
                        <span class="badge bg-secondary">Laravel 11+</span>
                        <span class="badge bg-secondary">PHP 8.2</span>
                        <span class="badge bg-secondary">MySQL</span>
                        <span class="badge bg-secondary">Bootstrap 5</span>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="text-uppercase fw-bold text-light mb-3">Shop</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none">All Products</a></li>
                        <li><a href="{{ route('products.index', ['sort' => 'newest']) }}" class="text-white-50 text-decoration-none">New Arrivals</a></li>
                        <li><a href="{{ route('cart.index') }}" class="text-white-50 text-decoration-none">Cart</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="text-uppercase fw-bold text-light mb-3">Account</h6>
                    <ul class="list-unstyled">
                        @auth
                            <li><a href="{{ route('orders.index') }}" class="text-white-50 text-decoration-none">My Orders</a></li>
                            <li><a href="{{ route('profile') }}" class="text-white-50 text-decoration-none">Profile Settings</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-white-50 text-decoration-none">Sign In</a></li>
                            <li><a href="{{ route('register') }}" class="text-white-50 text-decoration-none">Create Account</a></li>
                            <li><a href="{{ route('register') }}" class="text-white-50 text-decoration-none">Become a Seller</a></li>
                        @endauth
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h6 class="text-uppercase fw-bold text-light mb-3">ShopHub Support</h6>
                    <p class="text-white-50 mb-2"><i class="bi bi-geo-alt me-2"></i> Ahmedabad, Gujarat, India</p>
                    <p class="text-white-50 mb-2"><i class="bi bi-envelope me-2"></i> support@shophub.com</p>
                    <p class="text-white-50"><i class="bi bi-telephone me-2"></i> +91 98765 43210</p>
                </div>
            </div>

            <hr class="my-4 border-secondary">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-white-50 small">
                <span>&copy; {{ date('Y') }} ShopHub E-Commerce. All rights reserved.</span>
                <span>Designed & Built with Laravel MVC Architecture</span>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('scripts')
</body>
</html>
