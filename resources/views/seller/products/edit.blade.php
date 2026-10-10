@extends('layouts.seller')

@section('title', 'Edit Product - ' . $product->name)
@section('page_title', 'Edit Product Listing')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom">
                <h5 class="fw-bold mb-0">Edit: {{ $product->name }}</h5>
                <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back to Catalog
                </a>
            </div>

            <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-8">
                        <label for="name" class="form-label fw-bold">Product Title <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="category_id" class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="price" class="form-label fw-bold">Price ($) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" required>
                        @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="compare_price" class="form-label fw-bold">Original / Compare Price ($)</label>
                        <input type="number" step="0.01" name="compare_price" id="compare_price" class="form-control" value="{{ old('compare_price', $product->compare_price) }}">
                    </div>

                    <div class="col-md-4">
                        <label for="stock" class="form-label fw-bold">Available Stock <span class="text-danger">*</span></label>
                        <input type="number" name="stock" id="stock" class="form-control @error('stock') is-invalid @enderror" value="{{ old('stock', $product->stock) }}" required min="0">
                        @error('stock') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="sku" class="form-label fw-bold">SKU Code</label>
                        <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                    </div>

                    <div class="col-md-6">
                        <label for="status" class="form-label fw-bold">Listing Status <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active (Visible in Store)</option>
                            <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive (Draft)</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="short_description" class="form-label fw-bold">Short Summary</label>
                        <input type="text" name="short_description" id="short_description" class="form-control" value="{{ old('short_description', $product->short_description) }}">
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-bold">Full Product Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" required>{{ old('description', $product->description) }}</textarea>
                        @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <!-- Current Image Preview -->
                    <div class="col-12">
                        <label class="form-label fw-bold">Current Image</label>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $product->image_url }}" alt="" class="rounded border" style="width: 80px; height: 80px; object-fit: cover;">
                            <span class="text-muted small">Provide a new URL or upload below to replace current image.</span>
                        </div>
                    </div>

                    <!-- Images -->
                    <div class="col-md-6">
                        <label for="image_url" class="form-label fw-bold">Image Web URL</label>
                        <input type="url" name="image_url" id="image_url" class="form-control" value="{{ old('image_url', str_starts_with($product->image, 'http') ? $product->image : '') }}" placeholder="https://images.unsplash.com/...">
                    </div>

                    <div class="col-md-6">
                        <label for="image_file" class="form-label fw-bold">Or Upload New Image File</label>
                        <input type="file" name="image_file" id="image_file" class="form-control" accept="image/*">
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_featured">
                                Featured Placement on Homepage
                            </label>
                        </div>
                    </div>

                    <div class="col-12 mt-4 pt-3 border-top d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 fw-semibold">
                            <i class="bi bi-save me-1"></i> Update Listing
                        </button>
                        <a href="{{ route('seller.products.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
