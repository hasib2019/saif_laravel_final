@extends('layouts.app')

@section('title', $supplier->name)

@section('meta')
<meta name="description" content="{{ $supplier->short_description ?: 'Learn more about ' . $supplier->name . ', one of our trusted supplier partners.' }}">
<meta name="keywords" content="supplier, partner, {{ $supplier->name }}">

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="{{ $supplier->name }}">
<meta property="og:description" content="{{ $supplier->short_description ?: 'Learn more about ' . $supplier->name . ', one of our trusted supplier partners.' }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ route('suppliers.show', $supplier->slug) }}">
@if($supplier->images && is_array($supplier->images) && count($supplier->images) > 0)
<meta property="og:image" content="{{ asset('storage/' . $supplier->images[0]) }}">
@endif

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $supplier->name }}">
<meta name="twitter:description" content="{{ $supplier->short_description ?: 'Learn more about ' . $supplier->name . ', one of our trusted supplier partners.' }}">
@if($supplier->images && is_array($supplier->images) && count($supplier->images) > 0)
<meta name="twitter:image" content="{{ asset('storage/' . $supplier->images[0]) }}">
@endif
@endsection

@section('content')
<div class="supplier-detail-page">
    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('suppliers.index') }}">Suppliers</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($supplier->name, 50) }}</li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="row">
            <!-- Main Supplier Content -->
            <div class="col-lg-8">
                <!-- Supplier Header -->
                <div class="supplier-header mb-5">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="display-5 fw-bold text-primary mb-3">{{ $supplier->name }}</h1>
                            @if($supplier->short_description)
                                <p class="lead text-muted mb-3">{{ $supplier->short_description }}</p>
                            @endif
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge bg-success px-3 py-2">
                                    <i class="fas fa-check-circle me-1"></i>Verified Supplier
                                </span>
                                <div class="text-muted small">
                                    <i class="fas fa-calendar me-1"></i>
                                    Partner since {{ $supplier->created_at->format('Y') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            @if($supplier->images && is_array($supplier->images) && count($supplier->images) > 0)
                                <img src="{{ asset('storage/' . $supplier->images[0]) }}" 
                                     alt="{{ $supplier->name }}" 
                                     class="img-fluid rounded-circle supplier-logo shadow"
                                     style="width: 150px; height: 150px; object-fit: cover;">
                            @else
                                <div class="supplier-logo-placeholder rounded-circle shadow d-flex align-items-center justify-content-center mx-auto"
                                     style="width: 150px; height: 150px; background: #f8f9fa;">
                                    <i class="fas fa-industry fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Supplier Images Gallery -->
                @if($supplier->images && is_array($supplier->images) && count($supplier->images) > 0)
                    <div class="supplier-gallery mb-5">
                        <h3 class="section-title mb-4">Gallery</h3>
                        <div class="row g-3">
                            @foreach($supplier->images as $index => $image)
                                <div class="col-md-4 col-sm-6">
                                    <div class="gallery-item">
                                        <img src="{{ asset('storage/' . $image) }}" 
                                             alt="{{ $supplier->name }} - Image {{ $index + 1 }}" 
                                             class="img-fluid rounded shadow-sm gallery-image"
                                             data-bs-toggle="modal" 
                                             data-bs-target="#imageModal"
                                             data-image="{{ asset('storage/' . $image) }}"
                                             style="cursor: pointer; height: 200px; width: 100%; object-fit: cover;">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Supplier Description -->
                @if($supplier->description)
                    <div class="supplier-description mb-5">
                        <h3 class="section-title mb-4">About {{ $supplier->name }}</h3>
                        <div class="content-text">
                            {!! nl2br(e($supplier->description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Media Section -->
                <div class="supplier-media mb-5">
                    <h3 class="section-title mb-4">Media & Resources</h3>
                    <div class="row g-4">
                        @if($supplier->pdf_file)
                            <div class="col-md-6">
                                <div class="media-card card h-100">
                                    <div class="card-body text-center">
                                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                        <h5 class="card-title">Company Brochure</h5>
                                        <p class="card-text text-muted">Download detailed information about {{ $supplier->name }}</p>
                                        <a href="{{ asset('storage/' . $supplier->pdf_file) }}" 
                                           target="_blank" 
                                           class="btn btn-outline-danger">
                                            <i class="fas fa-download me-1"></i>Download PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($supplier->video_file)
                            <div class="col-md-6">
                                <div class="media-card card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title text-center mb-3">
                                            <i class="fas fa-video text-primary me-2"></i>Company Video
                                        </h5>
                                        <video controls class="w-100 rounded" style="max-height: 200px;">
                                            <source src="{{ asset('storage/' . $supplier->video_file) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if($supplier->youtube_link)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="media-card card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center mb-3">
                                            <i class="fab fa-youtube text-danger me-2"></i>Featured Video
                                        </h5>
                                        @php
                                            $youtube_id = '';
                                            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $supplier->youtube_link, $matches)) {
                                                $youtube_id = $matches[1];
                                            }
                                        @endphp
                                        
                                        @if($youtube_id)
                                            <div class="ratio ratio-16x9">
                                                <iframe src="https://www.youtube.com/embed/{{ $youtube_id }}" 
                                                        title="YouTube video player" 
                                                        frameborder="0" 
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                        allowfullscreen
                                                        class="rounded">
                                                </iframe>
                                            </div>
                                        @else
                                            <div class="text-center py-4">
                                                <a href="{{ $supplier->youtube_link }}" target="_blank" class="btn btn-outline-danger">
                                                    <i class="fab fa-youtube me-1"></i>Watch on YouTube
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Navigation -->
                <div class="supplier-navigation mb-5">
                    <div class="row">
                        <div class="col-6">
                            @if($previousSupplier)
                                <a href="{{ route('suppliers.show', $previousSupplier->slug) }}" 
                                   class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-arrow-left me-1"></i>
                                    <div class="d-block">
                                        <small>Previous</small><br>
                                        <strong>{{ Str::limit($previousSupplier->name, 20) }}</strong>
                                    </div>
                                </a>
                            @endif
                        </div>
                        <div class="col-6">
                            @if($nextSupplier)
                                <a href="{{ route('suppliers.show', $nextSupplier->slug) }}" 
                                   class="btn btn-outline-secondary w-100 text-end">
                                    <div class="d-block">
                                        <small>Next</small><br>
                                        <strong>{{ Str::limit($nextSupplier->name, 20) }}</strong>
                                    </div>
                                    <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-tools me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-1"></i>All Suppliers
                            </a>
                            <a href="{{ route('contact') }}" class="btn btn-primary">
                                <i class="fas fa-envelope me-1"></i>Contact Us
                            </a>
                            @if($supplier->pdf_file)
                                <a href="{{ asset('storage/' . $supplier->pdf_file) }}" 
                                   target="_blank" 
                                   class="btn btn-outline-danger">
                                    <i class="fas fa-download me-1"></i>Download Brochure
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Supplier Stats -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Supplier Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="border-end">
                                    <h4 class="text-primary">{{ $supplier->images && is_array($supplier->images) ? count($supplier->images) : 0 }}</h4>
                                    <small class="text-muted">Images</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <h4 class="text-info">{{ $supplier->created_at->format('Y') }}</h4>
                                <small class="text-muted">Partner Since</small>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row text-center">
                            <div class="col-4">
                                <i class="fas fa-file-pdf fa-2x {{ $supplier->pdf_file ? 'text-success' : 'text-muted' }}"></i>
                                <br><small>PDF</small>
                            </div>
                            <div class="col-4">
                                <i class="fas fa-video fa-2x {{ $supplier->video_file ? 'text-success' : 'text-muted' }}"></i>
                                <br><small>Video</small>
                            </div>
                            <div class="col-4">
                                <i class="fab fa-youtube fa-2x {{ $supplier->youtube_link ? 'text-success' : 'text-muted' }}"></i>
                                <br><small>YouTube</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Suppliers -->
                @if($relatedSuppliers->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fas fa-handshake me-2"></i>Other Suppliers</h5>
                        </div>
                        <div class="card-body">
                            @foreach($relatedSuppliers->take(4) as $related)
                                <div class="d-flex align-items-center mb-3">
                                    @if($related->images && count($related->images) > 0)
                                        <img src="{{ asset('storage/' . $related->images[0]) }}" 
                                             alt="{{ $related->name }}" 
                                             class="rounded me-3"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-industry text-muted"></i>
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">
                                            <a href="{{ route('suppliers.show', $related->slug) }}" 
                                               class="text-decoration-none">
                                                {{ Str::limit($related->name, 25) }}
                                            </a>
                                        </h6>
                                        @if($related->short_description)
                                            <small class="text-muted">{{ Str::limit($related->short_description, 40) }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            
                            <div class="text-center mt-3">
                                <a href="{{ route('suppliers.index') }}" class="btn btn-sm btn-outline-primary">
                                    View All Suppliers
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">{{ $supplier->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<style>
    .supplier-detail-page .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 1rem;
        color: #333;
    }
    
    .supplier-detail-page .section-title::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #667eea;
    }
    
    .gallery-image:hover {
        transform: scale(1.05);
        transition: transform 0.3s ease;
    }
    
    .media-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .media-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    
    .content-text {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #555;
    }
    
    .supplier-navigation .btn {
        min-height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    @media (max-width: 768px) {
        .supplier-header .display-5 {
            font-size: 2rem;
        }
        
        .supplier-logo {
            width: 100px !important;
            height: 100px !important;
        }
        
        .supplier-logo-placeholder {
            width: 100px !important;
            height: 100px !important;
        }
    }
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image modal functionality
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    
    document.querySelectorAll('.gallery-image').forEach(img => {
        img.addEventListener('click', function() {
            const imageSrc = this.getAttribute('data-image');
            modalImage.src = imageSrc;
            modalImage.alt = this.alt;
        });
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
    
    // Add loading state to navigation buttons
    document.querySelectorAll('.supplier-navigation .btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon) {
                icon.className = icon.className.replace('fa-arrow-', 'fa-spinner fa-spin');
            }
        });
    });
});
</script>
@endsection