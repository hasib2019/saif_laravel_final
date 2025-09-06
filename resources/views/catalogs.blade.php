@extends('layouts.app')

@section('title', __('messages.catalogs'))

@section('content')
<!-- Page Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold mb-3">{{ __('messages.catalogs') }}</h1>
                <p class="lead text-muted">{{ __('messages.catalog_page_subtitle') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Catalogs Section -->
<section class="py-5">
    <div class="container">
        <!-- Category Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex flex-wrap gap-2 justify-content-center">
                    <a href="{{ route('catalogs') }}" class="btn {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }}">{{ __('messages.all_categories') }}</a>
                    @foreach($categories as $category)
                        <a href="{{ route('catalogs', ['category' => $category->slug]) }}" 
                           class="btn {{ request('category') == $category->slug ? 'btn-primary' : 'btn-outline-primary' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- Products Count -->
        <div class="row mb-4">
            <div class="col-12">
                <p class="text-muted">{{ __('messages.showing_products', ['count' => $products->count(), 'total' => $products->total()]) }}
                    @if(request('category'))
                        @php
                            $currentCategory = $categories->where('slug', request('category'))->first();
                        @endphp
                        @if($currentCategory)
                            {{ __('messages.in_category', ['category' => $currentCategory->name]) }}
                        @endif
                    @endif
                </p>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="row">
            @forelse($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card product-card h-100">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/300x250/f8f9fa/6c757d?text={{ urlencode($product->name) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 250px; object-fit: cover;">
                        @endif
                        
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted flex-grow-1">{{ Str::limit($product->short_description ?? $product->description, 120) }}</p>
                            
                            @if($product->category)
                                <small class="text-muted mb-2">
                                    <i class="fas fa-tag me-1"></i>{{ $product->category->name }}
                                </small>
                            @endif
                            
                            <div class="mt-auto">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    <div class="d-flex align-items-center mb-3">
                                        <span class="h5 text-danger mb-0">${{ number_format($product->sale_price, 2) }}</span>
                                        <span class="text-muted text-decoration-line-through ms-2">${{ number_format($product->price, 2) }}</span>
                                        <span class="badge bg-danger ms-2">Sale</span>
                                    </div>
                                @else
                                    <div class="mb-3">
                                        <span class="h5 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                                    </div>
                                @endif
                                
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <small class="text-muted">SKU: {{ $product->sku }}</small>
                                    @if($product->stock_quantity > 0)
                                        <span class="badge bg-success">{{ $product->stock_quantity }} in stock</span>
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </div>
                                
                                @if($product->featured)
                                    <div class="mb-2">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star me-1"></i>{{ __('messages.featured') }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ __('messages.no_products_found') }}</h4>
                        <p class="text-muted">{{ __('messages.try_different_category') }}</p>
                        <a href="{{ route('catalogs') }}" class="btn btn-primary">{{ __('messages.view_all_products') }}</a>
                    </div>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($products->hasPages())
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.product-card {
    transition: all 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn-group .btn {
    margin: 0 2px;
}
</style>
@endpush