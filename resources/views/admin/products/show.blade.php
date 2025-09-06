@extends('admin.layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-box me-2"></i>Product Details</h5>
                    <div>
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning btn-sm me-2">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Products
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($product->image)
                                <img src="{{ asset('images/products/' . $product->image) }}" 
                                     alt="{{ $product->name }}" class="img-fluid rounded shadow-sm">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3 class="mb-3">{{ $product->name }}</h3>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Category:</strong></div>
                                <div class="col-sm-9">
                                    <a href="{{ route('admin.categories.show', $product->category) }}" class="text-decoration-none">
                                        <span class="badge bg-primary">{{ $product->category->name }}</span>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Price:</strong></div>
                                <div class="col-sm-9">
                                    <h4 class="text-success mb-0">${{ number_format($product->price, 2) }}</h4>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Slug:</strong></div>
                                <div class="col-sm-9">
                                    <code>{{ $product->slug }}</code>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Status:</strong></div>
                                <div class="col-sm-9">
                                    <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    @if($product->is_featured)
                                        <span class="badge bg-warning text-dark ms-2">
                                            <i class="fas fa-star me-1"></i>Featured
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Created:</strong></div>
                                <div class="col-sm-9">{{ $product->created_at->format('F d, Y \a\t g:i A') }}</div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-3"><strong>Updated:</strong></div>
                                <div class="col-sm-9">{{ $product->updated_at->format('F d, Y \a\t g:i A') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($product->description)
                        <hr>
                        <div class="mb-3">
                            <h6><i class="fas fa-align-left me-2"></i>Description</h6>
                            <div class="bg-light p-3 rounded">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning w-100 mb-2">
                                <i class="fas fa-edit me-1"></i>Edit Product
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.categories.show', $product->category) }}" class="btn btn-info w-100 mb-2">
                                <i class="fas fa-folder me-1"></i>View Category
                            </a>
                        </div>
                        <div class="col-md-3">
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline w-100">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100 mb-2" 
                                        onclick="return confirm('Are you sure you want to delete this product?')">
                                    <i class="fas fa-trash me-1"></i>Delete Product
                                </button>
                            </form>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success w-100 mb-2">
                                <i class="fas fa-plus me-1"></i>Add New Product
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Product Statistics -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Product Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <h2 class="text-primary">#{{ $product->id }}</h2>
                        <small class="text-muted">Product ID</small>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h5 class="text-success mb-1">${{ number_format($product->price, 2) }}</h5>
                                <small class="text-muted">Price</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h5 class="text-info mb-1">{{ $product->category->products_count ?? 0 }}</h5>
                            <small class="text-muted">Category Products</small>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Status:</span>
                        <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span>Featured:</span>
                        <span class="badge {{ $product->is_featured ? 'bg-warning text-dark' : 'bg-secondary' }}">
                            {{ $product->is_featured ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Has Image:</span>
                        <span class="badge {{ $product->image ? 'bg-success' : 'bg-secondary' }}">
                            {{ $product->image ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Category Information -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-folder me-2"></i>Category Information</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        @if($product->category->image)
                            <img src="{{ asset('image/categories/' . $product->category->image) }}" 
                                 alt="{{ $product->category->name }}" class="rounded me-3" 
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" 
                                 style="width: 50px; height: 50px;">
                                <i class="fas fa-folder text-muted"></i>
                            </div>
                        @endif
                        <div>
                            <h6 class="mb-1">{{ $product->category->name }}</h6>
                            <small class="text-muted">{{ $product->category->slug }}</small>
                        </div>
                    </div>
                    
                    @if($product->category->description)
                        <p class="text-muted small mb-3">{{ Str::limit($product->category->description, 100) }}</p>
                    @endif
                    
                    <div class="d-grid">
                        <a href="{{ route('admin.categories.show', $product->category) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-eye me-1"></i>View Category Details
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Recent Products in Same Category -->
            @if($relatedProducts->count() > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-boxes me-2"></i>Related Products</h6>
                </div>
                <div class="card-body">
                    @foreach($relatedProducts as $related)
                        <div class="d-flex align-items-center mb-2 {{ !$loop->last ? 'border-bottom pb-2' : '' }}">
                            @if($related->image)
                                <img src="{{ asset('images/products/' . $related->image) }}" 
                                     alt="{{ $related->name }}" class="rounded me-2" 
                                     style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-box text-muted"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-0 small">{{ Str::limit($related->name, 20) }}</h6>
                                <small class="text-success">${{ number_format($related->price, 2) }}</small>
                            </div>
                            <a href="{{ route('admin.products.show', $related) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection