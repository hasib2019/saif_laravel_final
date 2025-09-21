@extends('layouts.app')

@section('title', $news->title)

@section('meta')
<meta name="description" content="{{ $news->short_description }}">
<meta name="keywords" content="news, article, {{ $news->title }}">

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="{{ $news->title }}">
<meta property="og:description" content="{{ $news->short_description }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ route('news.show', $news->slug) }}">
@if($news->images && count($news->images) > 0)
<meta property="og:image" content="{{ asset($news->images[0]) }}">
@endif

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $news->title }}">
<meta name="twitter:description" content="{{ $news->short_description }}">
@if($news->images && count($news->images) > 0)
<meta name="twitter:image" content="{{ asset($news->images[0]) }}">
@endif

<!-- Article Meta Tags -->
<meta property="article:published_time" content="{{ $news->published_at->toISOString() }}">
<meta property="article:modified_time" content="{{ $news->updated_at->toISOString() }}">
@endsection

@section('content')
<div class="news-article-page">
    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('news.index') }}">{{ __('News') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($news->title, 50) }}</li>
            </ol>
        </nav>
    </div>

    <div class="container">
        <div class="row">
            <!-- Main Article Content -->
            <div class="col-lg-8">
                <article class="news-article">
                    <!-- Article Header -->
                    <header class="article-header mb-4">
                        @if($news->is_featured)
                        <span class="badge bg-warning text-dark mb-3">
                            <i class="fas fa-star me-1"></i>{{ __('Featured Article') }}
                        </span>
                        @endif
                        
                        <h1 class="article-title">{{ $news->title }}</h1>
                        
                        <div class="article-meta d-flex flex-wrap align-items-center mb-3">
                            <div class="meta-item me-4">
                                <i class="fas fa-calendar text-primary me-1"></i>
                                <time datetime="{{ $news->published_at->toISOString() }}">
                                    {{ $news->published_at->format('F d, Y') }}
                                </time>
                            </div>
                            <div class="meta-item me-4">
                                <i class="fas fa-clock text-primary me-1"></i>
                                <span>{{ $news->published_at->format('g:i A') }}</span>
                            </div>
                            <div class="meta-item me-4">
                                <i class="fas fa-eye text-primary me-1"></i>
                                <span>{{ number_format($news->views) }} {{ __('views') }}</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-clock text-primary me-1"></i>
                                <span>{{ __('Updated') }} {{ $news->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        
                        @if($news->short_description)
                        <div class="article-excerpt">
                            <p class="lead text-muted">{{ $news->short_description }}</p>
                        </div>
                        @endif
                    </header>

                    <!-- Article Images/Media -->
                    @if($news->images && count($news->images) > 0)
                    <div class="article-media mb-4">
                        @if(count($news->images) == 1)
                            <figure class="article-figure">
                                <img src="{{ asset($news->images[0]) }}" 
                                     alt="{{ $news->title }}" 
                                     class="img-fluid rounded shadow-sm w-100 article-main-image">
                                <figcaption class="figure-caption text-center mt-2 text-muted">
                                    {{ $news->title }}
                                </figcaption>
                            </figure>
                        @else
                            <div id="articleCarousel" class="carousel slide mb-3" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach($news->images as $index => $image)
                                        <button type="button" data-bs-target="#articleCarousel" 
                                                data-bs-slide-to="{{ $index }}" 
                                                class="{{ $index == 0 ? 'active' : '' }}"></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner rounded">
                                    @foreach($news->images as $index => $image)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 class="d-block w-100 article-carousel-image" 
                                                 alt="{{ $news->title }}">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#articleCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#articleCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Article Content -->
                    <div class="article-content">
                        {!! $news->description !!}
                    </div>

                    <!-- Video Content -->
                    @if($news->video_path)
                    <div class="article-video mt-4">
                        <h4 class="mb-3">{{ __('Video Content') }}</h4>
                        <div class="video-container">
                            <video controls class="w-100 rounded shadow-sm">
                                <source src="{{ asset('storage/' . $news->video_path) }}" type="video/mp4">
                                {{ __('Your browser does not support the video tag.') }}
                            </video>
                        </div>
                    </div>
                    @endif

                    <!-- YouTube Video -->
                    @if($news->youtube_link)
                    <div class="article-youtube mt-4">
                        <h4 class="mb-3">{{ __('Watch Video') }}</h4>
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $news->youtube_embed_url }}" 
                                    allowfullscreen 
                                    class="rounded shadow-sm"></iframe>
                        </div>
                    </div>
                    @endif

                    <!-- Article Footer -->
                    <footer class="article-footer mt-5 pt-4 border-top">
                        <!-- Social Sharing -->
                        <div class="social-sharing mb-4">
                            <h5 class="mb-3">{{ __('Share this article') }}</h5>
                            <div class="d-flex flex-wrap gap-2">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('news.show', $news->slug)) }}" 
                                   target="_blank" class="btn btn-facebook btn-sm">
                                    <i class="fab fa-facebook-f me-1"></i>Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('news.show', $news->slug)) }}&text={{ urlencode($news->title) }}" 
                                   target="_blank" class="btn btn-twitter btn-sm">
                                    <i class="fab fa-twitter me-1"></i>Twitter
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('news.show', $news->slug)) }}" 
                                   target="_blank" class="btn btn-linkedin btn-sm">
                                    <i class="fab fa-linkedin-in me-1"></i>LinkedIn
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . route('news.show', $news->slug)) }}" 
                                   target="_blank" class="btn btn-whatsapp btn-sm">
                                    <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                </a>
                                <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard('{{ route('news.show', $news->slug) }}')">
                                    <i class="fas fa-link me-1"></i>{{ __('Copy Link') }}
                                </button>
                            </div>
                        </div>

                        <!-- Article Navigation -->
                        <div class="article-navigation">
                            <div class="row">
                                @if($previousNews)
                                <div class="col-md-6 mb-3">
                                    <div class="nav-article prev-article">
                                        <small class="text-muted">{{ __('Previous Article') }}</small>
                                        <h6>
                                            <a href="{{ route('news.show', $previousNews->slug) }}" 
                                               class="text-decoration-none">
                                                <i class="fas fa-chevron-left me-1"></i>
                                                {{ Str::limit($previousNews->title, 60) }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                                @endif
                                
                                @if($nextNews)
                                <div class="col-md-6 mb-3">
                                    <div class="nav-article next-article text-md-end">
                                        <small class="text-muted">{{ __('Next Article') }}</small>
                                        <h6>
                                            <a href="{{ route('news.show', $nextNews->slug) }}" 
                                               class="text-decoration-none">
                                                {{ Str::limit($nextNews->title, 60) }}
                                                <i class="fas fa-chevron-right ms-1"></i>
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </footer>
                </article>

                <!-- Related Articles -->
                @if($relatedNews->count() > 0)
                <section class="related-articles mt-5">
                    <h3 class="section-title mb-4">{{ __('Related Articles') }}</h3>
                    <div class="row">
                        @foreach($relatedNews as $related)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm related-card">
                                @if($related->images && count($related->images) > 0)
                                <div class="related-img-container">
                                    <img src="{{ asset($related->images[0]) }}" 
                                         alt="{{ $related->title }}" 
                                         class="card-img-top related-img">
                                </div>
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('news.show', $related->slug) }}" 
                                           class="text-dark text-decoration-none stretched-link">
                                            {{ Str::limit($related->title, 60) }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($related->short_description, 100) }}
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $related->published_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="article-sidebar">
                    <!-- Latest Articles -->
                    @if($latestNews->count() > 0)
                    <div class="sidebar-widget mb-4">
                        <h5 class="widget-title">{{ __('Latest Articles') }}</h5>
                        <div class="widget-content">
                            @foreach($latestNews as $latest)
                            <div class="sidebar-article {{ !$loop->last ? 'border-bottom pb-3 mb-3' : '' }}">
                                <div class="row g-2">
                                    @if($latest->images && count($latest->images) > 0)
                                    <div class="col-4">
                                        <img src="{{ asset($latest->images[0]) }}" 
                                             alt="{{ $latest->title }}" 
                                             class="w-100 rounded sidebar-img">
                                    </div>
                                    <div class="col-8">
                                    @else
                                    <div class="col-12">
                                    @endif
                                        <h6 class="sidebar-title">
                                            <a href="{{ route('news.show', $latest->slug) }}" 
                                               class="text-dark text-decoration-none">
                                                {{ Str::limit($latest->title, 50) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            {{ $latest->published_at->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('news.index') }}" class="btn btn-outline-primary btn-sm">
                                {{ __('View All News') }}
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Back to News -->
                    <div class="sidebar-widget">
                        <div class="text-center">
                            <a href="{{ route('news.index') }}" class="btn btn-primary w-100">
                                <i class="fas fa-arrow-left me-2"></i>
                                {{ __('Back to News') }}
                            </a>
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
/* Article Styles */
.news-article-page {
    padding: 2rem 0;
}

.article-title {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
    color: #333;
    margin-bottom: 1rem;
}

.article-meta {
    font-size: 0.9rem;
    color: #666;
}

.meta-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.article-excerpt {
    padding: 1.5rem;
    background-color: #f8f9fa;
    border-left: 4px solid #007bff;
    border-radius: 0.375rem;
    margin-bottom: 2rem;
}

.article-main-image {
    max-height: 500px;
    object-fit: cover;
}

.article-carousel-image {
    height: 400px;
    object-fit: cover;
}

.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.article-content h1, .article-content h2, .article-content h3,
.article-content h4, .article-content h5, .article-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    margin: 1rem 0;
}

.article-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1.5rem;
    border-radius: 0.375rem;
}

.article-content ul, .article-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

/* Social Sharing Buttons */
.btn-facebook {
    background-color: #1877f2;
    border-color: #1877f2;
    color: white;
}

.btn-facebook:hover {
    background-color: #166fe5;
    border-color: #166fe5;
    color: white;
}

.btn-twitter {
    background-color: #1da1f2;
    border-color: #1da1f2;
    color: white;
}

.btn-twitter:hover {
    background-color: #0d8bd9;
    border-color: #0d8bd9;
    color: white;
}

.btn-linkedin {
    background-color: #0077b5;
    border-color: #0077b5;
    color: white;
}

.btn-linkedin:hover {
    background-color: #005885;
    border-color: #005885;
    color: white;
}

.btn-whatsapp {
    background-color: #25d366;
    border-color: #25d366;
    color: white;
}

.btn-whatsapp:hover {
    background-color: #1ebe57;
    border-color: #1ebe57;
    color: white;
}

/* Article Navigation */
.nav-article {
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 0.375rem;
    transition: background-color 0.2s ease;
}

.nav-article:hover {
    background-color: #e9ecef;
}

.nav-article a {
    color: #333;
}

.nav-article a:hover {
    color: #007bff;
}

/* Related Articles */
.related-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.related-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.related-img-container {
    height: 150px;
    overflow: hidden;
}

.related-img {
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-card:hover .related-img {
    transform: scale(1.05);
}

/* Sidebar */
.article-sidebar {
    position: sticky;
    top: 2rem;
}

.sidebar-widget {
    background: white;
    border-radius: 0.5rem;
    padding: 1.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.widget-title {
    font-weight: 700;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #007bff;
}

.sidebar-img {
    height: 60px;
    object-fit: cover;
}

.sidebar-title {
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.3;
}

.section-title {
    font-weight: 700;
    color: #333;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 50px;
    height: 3px;
    background: #007bff;
}

/* Video Container */
.video-container {
    position: relative;
    max-width: 100%;
}

.video-container video {
    max-height: 400px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .article-title {
        font-size: 1.8rem;
    }
    
    .article-content {
        font-size: 1rem;
    }
    
    .article-sidebar {
        position: static;
        margin-top: 2rem;
    }
    
    .social-sharing .d-flex {
        flex-direction: column;
        gap: 0.5rem !important;
    }
    
    .social-sharing .btn {
        width: 100%;
    }
}

/* Print Styles */
@media print {
    .article-sidebar,
    .social-sharing,
    .article-navigation,
    .related-articles {
        display: none;
    }
    
    .article-content {
        font-size: 12pt;
        line-height: 1.5;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Copy to clipboard functionality
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check me-1"></i>Copied!';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');
        
        setTimeout(function() {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    }).catch(function(err) {
        console.error('Could not copy text: ', err);
    });
}

// Reading progress indicator
document.addEventListener('DOMContentLoaded', function() {
    const article = document.querySelector('.article-content');
    if (article) {
        const progressBar = document.createElement('div');
        progressBar.className = 'reading-progress';
        progressBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: #007bff;
            z-index: 1000;
            transition: width 0.1s ease;
        `;
        document.body.appendChild(progressBar);
        
        window.addEventListener('scroll', function() {
            const articleTop = article.offsetTop;
            const articleHeight = article.offsetHeight;
            const windowHeight = window.innerHeight;
            const scrollTop = window.pageYOffset;
            
            const progress = Math.min(
                Math.max((scrollTop - articleTop + windowHeight) / articleHeight, 0),
                1
            );
            
            progressBar.style.width = (progress * 100) + '%';
        });
    }
});

// Image zoom functionality
document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.article-content img');
    images.forEach(img => {
        img.style.cursor = 'zoom-in';
        img.addEventListener('click', function() {
            const modal = document.createElement('div');
            modal.className = 'image-modal';
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 2000;
                cursor: zoom-out;
            `;
            
            const modalImg = document.createElement('img');
            modalImg.src = this.src;
            modalImg.style.cssText = `
                max-width: 90%;
                max-height: 90%;
                object-fit: contain;
            `;
            
            modal.appendChild(modalImg);
            document.body.appendChild(modal);
            
            modal.addEventListener('click', function() {
                document.body.removeChild(modal);
            });
        });
    });
});
</script>
@endpush