@extends('layouts.app')

@section('title', 'Our Suppliers')

@section('content')
    <div class="suppliers-page">
        <!-- Hero Section -->
        <section class="hero-section bg-primary text-white py-5 mb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="display-4 fw-bold mb-3">Our Trusted Suppliers</h1>
                        <p class="lead mb-4">Discover our network of reliable partners who help us deliver quality products and services to our customers worldwide.</p>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-handshake fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-0">Trusted Partners</h6>
                                    <small class="opacity-75">Quality Assured</small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-globe fa-2x me-3"></i>
                                <div>
                                    <h6 class="mb-0">Global Network</h6>
                                    <small class="opacity-75">Worldwide Reach</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <i class="fas fa-industry fa-5x opacity-50"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Search and Filter Section -->
        <section class="search-section mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <form method="GET" action="{{ route('suppliers.index') }}" class="row g-3">
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" 
                                                   name="search" value="{{ request('search') }}" 
                                                   placeholder="Search suppliers by name or description...">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-primary btn-lg w-100">
                                            <i class="fas fa-search me-1"></i>Search
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Suppliers Section -->
        @if ($featuredSuppliers->count() > 0 && !request('search'))
            <section class="featured-suppliers mb-5">
                <div class="container">
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <h2 class="section-title">Featured Suppliers</h2>
                            <p class="text-muted">Our top-rated and most trusted supplier partners</p>
                        </div>
                    </div>
                    <div class="row g-4">
                        @foreach ($featuredSuppliers->take(6) as $supplier)
                            <div class="col-lg-4 col-md-6">
                                <div class="supplier-card featured-card h-100">
                                    <div class="card shadow-sm h-100">
                                        <div class="position-relative">
                                            @if ($supplier->images && is_array($supplier->images) && count($supplier->images) > 0)
                                                <img src="{{ asset('storage/' . $supplier->images[0]) }}" 
                                                     alt="{{ $supplier->name }}" 
                                                     class="card-img-top supplier-image">
                                            @else
                                                <div class="card-img-top supplier-placeholder d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-industry fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="position-absolute top-0 end-0 m-2">
                                                <span class="badge bg-warning text-dark">Featured</span>
                                            </div>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $supplier->name }}</h5>
                                            @if ($supplier->short_description)
                                                <p class="card-text text-muted flex-grow-1">
                                                    {{ Str::limit($supplier->short_description, 120) }}
                                                </p>
                                            @endif
                                            <div class="mt-auto">
                                                <a href="{{ route('suppliers.show', $supplier->slug) }}" 
                                                   class="btn btn-primary w-100">
                                                    <i class="fas fa-eye me-1"></i>View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- All Suppliers Section -->
        <section class="all-suppliers">
            <div class="container">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h2 class="section-title">
                            @if (request('search'))
                                Search Results for "{{ request('search') }}"
                            @else
                                All Suppliers
                            @endif
                        </h2>
                        <p class="text-muted">
                            @if ($suppliers->total() > 0)
                                Showing {{ $suppliers->firstItem() }} to {{ $suppliers->lastItem() }} of {{ $suppliers->total() }} suppliers
                            @else
                                No suppliers found
                            @endif
                        </p>
                    </div>
                    <div class="col-md-4 text-end">
                        @if (request('search'))
                            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i>Clear Search
                            </a>
                        @endif
                    </div>
                </div>

                @if ($suppliers->count() > 0)
                    <div class="row g-4" id="suppliers-grid">
                        @foreach ($suppliers as $supplier)
                            <div class="col-lg-4 col-md-6">
                                <div class="supplier-card">
                                    <div class="card shadow-sm h-100 supplier-item">
                                        <div class="position-relative">
                                            @if ($supplier->images && is_array($supplier->images) && count($supplier->images) > 0)
                                                <img src="{{ asset('storage/' . $supplier->images[0]) }}" 
                                                     alt="{{ $supplier->name }}" 
                                                     class="card-img-top supplier-image">
                                            @else
                                                <div class="card-img-top supplier-placeholder d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-industry fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                            @if ($supplier->images && is_array($supplier->images) && count($supplier->images) > 1)
                                                <div class="position-absolute bottom-0 end-0 m-2">
                                                    <span class="badge bg-dark bg-opacity-75">
                                                        <i class="fas fa-images me-1"></i>{{ is_array($supplier->images) ? count($supplier->images) : 0 }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <h5 class="card-title">{{ $supplier->name }}</h5>
                                            @if ($supplier->short_description)
                                                <p class="card-text text-muted flex-grow-1">
                                                    {{ Str::limit($supplier->short_description, 120) }}
                                                </p>
                                            @endif
                                            
                                            <!-- Media indicators -->
                                            <div class="media-indicators mb-3">
                                                @if ($supplier->pdf_file)
                                                    <span class="badge bg-danger me-1" title="PDF Available">
                                                        <i class="fas fa-file-pdf"></i>
                                                    </span>
                                                @endif
                                                @if ($supplier->video_file)
                                                    <span class="badge bg-info me-1" title="Video Available">
                                                        <i class="fas fa-video"></i>
                                                    </span>
                                                @endif
                                                @if ($supplier->youtube_link)
                                                    <span class="badge bg-danger me-1" title="YouTube Video">
                                                        <i class="fab fa-youtube"></i>
                                                    </span>
                                                @endif
                                            </div>
                                            
                                            <div class="mt-auto">
                                                <a href="{{ route('suppliers.show', $supplier->slug) }}" 
                                                   class="btn btn-outline-primary w-100">
                                                    <i class="fas fa-eye me-1"></i>View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                {{ $suppliers->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <!-- No Results -->
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-search fa-5x text-muted mb-4"></i>
                                <h3 class="text-muted">No Suppliers Found</h3>
                                <p class="text-muted mb-4">
                                    @if (request('search'))
                                        We couldn't find any suppliers matching your search criteria.
                                    @else
                                        There are no suppliers available at the moment.
                                    @endif
                                </p>
                                @if (request('search'))
                                    <a href="{{ route('suppliers.index') }}" class="btn btn-primary">
                                        <i class="fas fa-list me-1"></i>View All Suppliers
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <style>
        .suppliers-page .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .supplier-image {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .supplier-placeholder {
            height: 200px;
            background: #f8f9fa;
        }
        
        .supplier-card:hover .supplier-image {
            transform: scale(1.05);
        }
        
        .supplier-card .card {
            transition: all 0.3s ease;
            border: none;
        }
        
        .supplier-card:hover .card {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }
        
        .featured-card .card {
            border: 2px solid #ffc107;
        }
        
        .section-title {
            position: relative;
            display: inline-block;
            margin-bottom: 1rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 50px;
            height: 3px;
            background: #667eea;
        }
        
        .media-indicators .badge {
            font-size: 0.7rem;
        }
        
        .search-section .card {
            border: none;
            border-radius: 15px;
        }
        
        .input-group-text {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        
        @media (max-width: 768px) {
            .hero-section .display-4 {
                font-size: 2rem;
            }
            
            .supplier-card {
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search form enhancement
    const searchForm = document.querySelector('form[action="{{ route('suppliers.index') }}"]');
    const searchInput = searchForm.querySelector('input[name="search"]');
    
    // Auto-submit on Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            searchForm.submit();
        }
    });
    
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add loading state to view details buttons
    document.querySelectorAll('.btn[href*="suppliers"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-spinner fa-spin me-1';
            }
        });
    });
});
</script>
@endsection