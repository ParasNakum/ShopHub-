@extends('layouts.app')

@section('title', 'My Profile - ShopHub')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="fw-bold mb-0"><i class="bi bi-person-gear me-2 text-primary"></i>Profile Settings</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Account Role</label>
                                <input type="text" class="form-control bg-light" value="{{ ucfirst($user->role) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Account Status</label>
                                <input type="text" class="form-control bg-light" value="{{ ucfirst($user->status) }}" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-semibold">Full Name</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Address</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                            <div class="form-text small">Email address cannot be changed.</div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-semibold">Default Delivery Address</label>
                            <textarea name="address" id="address" class="form-control" rows="3">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <hr class="my-4">
                        <h6 class="fw-bold mb-3 text-secondary"><i class="bi bi-shield-lock me-2"></i>Change Password (Leave blank to keep unchanged)</h6>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Optional">
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Optional">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            <i class="bi bi-save me-1"></i> Update Profile
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
