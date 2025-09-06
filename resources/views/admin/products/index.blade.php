@extends('admin.layouts.app')

@section('title', 'Products')
@section('page-title', 'Products Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">All Products</h4>
        <p class="text-muted mb-0">Manage your product inventory</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Add New Product
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Search Products</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Search by name, description, or SKU...">
            </div>
            <div class="col-md-3">
                <label for="category" class="form-label">Filter by Category</label>
                <select class="form-select" id="category" name="category">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" 
                                {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-outline-primary me-2">
                    <i class="fas fa-search me-1"></i>
                    Filter
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-times me-1"></i>
                    Clear
                </a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($products->count() > 0)
            <div class="row">
                
                @foreach($products as $product)

                    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 product-card">

                            @if($product->image)
                                <img src="{{ asset($product->image) }}" class="card-img-top" 
                                     alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                     style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">{{ $product->name }}</h6>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" 
                                                data-bs-toggle="dropdown">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.products.show', $product) }}">
                                                    <i class="fas fa-eye me-2"></i>View
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('admin.products.edit', $product) }}">
                                                    <i class="fas fa-edit me-2"></i>Edit
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button class="dropdown-item text-danger" 
                                                        onclick="deleteProduct({{ $product->id }})">
                                                    <i class="fas fa-trash me-2"></i>Delete
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                
                                @if($product->sku)
                                    <small class="text-muted mb-2">SKU: {{ $product->sku }}</small>
                                @endif
                                
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($product->description, 80) }}
                                </p>
                                
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="fw-bold text-primary h5 mb-0">${{ number_format($product->price, 2) }}</span>
                                        @if($product->stock_quantity !== null)
                                            <small class="text-muted">Stock: {{ $product->stock_quantity }}</small>
                                        @endif
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            @if($product->category)
                                                <span class="badge bg-info">{{ $product->category->name }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            @if($product->is_featured)
                                                <span class="badge bg-warning text-dark">Featured</span>
                                            @endif
                                            @if($product->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="mt-2">
                                        <small class="text-muted">Created {{ $product->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <p class="text-muted mb-0">
                        Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} 
                        of {{ $products->total() }} results
                    </p>
                </div>
                <div>
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                @if(request('search') || request('category'))
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h5 class="text-muted mb-3">No Products Found</h5>
                    <p class="text-muted mb-4">No products match your current filters.</p>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary me-2">
                        <i class="fas fa-times me-2"></i>
                        Clear Filters
                    </a>
                @else
                    <i class="fas fa-box fa-4x text-muted mb-4"></i>
                    <h5 class="text-muted mb-3">No Products Found</h5>
                    <p class="text-muted mb-4">Start by creating your first product.</p>
                @endif
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Create First Product
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product?</p>
                <p class="text-danger"><small><i class="fas fa-exclamation-triangle me-1"></i>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.product-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
</style>
@endpush

@push('scripts')
<script>
function deleteProduct(productId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/products/${productId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endpush