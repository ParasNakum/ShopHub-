@extends('layouts.admin')

@section('title', 'Manage Categories')
@section('page_title', 'Product Categories')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0"><i class="bi bi-tags me-2 text-primary"></i>All Categories ({{ $categories->count() }})</h6>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <i class="bi bi-plus-circle me-1"></i> Add Category
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Category</th>
                        <th>Slug</th>
                        <th>Products</th>
                        <th>Icon</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="category-icon me-2" style="width: 36px; height: 36px; font-size: 1rem;">
                                        <i class="bi {{ $category->icon ?: 'bi-tag' }}"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold d-block">{{ $category->name }}</span>
                                        <small class="text-muted">{{ $category->description }}</small>
                                    </div>
                                </div>
                            </td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $category->products_count }} products</span>
                            </td>
                            <td><code>{{ $category->icon }}</code></td>
                            <td>
                                @if($category->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Disabled</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No categories created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="cat_name" class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="cat_name" class="form-control" required placeholder="e.g. Smart Watches">
                    </div>
                    <div class="mb-3">
                        <label for="cat_icon" class="form-label fw-bold">Bootstrap Icon Class</label>
                        <input type="text" name="icon" id="cat_icon" class="form-control" placeholder="bi-smartwatch" value="bi-tag">
                        <span class="form-text small">e.g. bi-laptop, bi-phone, bi-watch, bi-cart</span>
                    </div>
                    <div class="mb-3">
                        <label for="cat_desc" class="form-label fw-bold">Description</label>
                        <textarea name="description" id="cat_desc" class="form-control" rows="2" placeholder="Brief category description"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
