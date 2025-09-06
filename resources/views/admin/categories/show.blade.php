@extends('admin.layouts.app')

@section('title', 'Category Details')
@section('page-title', 'Category: ' . $category->name)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Category Information -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Category Information
                </h5>
                <div>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit me-1"></i>
                        Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    @if($category->image)
                        <div class="col-md-4 mb-3">
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" 
                                 class="img-fluid rounded shadow-sm">
                        </div>
                        <div class="col-md-8">
                    @else
                        <div class="col-md-12">
                    @endif
                        <table class="table table-borderless">
                            <tr>
                                <td width="150"><strong>Name:</strong></td>
                                <td>{{ $category->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Slug:</strong></td>
                                <td><code>{{ $category->slug }}</code></td>
                            </tr>
                            <tr>
                                <td><strong>Status:</strong></td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-secondary">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Products:</strong></td>
                                <td>
                                    <span class="badge bg-info">{{ $category->products()->count() }} products</span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Created:</strong></td>
                                <td>{{ $category->created_at->format('M d, Y \a\t h:i A') }}</td>
                            </tr>
                            @if($category->updated_at != $category->created_at)
                                <tr>
                                    <td><strong>Updated:</strong></td>
                                    <td>{{ $category->updated_at->format('M d, Y \a\t h:i A') }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
                
                @if($category->description)
                    <hr>
                    <div>
                        <h6>Description:</h6>
                        <p class="text-muted">{{ $category->description }}</p>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Associated Products -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-box me-2"></i>
                    Products in this Category
                    <span class="badge bg-primary ms-2">{{ $category->products()->count() }}</span>
                </h5>
                @if($category->products()->count() > 0)
                    <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="btn btn-sm btn-outline-primary">
                        View All Products
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($category->products->count() > 0)
                    <div class="row">
                        @foreach($category->products as $product)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100">
                                    @if($product->image)
                                        <img src="{{ asset($product->image) }}" class="card-img-top" 
                                             alt="{{ $product->name }}" style="height: 150px; object-fit: cover;">
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                             style="height: 150px;">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="card-body d-flex flex-column">
                                        <h6 class="card-title">{{ $product->name }}</h6>
                                        <p class="card-text text-muted small flex-grow-1">
                                            {{ Str::limit($product->description, 80) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center mt-auto">
                                            <span class="fw-bold text-primary">${{ number_format($product->price, 2) }}</span>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.products.show', $product) }}" 
                                                   class="btn btn-sm btn-outline-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.products.edit', $product) }}" 
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="mt-2">
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
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($category->products()->count() > $category->products->count())
                        <div class="text-center mt-3">
                            <p class="text-muted">Showing {{ $category->products->count() }} of {{ $category->products()->count() }} products</p>
                            <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="btn btn-outline-primary">
                                View All {{ $category->products()->count() }} Products
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-box fa-4x text-muted mb-4"></i>
                        <h6 class="text-muted mb-3">No Products in this Category</h6>
                        <p class="text-muted mb-4">Start by adding products to this category.</p>
                        <a href="{{ route('admin.products.create', ['category' => $category->id]) }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Add First Product
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>
                        Edit Category
                    </a>
                    <a href="{{ route('admin.products.create', ['category' => $category->id]) }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>
                        Add Product
                    </a>
                    @if($category->products()->count() > 0)
                        <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="btn btn-info">
                            <i class="fas fa-list me-2"></i>
                            View All Products
                        </a>
                    @endif
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Back to Categories
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Category Statistics -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Statistics
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h3 class="text-primary mb-1">{{ $category->products()->count() }}</h3>
                            <small class="text-muted">Total Products</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h3 class="text-success mb-1">{{ $category->products()->where('is_active', true)->count() }}</h3>
                        <small class="text-muted">Active Products</small>
                    </div>
                </div>
                
                <hr>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h3 class="text-warning mb-1">{{ $category->products()->where('featured', true)->count() }}</h3>
                            <small class="text-muted">Featured</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h3 class="text-info mb-1">${{ number_format($category->products()->avg('price') ?? 0, 2) }}</h3>
                        <small class="text-muted">Avg. Price</small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Category Status -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Category Status
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span>Visibility:</span>
                    @if($category->is_active)
                        <span class="badge bg-success">Visible on Website</span>
                    @else
                        <span class="badge bg-secondary">Hidden from Website</span>
                    @endif
                </div>
                
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span>Products:</span>
                    @if($category->products()->count() > 0)
                        <span class="badge bg-info">{{ $category->products()->count() }} Products</span>
                    @else
                        <span class="badge bg-warning text-dark">No Products</span>
                    @endif
                </div>
                
                <div class="d-flex align-items-center justify-content-between">
                    <span>Created:</span>
                    <small class="text-muted">{{ $category->created_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection