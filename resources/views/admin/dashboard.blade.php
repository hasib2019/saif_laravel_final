@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row mb-4">
    <!-- Statistics Cards -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%)">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Total Categories</div>
                    <div class="h4 mb-0">{{ $categoriesCount ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%)">
                    <i class="fas fa-box"></i>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Total Products</div>
                    <div class="h4 mb-0">{{ $productsCount ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%)">
                    <i class="fas fa-file-alt"></i>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Total Pages</div>
                    <div class="h4 mb-0">{{ $pagesCount ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%)">
                    <i class="fas fa-star"></i>
                </div>
                <div class="ms-3">
                    <div class="text-muted small">Featured Products</div>
                    <div class="h4 mb-0">{{ $featuredProductsCount ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Quick Actions -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            Add Category
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            Add Product
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('admin.pages.create') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            Add Page
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-success w-100">
                            <i class="fas fa-external-link-alt me-2"></i>
                            View Website
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Products -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Recent Products
                </h5>
                <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-light">
                    View All
                </a>
            </div>
            <div class="card-body">
                @if(isset($recentProducts) && $recentProducts->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentProducts as $product)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                    <small class="text-muted">{{ $product->category->name ?? 'No Category' }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold">${{ number_format($product->price, 2) }}</div>
                                    <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-box fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No products found. <a href="{{ route('admin.products.create') }}">Create your first product</a></p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- System Information -->
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    System Information
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Laravel Version:</strong></td>
                                <td>{{ app()->version() }}</td>
                            </tr>
                            <tr>
                                <td><strong>PHP Version:</strong></td>
                                <td>{{ PHP_VERSION }}</td>
                            </tr>
                            <tr>
                                <td><strong>Environment:</strong></td>
                                <td>
                                    <span class="badge bg-{{ app()->environment('production') ? 'success' : 'warning' }}">
                                        {{ ucfirst(app()->environment()) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Database:</strong></td>
                                <td>{{ config('database.default') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Cache Driver:</strong></td>
                                <td>{{ config('cache.default') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Session Driver:</strong></td>
                                <td>{{ config('session.driver') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-history me-2"></i>
                    Recent Activity
                </h5>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-primary"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Admin Dashboard</h6>
                            <small class="text-muted">System initialized successfully</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Database Connected</h6>
                            <small class="text-muted">MySQL connection established</small>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-marker bg-info"></div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Ready to Use</h6>
                            <small class="text-muted">Start managing your content</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 17px;
    width: 2px;
    height: calc(100% + 8px);
    background-color: #e9ecef;
}
</style>
@endpush