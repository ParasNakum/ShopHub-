@extends('layouts.app')

@section('title', 'Create an Account - ShopHub')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus-fill fs-1 text-primary"></i>
                        <h3 class="fw-bold mt-2">Join ShopHub</h3>
                        <p class="text-muted small">Create an account to shop or sell products on ShopHub</p>
                    </div>

                    <form action="{{ route('register.post') }}" method="POST">
                        @csrf

                        <!-- Account Role Selector -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">I want to register as:</label>
                            <div class="row g-2">
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="role_customer" value="customer" {{ old('role', 'customer') == 'customer' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary w-100 py-2 d-flex flex-column align-items-center" for="role_customer">
                                        <i class="bi bi-bag-check fs-4 mb-1"></i>
                                        <span class="fw-bold">Customer</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">I want to buy products</small>
                                    </label>
                                </div>
                                <div class="col-6">
                                    <input type="radio" class="btn-check" name="role" id="role_seller" value="seller" {{ old('role') == 'seller' ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary w-100 py-2 d-flex flex-column align-items-center" for="role_seller">
                                        <i class="bi bi-shop fs-4 mb-1"></i>
                                        <span class="fw-bold">Seller</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">I want to sell products</small>
                                    </label>
                                </div>
                            </div>
                            @error('role')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Full Name / Store Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. John Doe or TechStore">
                            </div>
                            @error('name')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="name@example.com">
                            </div>
                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key"></i></span>
                                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required placeholder="Min. 6 chars">
                                </div>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required placeholder="Repeat password">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Phone Number <span class="text-muted fw-normal">(Optional)</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="+91 98765 43210">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label fw-semibold">Address <span class="text-muted fw-normal">(Optional)</span></label>
                            <textarea name="address" id="address" class="form-control" rows="2" placeholder="Street address, city, state, postal code">{{ old('address') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="bi bi-check2-circle me-1"></i> Complete Registration
                        </button>
                    </form>

                    <div class="text-center mt-4 pt-3 border-top">
                        <p class="text-muted small mb-0">Already registered? <a href="{{ route('login') }}" class="text-primary fw-semibold">Sign in here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
