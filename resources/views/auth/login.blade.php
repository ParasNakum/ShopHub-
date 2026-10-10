@extends('layouts.app')

@section('title', 'Sign In - ShopHub')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle fs-1 text-primary"></i>
                        <h3 class="fw-bold mt-2">Sign In to ShopHub</h3>
                        <p class="text-muted small">Access your customer orders, seller dashboard, or admin panel</p>
                    </div>

                    <!-- 1-Click Demo Login Bar -->
                    <div class="alert alert-light border mb-4">
                        <span class="small fw-bold d-block mb-2 text-secondary"><i class="bi bi-lightning-charge-fill text-warning me-1"></i> Quick Demo Logins:</span>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-outline-danger btn-sm quick-login-btn" onclick="fillLogin('admin@shophub.com', 'password')">
                                <i class="bi bi-shield-lock me-1"></i> Admin Demo
                            </button>
                            <button type="button" class="btn btn-outline-info btn-sm quick-login-btn text-dark" onclick="fillLogin('techseller@shophub.com', 'password')">
                                <i class="bi bi-shop me-1"></i> Seller Demo
                            </button>
                            <button type="button" class="btn btn-outline-success btn-sm quick-login-btn" onclick="fillLogin('customer@shophub.com', 'password')">
                                <i class="bi bi-person me-1"></i> Customer Demo
                            </button>
                        </div>
                    </div>

                    <form action="{{ route('login.post') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus placeholder="name@example.com">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Enter password">
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label for="remember" class="form-check-label small text-muted">Remember me</label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted small mb-0">Don't have an account yet? <a href="{{ route('register') }}" class="text-primary fw-semibold">Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
