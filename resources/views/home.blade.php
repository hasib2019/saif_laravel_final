@extends('layouts.app')

@section('title', __('messages.home'))

@section('content')
    <!-- Hero Section -->
    <div class="video-section">
        <video autoplay muted loop playsinline preload="auto" id="bg-video">
            @if($settings && $settings->video_file_path)
                <source src="{{ asset($settings->video_file_path) }}" type="video/mp4">
            @else
                <source src="{{ asset('videos/Vidéo Header.mp4') }}" type="video/mp4">
            @endif
            Your browser does not support HTML5 video.
        </video>

        <div class="video-overlay">
            <div class="hero-content">
                @if($settings && $settings->video_badge_text)
                    <div class="hero-badge mb-3">
                        <span class="badge-text">{{ $settings->video_badge_text }}</span>
                    </div>
                @endif
                <h1 class="hero-title">
                    @if($settings && $settings->video_title_line1)
                        <span class="pioneer-text">{{ $settings->video_title_line1 }}</span>
                    @else
                        <span class="pioneer-text">We pioneer.</span>
                    @endif
                    <br>
                    @if($settings && $settings->video_title_line2)
                        <span class="lead-text">{{ $settings->video_title_line2 }}</span>
                    @else
                        <span class="lead-text">You lead.</span>
                    @endif
                </h1>
                <div class="hero-subtitle mt-4">
                    @if($settings && $settings->video_subtitle)
                        <p>{{ $settings->video_subtitle }}</p>
                    @else
                        <p>Vela Fashion revolutionizes fashion production and collaboration</p>
                    @endif
                </div>
                <div class="hero-actions mt-5">
                    <a href="{{ route('catalogs') }}" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-shopping-bag me-2"></i>{{ __('messages.explore_products') }}
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-light btn-lg">
                        <i class="fas fa-info-circle me-2"></i>{{ __('messages.learn_more') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Company About Section -->
    @if($settings && ($settings->company_title || $settings->industry_leadership || $settings->quality_standards || $settings->innovative_design))
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    @if($settings->company_title)
                        <h2 class="mb-3">{{ $settings->company_title }}</h2>
                    @else
                        <h2 class="mb-3">About DEROWN Tech</h2>
                    @endif
                    @if($settings->company_short_description)
                        <p class="lead text-muted">{{ $settings->company_short_description }}</p>
                    @else
                        <p class="lead text-muted">Industrial Equipment Supplier providing comprehensive solutions across multiple industry sectors</p>
                    @endif
                </div>
            </div>

            <!-- Company Stats -->
            <div class="row text-center mb-5">
                @if($settings->happy_clients)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="stats-icon bg-primary mb-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="text-primary">{{ number_format($settings->happy_clients) }}+</h3>
                        <p class="mb-0">Happy Clients</p>
                    </div>
                </div>
                @endif
                
                @if($settings->awards_won)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="stats-icon bg-success mb-3">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h3 class="text-success">{{ number_format($settings->awards_won) }}+</h3>
                        <p class="mb-0">Awards Won</p>
                    </div>
                </div>
                @endif
                
                @if($settings->projects_completed)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="stats-icon bg-info mb-3">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <h3 class="text-info">{{ number_format($settings->projects_completed) }}+</h3>
                        <p class="mb-0">Projects Completed</p>
                    </div>
                </div>
                @endif
                
                @if($settings->years_experience)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="stats-card">
                        <div class="stats-icon bg-warning mb-3">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <h3 class="text-warning">{{ $settings->years_experience }}+</h3>
                        <p class="mb-0">Years Experience</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Company Features -->
            @if($settings->industry_leadership || $settings->quality_standards || $settings->innovative_design)
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    @if($settings->company_description)
                        <p class="text-center mb-4">{{ $settings->company_description }}</p>
                    @else
                        <p class="text-center mb-4">We are a leading industrial equipment supplier dedicated to providing comprehensive solutions across multiple industry sectors. Our commitment to excellence drives us to deliver innovative products and exceptional service.</p>
                    @endif
                    
                    <div class="row">
                        @if($settings->industry_leadership)
                        <div class="col-md-4 mb-3">
                            <div class="feature-item text-center">
                                <i class="fas fa-star text-warning fa-2x mb-3"></i>
                                <h5>Industry Leadership</h5>
                                <p class="text-muted">{{ $settings->industry_leadership }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($settings->quality_standards)
                        <div class="col-md-4 mb-3">
                            <div class="feature-item text-center">
                                <i class="fas fa-award text-success fa-2x mb-3"></i>
                                <h5>Quality Standards</h5>
                                <p class="text-muted">{{ $settings->quality_standards }}</p>
                            </div>
                        </div>
                        @endif
                        
                        @if($settings->innovative_design)
                        <div class="col-md-4 mb-3">
                            <div class="feature-item text-center">
                                <i class="fas fa-lightbulb text-info fa-2x mb-3"></i>
                                <h5>Innovative Design</h5>
                                <p class="text-muted">{{ $settings->innovative_design }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif

    <!-- YouTube Video Modal -->
    <div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-dark">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-white" id="videoModalLabel">Premium Collection Showcase</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="ratio ratio-16x9">
                        <iframe id="youtubeVideo" src="" title="Premium Collection Video" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Catalog Section -->
    <section class="catalog-section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="mb-3">{{ __('messages.catalog_title') }}</h2>
                    <p class="lead text-muted">{{ __('messages.catalog_subtitle') }}</p>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="category-filter text-center">
                <div class="btn-group" role="group" aria-label="Category filter">
                    <button type="button" class="btn btn-outline-primary active"
                        data-category="all">{{ __('messages.all_categories') }}</button>
                    @foreach ($categories as $category)
                        <button type="button" class="btn btn-outline-primary"
                            data-category="{{ $category->slug }}">{{ $category->name }}</button>
                    @endforeach
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row" id="products-grid">
                @forelse($products as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-item"
                        data-category="{{ $product->category->slug ?? 'uncategorized' }}">
                        <div class="card product-card h-100">
                            @if ($product->image)
                                <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}"
                                    style="height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x200/f8f9fa/6c757d?text={{ urlencode($product->name) }}"
                                    class="card-img-top" alt="{{ $product->name }}"
                                    style="height: 200px; object-fit: cover;">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted flex-grow-1">
                                    {{ Str::limit($product->short_description ?? $product->description, 100) }}</p>

                                <div class="mt-auto">
                                    @if ($product->sale_price && $product->sale_price < $product->price)
                                        <div class="d-flex align-items-center mb-2">
                                            <span
                                                class="h5 text-danger mb-0">${{ number_format($product->sale_price, 2) }}</span>
                                            <span
                                                class="text-muted text-decoration-line-through ms-2">${{ number_format($product->price, 2) }}</span>
                                        </div>
                                    @else
                                        <div class="mb-2">
                                            <span
                                                class="h5 text-primary mb-0">${{ number_format($product->price, 2) }}</span>
                                        </div>
                                    @endif

                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">SKU: {{ $product->sku }}</small>
                                        @if ($product->stock_quantity > 0)
                                            <span class="badge bg-success">{{ __('messages.in_stock') }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ __('messages.out_of_stock') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <div class="py-5">
                            <h4 class="text-muted">{{ __('messages.no_products_available') }}</h4>
                            <p class="text-muted">{{ __('messages.check_back_later') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($products->count() > 0)
                <div class="text-center mt-5">
                    <a href="{{ route('catalogs') }}"
                        class="btn btn-primary btn-lg">{{ __('messages.view_all_products') }}</a>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // YouTube Video Modal Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const videoModal = document.getElementById('videoModal');
            const youtubeVideo = document.getElementById('youtubeVideo');

            // Replace with your actual YouTube video ID
            const youtubeVideoId = 'dQw4w9WgXcQ'; // Example video ID
            const youtubeEmbedUrl = `https://www.youtube.com/embed/${youtubeVideoId}?autoplay=1&rel=0`;

            // When modal is shown, load the YouTube video
            videoModal.addEventListener('shown.bs.modal', function() {
                youtubeVideo.src = youtubeEmbedUrl;
            });

            // When modal is hidden, stop the video
            videoModal.addEventListener('hidden.bs.modal', function() {
                youtubeVideo.src = '';
            });

            // Add hover effect to play button
            const playButton = document.querySelector('.btn-play');
            if (playButton) {
                playButton.addEventListener('mouseenter', function() {
                    this.style.transform = 'scale(1.1)';
                    this.style.transition = 'transform 0.3s ease';
                });

                playButton.addEventListener('mouseleave', function() {
                    this.style.transform = 'scale(1)';
                });
            }

            // Category Filter Functionality
            const categoryButtons = document.querySelectorAll('[data-category]');
            const productItems = document.querySelectorAll('.product-item');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');

                    // Update active button
                    categoryButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Filter products
                    productItems.forEach(item => {
                        if (category === 'all' || item.getAttribute('data-category') ===
                            category) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
@endpush
