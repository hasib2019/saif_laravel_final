@extends('layouts.app')

@section('title', $product->name)

@section('content')
<!-- Product Detail Section -->
<section class="py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('catalogs') }}">Catalogs</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('catalogs', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Images & Media -->
            <div class="col-lg-6 mb-4">
                <div class="product-media">
                    <!-- Main Image -->
                    <div class="main-image-container mb-3">
                        @if($product->image)
                            <img id="mainImage" src="{{ asset($product->image) }}" class="img-fluid rounded shadow-lg" alt="{{ $product->name }}" style="width: 100%; height: 400px; object-fit: cover;">
                        @else
                            <img id="mainImage" src="https://via.placeholder.com/600x400/f8f9fa/6c757d?text={{ urlencode($product->name) }}" class="img-fluid rounded shadow-lg" alt="{{ $product->name }}" style="width: 100%; height: 400px; object-fit: cover;">
                        @endif
                        
                        <!-- Image Zoom Overlay -->
                        <div class="image-zoom-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>

                    <!-- Media Tabs -->
                    <div class="media-tabs">
                        <ul class="nav nav-pills justify-content-center mb-3" id="mediaTabs" role="tablist">
                            @if($product->image)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="image-tab" data-bs-toggle="pill" data-bs-target="#image-content" type="button" role="tab">
                                        <i class="fas fa-image me-1"></i>Image
                                    </button>
                                </li>
                            @endif
                            @if($product->video_file || $product->video_link)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="video-tab" data-bs-toggle="pill" data-bs-target="#video-content" type="button" role="tab">
                                        <i class="fas fa-play me-1"></i>Video
                                    </button>
                                </li>
                            @endif
                            @if($product->pdf_file)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pdf-tab" data-bs-toggle="pill" data-bs-target="#pdf-content" type="button" role="tab">
                                        <i class="fas fa-file-pdf me-1"></i>PDF
                                    </button>
                                </li>
                            @endif
                        </ul>

                        <div class="tab-content" id="mediaTabContent">
                            <!-- Image Content -->
                            @if($product->image)
                                <div class="tab-pane fade show active" id="image-content" role="tabpanel">
                                    <div class="text-center">
                                        <img src="{{ asset($product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}" style="max-height: 300px;">
                                    </div>
                                </div>
                            @endif

                            <!-- Video Content -->
                            @if($product->video_file || $product->video_link)
                                <div class="tab-pane fade" id="video-content" role="tabpanel">
                                    <div class="video-container">
                                        @if($product->video_file)
                                            <video controls class="w-100 rounded" style="max-height: 300px;">
                                                <source src="{{ asset('videos/products/' . $product->video_file) }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @elseif($product->video_link)
                                            <div class="embed-responsive embed-responsive-16by9">
                                                @php
                                                    $videoId = '';
                                                    if (strpos($product->video_link, 'youtube.com') !== false || strpos($product->video_link, 'youtu.be') !== false) {
                                                        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $product->video_link, $matches);
                                                        $videoId = $matches[1] ?? '';
                                                        $embedUrl = "https://www.youtube.com/embed/{$videoId}";
                                                    } elseif (strpos($product->video_link, 'vimeo.com') !== false) {
                                                        preg_match('/vimeo\.com\/(\d+)/', $product->video_link, $matches);
                                                        $videoId = $matches[1] ?? '';
                                                        $embedUrl = "https://player.vimeo.com/video/{$videoId}";
                                                    } else {
                                                        $embedUrl = $product->video_link;
                                                    }
                                                @endphp
                                                <iframe src="{{ $embedUrl }}" class="w-100 rounded" height="300" frameborder="0" allowfullscreen></iframe>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <!-- PDF Content -->
                            @if($product->pdf_file)
                                <div class="tab-pane fade" id="pdf-content" role="tabpanel">
                                    <div class="pdf-viewer text-center">
                                        <div class="mb-3">
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                            <h5>Product Documentation</h5>
                                            <p class="text-muted">{{ $product->pdf_file }}</p>
                                        </div>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ asset('files/products/' . $product->pdf_file) }}" target="_blank" class="btn btn-danger">
                                                <i class="fas fa-eye me-1"></i>View PDF
                                            </a>
                                            <a href="{{ asset('files/products/' . $product->pdf_file) }}" download class="btn btn-outline-danger">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="col-lg-6">
                <div class="product-info">
                    <!-- Product Title & Category -->
                    <div class="mb-3">
                        @if($product->category)
                            <span class="badge bg-primary mb-2">{{ $product->category->name }}</span>
                        @endif
                        <h1 class="display-5 fw-bold mb-2">{{ $product->name }}</h1>
                        @if($product->featured)
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i>Featured Product
                            </span>
                        @endif
                    </div>

                    <!-- Pricing -->
                    <div class="pricing mb-4">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <div class="d-flex align-items-center mb-2">
                                <span class="h2 text-danger mb-0 me-3">${{ number_format($product->sale_price, 2) }}</span>
                                <span class="h4 text-muted text-decoration-line-through mb-0">${{ number_format($product->price, 2) }}</span>
                                <span class="badge bg-danger ms-3 fs-6">
                                    {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}% OFF
                                </span>
                            </div>
                        @else
                            <div class="mb-2">
                                <span class="h2 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                            </div>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="product-details mb-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="detail-item">
                                    <strong>SKU:</strong>
                                    <span class="text-muted">{{ $product->sku ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="detail-item">
                                    <strong>Stock:</strong>
                                    @if($product->stock_quantity > 0)
                                        <span class="badge bg-success">{{ $product->stock_quantity }} in stock</span>
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Short Description -->
                    @if($product->short_description)
                        <div class="short-description mb-4">
                            <h5>Quick Overview</h5>
                            <p class="lead">{{ $product->short_description }}</p>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="action-buttons mb-4">
                        <div class="d-grid gap-2 d-md-flex">
                            @if($product->stock_quantity > 0)
                                <a href="{{ route('order.create', $product->slug) }}" class="btn btn-primary btn-lg flex-fill">
                                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                </a>
                            @else
                                <button class="btn btn-primary btn-lg flex-fill" disabled>
                                    <i class="fas fa-shopping-cart me-2"></i>Out of Stock
                                </button>
                            @endif
                            <button class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-heart"></i>
                            </button>
                            <button class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-share-alt"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Additional Info -->
                    <div class="additional-info">
                        <div class="row g-3">
                            @if($product->pdf_file)
                                <div class="col-12">
                                    <div class="info-card p-3 bg-light rounded">
                                        <i class="fas fa-file-pdf text-danger me-2"></i>
                                        <strong>Documentation Available</strong>
                                        <p class="mb-0 text-muted small">Detailed product information and specifications</p>
                                    </div>
                                </div>
                            @endif
                            @if($product->video_file || $product->video_link)
                                <div class="col-12">
                                    <div class="info-card p-3 bg-light rounded">
                                        <i class="fas fa-play text-primary me-2"></i>
                                        <strong>Video Content Available</strong>
                                        <p class="mb-0 text-muted small">Watch product demonstration and features</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        @if($product->description)
            <div class="row mt-5">
                <div class="col-12">
                    <div class="product-description">
                        <h3 class="mb-4">Product Description</h3>
                        <div class="description-content">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="mb-4">Related Products</h3>
                    <div class="row">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="col-lg-3 col-md-6 mb-4">
                                <div class="card product-card h-100">
                                    <a href="{{ route('product.show', $relatedProduct->slug) }}">
                                        @if($relatedProduct->image)
                                            <img src="{{ asset($relatedProduct->image) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: cover;">
                                        @else
                                            <img src="https://via.placeholder.com/300x200/f8f9fa/6c757d?text={{ urlencode($relatedProduct->name) }}" class="card-img-top" alt="{{ $relatedProduct->name }}" style="height: 200px; object-fit: cover;">
                                        @endif
                                    </a>
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <a href="{{ route('product.show', $relatedProduct->slug) }}" class="text-decoration-none">
                                                {{ $relatedProduct->name }}
                                            </a>
                                        </h6>
                                        <p class="card-text text-muted small">{{ Str::limit($relatedProduct->short_description, 80) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if($relatedProduct->sale_price && $relatedProduct->sale_price < $relatedProduct->price)
                                                <span class="text-danger fw-bold">${{ number_format($relatedProduct->sale_price, 2) }}</span>
                                            @else
                                                <span class="text-primary fw-bold">${{ number_format($relatedProduct->price, 2) }}</span>
                                            @endif
                                            <a href="{{ route('product.show', $relatedProduct->slug) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.product-media {
    position: relative;
}

.main-image-container {
    position: relative;
    overflow: hidden;
    border-radius: 0.5rem;
}

.main-image-container:hover .image-zoom-overlay {
    opacity: 1;
}

.image-zoom-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;
}

.image-zoom-overlay i {
    color: white;
    font-size: 2rem;
}

.product-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.detail-item {
    padding: 0.5rem 0;
}

.info-card {
    border-left: 4px solid #007bff;
}

.pricing {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    padding: 1.5rem;
    border-radius: 0.5rem;
    border: 1px solid #dee2e6;
}

.description-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #495057;
}

.media-tabs .nav-pills .nav-link {
    border-radius: 50px;
    margin: 0 0.25rem;
}

.media-tabs .nav-pills .nav-link.active {
    background-color: #007bff;
}

.video-container, .pdf-viewer {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
}

@media (max-width: 768px) {
    .display-5 {
        font-size: 1.8rem;
    }
    
    .action-buttons .d-md-flex {
        flex-direction: column;
    }
    
    .action-buttons .btn {
        margin-bottom: 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image zoom functionality
    const mainImage = document.getElementById('mainImage');
    const zoomOverlay = document.querySelector('.image-zoom-overlay');
    
    if (zoomOverlay) {
        zoomOverlay.addEventListener('click', function() {
            // Create modal for image zoom
            const modal = document.createElement('div');
            modal.className = 'modal fade';
            modal.innerHTML = `
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ $product->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="${mainImage.src}" class="img-fluid" alt="{{ $product->name }}">
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
            
            modal.addEventListener('hidden.bs.modal', function() {
                document.body.removeChild(modal);
            });
        });
    }
    
    // Share functionality
    const shareBtn = document.querySelector('.btn-outline-secondary:last-child');
    if (shareBtn) {
        shareBtn.addEventListener('click', function() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $product->name }}',
                    text: '{{ $product->short_description ?? "Check out this amazing product!" }}',
                    url: window.location.href
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(window.location.href).then(function() {
                    alert('Product link copied to clipboard!');
                });
            }
        });
    }
});
</script>
@endpush