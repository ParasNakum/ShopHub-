<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Seller Portal') - ShopHub Merchant</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 dashboard-sidebar position-fixed top-0 bottom-0 overflow-y-auto">
                <div class="p-3 border-bottom border-secondary d-flex align-items-center justify-content-between">
                    <a href="{{ route('seller.dashboard') }}" class="text-white text-decoration-none fw-bold fs-5">
                        <i class="bi bi-shop text-info me-2"></i>Seller Hub
                    </a>
                </div>

                <div class="py-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}" href="{{ route('seller.dashboard') }}">
                                <i class="bi bi-graph-up-arrow"></i> Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seller.products.index') ? 'active' : '' }}" href="{{ route('seller.products.index') }}">
                                <i class="bi bi-box-seam"></i> My Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seller.products.create') ? 'active' : '' }}" href="{{ route('seller.products.create') }}">
                                <i class="bi bi-plus-circle"></i> Add Product
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('seller.orders.*') ? 'active' : '' }}" href="{{ route('seller.orders.index') }}">
                                <i class="bi bi-receipt"></i> Orders & Sales
                            </a>
                        </li>
                    </ul>

                    <hr class="border-secondary mx-3 my-4">

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-info" href="{{ route('home') }}" target="_blank">
                                <i class="bi bi-box-arrow-up-right"></i> View Shopfront
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                                    <i class="bi bi-box-arrow-right"></i> Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-9 col-lg-10 ms-auto px-4 py-3">
                <!-- Topbar -->
                <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
                    <h4 class="mb-0 fw-bold">@yield('page_title', 'Seller Portal')</h4>
                    <div class="d-flex align-items-center gap-3">
                        <a href="{{ route('seller.products.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus-lg me-1"></i> Add Product
                        </a>
                        <span class="badge bg-info text-dark px-3 py-2">Seller Store</span>
                        <span class="fw-semibold">{{ auth()->user()->name }}</span>
                    </div>
                </div>

                <!-- Flash Messages -->
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

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('scripts')
</body>
</html>
