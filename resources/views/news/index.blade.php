@extends('layouts.app')

@section('title', __('News & Media'))

@section('content')
<div class="news-page">
    <!-- Hero Section with Featured News -->
    @if($featuredNews->count() > 0)
    <section class="hero-section mb-5">
        <div class="container-fluid px-0">
            <div class="row g-0">
                <!-- Main Featured Article -->
                <div class="col-lg-8">
                    @php $mainFeatured = $featuredNews->first(); @endphp
                    <div class="hero-article position-relative">
                        <div class="hero-image">
                            @if($mainFeatured->images && count($mainFeatured->images) > 0)
                                <img src="{{ asset($mainFeatured->images[0]) }}" 
                                     alt="{{ $mainFeatured->title }}" 
                                     class="w-100 hero-img">
                            @else
                                <div class="hero-placeholder d-flex align-items-center justify-content-center">
                                    <i class="fas fa-newspaper fa-5x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="hero-overlay">
                            <div class="hero-content">
                                <span class="badge bg-danger mb-2">{{ __('Featured') }}</span>
                                <h1 class="hero-title">
                                    <a href="{{ route('news.show', $mainFeatured->slug) }}" class="text-white text-decoration-none">
                                        {{ $mainFeatured->title }}
                                    </a>
                                </h1>
                                <p class="hero-excerpt">{{ $mainFeatured->short_description }}</p>
                                <div class="hero-meta">
                                    <span class="me-3">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $mainFeatured->published_at->format('M d, Y') }}
                                    </span>
                                    <span>
                                        <i class="fas fa-eye me-1"></i>
                                        {{ number_format($mainFeatured->views) }} {{ __('views') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Side Featured Articles -->
                <div class="col-lg-4">
                    <div class="side-featured h-100">
                        @foreach($featuredNews->skip(1)->take(2) as $featured)
                        <div class="side-article {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="row g-0 h-100">
                                <div class="col-5">
                                    @if($featured->images && count($featured->images) > 0)
                                        <img src="{{ asset($featured->images[0]) }}" 
                                             alt="{{ $featured->title }}" 
                                             class="w-100 h-100 object-cover">
                                    @else
                                        <div class="placeholder-img d-flex align-items-center justify-content-center h-100">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-7">
                                    <div class="p-3 h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="side-title">
                                                <a href="{{ route('news.show', $featured->slug) }}" class="text-dark text-decoration-none">
                                                    {{ Str::limit($featured->title, 60) }}
                                                </a>
                                            </h5>
                                            <p class="side-excerpt text-muted small">
                                                {{ Str::limit($featured->short_description, 80) }}
                                            </p>
                                        </div>
                                        <div class="side-meta small text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $featured->published_at->format('M d') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <div class="container">
        <!-- Search and Filter Section -->
        <div class="row mb-4">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="section-title">{{ __('Latest News') }}</h2>
                    <div class="news-actions">
                        <button class="btn btn-outline-secondary btn-sm me-2" onclick="toggleView('grid')">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm" onclick="toggleView('list')">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                </div>

                <!-- Search Form -->
                <form method="GET" action="{{ route('news.search') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" 
                               placeholder="{{ __('Search news articles...') }}" 
                               value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- News Grid -->
                <div id="news-container" class="news-grid">
                    @forelse($news as $article)
                    <article class="news-card mb-4">
                        <div class="card h-100 border-0 shadow-sm">
                            @if($article->images && count($article->images) > 0)
                            <div class="card-img-container">
                                <img src="{{ asset($article->images[0]) }}" 
                                     alt="{{ $article->title }}" 
                                     class="card-img-top news-img">
                                @if($article->is_featured)
                                    <span class="badge bg-warning position-absolute top-0 start-0 m-2">
                                        <i class="fas fa-star me-1"></i>{{ __('Featured') }}
                                    </span>
                                @endif
                            </div>
                            @endif
                            
                            <div class="card-body d-flex flex-column">
                                <div class="news-meta mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $article->published_at->format('M d, Y') }}
                                        <span class="mx-2">•</span>
                                        <i class="fas fa-eye me-1"></i>
                                        {{ number_format($article->views) }}
                                    </small>
                                </div>
                                
                                <h5 class="card-title">
                                    <a href="{{ route('news.show', $article->slug) }}" 
                                       class="text-dark text-decoration-none stretched-link">
                                        {{ $article->title }}
                                    </a>
                                </h5>
                                
                                <p class="card-text text-muted flex-grow-1">
                                    {{ Str::limit($article->short_description, 120) }}
                                </p>
                                
                                <div class="news-footer mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            {{ $article->published_at->diffForHumans() }}
                                        </small>
                                        @if($article->video_path || $article->youtube_link)
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-play me-1"></i>{{ __('Video') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ __('No news articles found') }}</h4>
                        <p class="text-muted">{{ __('Check back later for the latest updates.') }}</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($news->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $news->links() }}
                </div>
                @endif

                <!-- Load More Button (for AJAX loading) -->
                @if($news->hasMorePages())
                <div class="text-center mt-4">
                    <button id="load-more-btn" class="btn btn-outline-primary" data-page="{{ $news->currentPage() + 1 }}">
                        <i class="fas fa-plus me-2"></i>{{ __('Load More Articles') }}
                    </button>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="news-sidebar">
                    <!-- Latest News Widget -->
                    @if($latestNews->count() > 0)
                    <div class="sidebar-widget mb-4">
                        <h5 class="widget-title">{{ __('Latest News') }}</h5>
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
                    </div>
                    @endif

                    <!-- Popular News Widget -->
                    @if($popularNews->count() > 0)
                    <div class="sidebar-widget mb-4">
                        <h5 class="widget-title">{{ __('Most Popular') }}</h5>
                        <div class="widget-content">
                            @foreach($popularNews as $popular)
                            <div class="sidebar-article {{ !$loop->last ? 'border-bottom pb-3 mb-3' : '' }}">
                                <div class="d-flex align-items-center">
                                    <span class="popular-rank me-3">{{ $loop->iteration }}</span>
                                    <div class="flex-grow-1">
                                        <h6 class="sidebar-title mb-1">
                                            <a href="{{ route('news.show', $popular->slug) }}" 
                                               class="text-dark text-decoration-none">
                                                {{ Str::limit($popular->title, 45) }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">
                                            <i class="fas fa-eye me-1"></i>
                                            {{ number_format($popular->views) }} {{ __('views') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Newsletter Signup -->
                    <div class="sidebar-widget">
                        <div class="newsletter-widget bg-primary text-white p-4 rounded">
                            <h5 class="text-white mb-3">{{ __('Stay Updated') }}</h5>
                            <p class="mb-3">{{ __('Subscribe to our newsletter for the latest news and updates.') }}</p>
                            <form>
                                <div class="mb-3">
                                    <input type="email" class="form-control" placeholder="{{ __('Your email address') }}">
                                </div>
                                <button type="submit" class="btn btn-light w-100">
                                    {{ __('Subscribe') }}
                                </button>
                            </form>
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
/* Hero Section Styles */
.hero-section {
    margin-top: -2rem;
}

.hero-article {
    height: 500px;
    overflow: hidden;
}

.hero-img {
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.hero-article:hover .hero-img {
    transform: scale(1.05);
}

.hero-placeholder {
    height: 500px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.hero-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: linear-gradient(transparent, rgba(0,0,0,0.8));
    padding: 3rem 2rem 2rem;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 1rem;
}

.hero-excerpt {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.9);
    margin-bottom: 1rem;
}

.hero-meta {
    color: rgba(255,255,255,0.8);
}

/* Side Featured Articles */
.side-featured {
    background: white;
}

.side-article {
    height: 250px;
}

.side-title {
    font-size: 1rem;
    font-weight: 600;
    line-height: 1.3;
}

.side-excerpt {
    font-size: 0.875rem;
    line-height: 1.4;
}

.object-cover {
    object-fit: cover;
}

.placeholder-img {
    background-color: #f8f9fa;
}

/* News Grid Styles */
.news-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 1.5rem;
}

.news-grid.list-view {
    grid-template-columns: 1fr;
}

.news-grid.list-view .news-card .card {
    flex-direction: row;
}

.news-grid.list-view .card-img-container {
    width: 200px;
    flex-shrink: 0;
}

.news-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.news-card:hover {
    transform: translateY(-2px);
}

.news-card:hover .card {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.card-img-container {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.news-img {
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.news-card:hover .news-img {
    transform: scale(1.05);
}

/* Sidebar Styles */
.news-sidebar {
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

.popular-rank {
    font-size: 1.5rem;
    font-weight: 700;
    color: #007bff;
    width: 30px;
    text-align: center;
}

.newsletter-widget {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
}

/* Section Title */
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

/* Responsive Design */
@media (max-width: 768px) {
    .hero-title {
        font-size: 1.8rem;
    }
    
    .hero-overlay {
        padding: 2rem 1rem 1rem;
    }
    
    .news-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .side-article {
        height: auto;
        min-height: 150px;
    }
    
    .news-sidebar {
        position: static;
        margin-top: 2rem;
    }
}

/* Loading Animation */
.loading {
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid #007bff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}
</style>
@endpush

@push('scripts')
<script>
// View Toggle Functionality
function toggleView(view) {
    const container = document.getElementById('news-container');
    const buttons = document.querySelectorAll('.news-actions button');
    
    buttons.forEach(btn => btn.classList.remove('btn-primary'));
    buttons.forEach(btn => btn.classList.add('btn-outline-secondary'));
    
    if (view === 'list') {
        container.classList.add('list-view');
        buttons[1].classList.remove('btn-outline-secondary');
        buttons[1].classList.add('btn-primary');
    } else {
        container.classList.remove('list-view');
        buttons[0].classList.remove('btn-outline-secondary');
        buttons[0].classList.add('btn-primary');
    }
    
    localStorage.setItem('news-view', view);
}

// Load More Functionality
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-btn');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const page = this.dataset.page;
            const container = document.getElementById('news-container');
            
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
            this.disabled = true;
            
            fetch(`{{ route('news.load-more') }}?page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.data.length > 0) {
                    // Append new articles (you would need to render them)
                    if (data.has_more) {
                        this.dataset.page = data.next_page;
                        this.innerHTML = '<i class="fas fa-plus me-2"></i>Load More Articles';
                        this.disabled = false;
                    } else {
                        this.style.display = 'none';
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.innerHTML = '<i class="fas fa-plus me-2"></i>Load More Articles';
                this.disabled = false;
            });
        });
    }
    
    // Restore view preference
    const savedView = localStorage.getItem('news-view');
    if (savedView) {
        toggleView(savedView);
    }
});

// Search functionality
document.querySelector('form[action*="search"]').addEventListener('submit', function(e) {
    const input = this.querySelector('input[name="q"]');
    if (!input.value.trim()) {
        e.preventDefault();
        input.focus();
    }
});
</script>
@endpush