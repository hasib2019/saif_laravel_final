@extends('layouts.app')

@section('title', 'Gallery')

@section('content')
<div class="container my-5">
    <!-- Page Header -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h1 class="display-4 mb-3">Gallery</h1>
            <p class="lead text-muted">Explore our collection of images</p>
            <div class="border-bottom border-primary mx-auto" style="width: 100px; height: 3px;"></div>
        </div>
    </div>

    @if($galleries->count() > 0)
        <!-- Gallery Grid -->
        <div class="row g-4" id="gallery-grid">
            @foreach($galleries as $gallery)
                <div class="col-lg-4 col-md-6 col-sm-12 gallery-item" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card gallery-card h-100 shadow-sm">
                        <div class="gallery-image-container position-relative overflow-hidden">
                            @if($gallery->image_path)
                                <img src="{{ asset($gallery->image_path) }}" 
                                     alt="{{ $gallery->title }}" 
                                     class="card-img-top gallery-image" 
                                     data-bs-toggle="modal" 
                                     data-bs-target="#imageModal" 
                                     data-image="{{ asset($gallery->image_path) }}" 
                                     data-title="{{ $gallery->title }}" 
                                     data-description="{{ $gallery->description }}">
                                <div class="gallery-overlay">
                                    <div class="gallery-overlay-content">
                                        <i class="fas fa-search-plus fa-2x"></i>
                                        <p class="mt-2 mb-0">View Image</p>
                                    </div>
                                </div>
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $gallery->title }}</h5>
                            @if($gallery->description)
                                <p class="card-text text-muted">{{ Str::limit($gallery->description, 100) }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="row">
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-images fa-5x text-muted mb-4"></i>
                    <h3 class="text-muted mb-3">No Images Available</h3>
                    <p class="text-muted">Our gallery is currently empty. Please check back later for new images.</p>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-fluid mb-3">
                <p id="modalDescription" class="text-muted"></p>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: none;
}

.gallery-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
}

.gallery-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
    cursor: pointer;
}

.gallery-image:hover {
    transform: scale(1.05);
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;
}

.gallery-image-container:hover .gallery-overlay {
    opacity: 1;
}

.gallery-overlay-content {
    text-align: center;
    color: white;
}

.gallery-item {
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .gallery-image-container {
        height: 200px;
    }
    
    .display-4 {
        font-size: 2.5rem;
    }
}
</style>

<script>
// Handle modal image display
document.addEventListener('DOMContentLoaded', function() {
    const imageModal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalTitle = document.getElementById('imageModalLabel');
    const modalDescription = document.getElementById('modalDescription');
    
    imageModal.addEventListener('show.bs.modal', function(event) {
        const trigger = event.relatedTarget;
        const imageSrc = trigger.getAttribute('data-image');
        const imageTitle = trigger.getAttribute('data-title');
        const imageDescription = trigger.getAttribute('data-description');
        
        modalImage.src = imageSrc;
        modalImage.alt = imageTitle;
        modalTitle.textContent = imageTitle;
        modalDescription.textContent = imageDescription || '';
        
        if (!imageDescription) {
            modalDescription.style.display = 'none';
        } else {
            modalDescription.style.display = 'block';
        }
    });
});
</script>
@endsection