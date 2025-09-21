@extends('admin.layouts.app')

@section('title', 'View News Article')
@section('page-title', 'View News Article')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">{{ $news->title }}</h4>
        <p class="text-muted mb-0">
            <i class="fas fa-calendar me-1"></i>
            Created {{ $news->created_at->format('M d, Y \a\t H:i') }}
            @if($news->published_at)
                | Published {{ $news->published_at->format('M d, Y \a\t H:i') }}
            @endif
        </p>
    </div>
    <div>
        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary me-2">
            <i class="fas fa-edit me-2"></i>
            Edit Article
        </a>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Back to News
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Article Content -->
        <div class="card mb-4">
            <div class="card-body">
                <!-- Article Header -->
                <div class="mb-4">
                    <h1 class="display-6 mb-3">{{ $news->title }}</h1>
                    <p class="lead text-muted">{{ $news->short_description }}</p>
                    
                    <div class="d-flex align-items-center text-muted mb-3">
                        <small class="me-3">
                            <i class="fas fa-eye me-1"></i>
                            {{ number_format($news->views) }} views
                        </small>
                        @if($news->published_at)
                            <small class="me-3">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $news->published_at->format('M d, Y') }}
                            </small>
                        @endif
                        @if($news->is_featured)
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i>
                                Featured
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Article Images -->
                @if($news->images && count($news->images) > 0)
                    <div class="mb-4">
                        @if(count($news->images) == 1)
                            <img src="{{ asset($news->images[0]) }}" 
                                 alt="{{ $news->title }}" 
                                 class="img-fluid rounded shadow-sm">
                        @else
                            <div id="newsCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-indicators">
                                    @foreach($news->images as $index => $image)
                                        <button type="button" data-bs-target="#newsCarousel" 
                                                data-bs-slide-to="{{ $index }}" 
                                                class="{{ $index == 0 ? 'active' : '' }}"></button>
                                    @endforeach
                                </div>
                                <div class="carousel-inner rounded">
                                    @foreach($news->images as $index => $image)
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 class="d-block w-100" 
                                                 alt="{{ $news->title }}"
                                                 style="height: 400px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#newsCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#newsCarousel" data-bs-slide="next">
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
                    <div class="mt-4">
                        <h5>Video Content</h5>
                        <video controls class="w-100 rounded" style="max-height: 400px;">
                            <source src="{{ asset('storage/' . $news->video_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @endif

                <!-- YouTube Video -->
                @if($news->youtube_link)
                    <div class="mt-4">
                        <h5>YouTube Video</h5>
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ $news->youtube_embed_url }}" 
                                    allowfullscreen 
                                    class="rounded"></iframe>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Article Status -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Article Status</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-12 mb-3">
                        <span class="badge bg-{{ $news->status === 'published' ? 'success' : ($news->status === 'draft' ? 'warning' : 'secondary') }} fs-6 px-3 py-2">
                            <i class="fas fa-{{ $news->status === 'published' ? 'eye' : ($news->status === 'draft' ? 'edit' : 'archive') }} me-1"></i>
                            {{ ucfirst($news->status) }}
                        </span>
                    </div>
                </div>
                
                <div class="row text-center">
                    <div class="col-6">
                        <div class="border-end">
                            <h4 class="text-primary mb-1">{{ number_format($news->views) }}</h4>
                            <small class="text-muted">Total Views</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <h4 class="text-{{ $news->is_featured ? 'warning' : 'muted' }} mb-1">
                            <i class="fas fa-star"></i>
                        </h4>
                        <small class="text-muted">{{ $news->is_featured ? 'Featured' : 'Regular' }}</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <!-- Toggle Status -->
                    <form action="{{ route('admin.news.toggle-status', $news) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-{{ $news->status === 'published' ? 'warning' : 'success' }} w-100">
                            <i class="fas fa-{{ $news->status === 'published' ? 'eye-slash' : 'eye' }} me-2"></i>
                            {{ $news->status === 'published' ? 'Unpublish' : 'Publish' }}
                        </button>
                    </form>

                    <!-- Toggle Featured -->
                    <form action="{{ route('admin.news.toggle-featured', $news) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-outline-{{ $news->is_featured ? 'secondary' : 'warning' }} w-100">
                            <i class="fas fa-star me-2"></i>
                            {{ $news->is_featured ? 'Remove Featured' : 'Make Featured' }}
                        </button>
                    </form>

                    <!-- Edit -->
                    <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary w-100">
                        <i class="fas fa-edit me-2"></i>
                        Edit Article
                    </a>

                    <!-- Delete -->
                    <button type="button" class="btn btn-outline-danger w-100" onclick="confirmDelete()">
                        <i class="fas fa-trash me-2"></i>
                        Delete Article
                    </button>
                </div>
            </div>
        </div>

        <!-- Article Details -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Article Details</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Slug:</strong>
                    <br>
                    <code>{{ $news->slug }}</code>
                </div>
                
                <div class="mb-3">
                    <strong>Created:</strong>
                    <br>
                    <small>{{ $news->created_at->format('M d, Y \a\t H:i A') }}</small>
                </div>
                
                <div class="mb-3">
                    <strong>Last Updated:</strong>
                    <br>
                    <small>{{ $news->updated_at->format('M d, Y \a\t H:i A') }}</small>
                </div>
                
                @if($news->published_at)
                    <div class="mb-3">
                        <strong>Published:</strong>
                        <br>
                        <small>{{ $news->published_at->format('M d, Y \a\t H:i A') }}</small>
                    </div>
                @endif

                <div class="mb-3">
                    <strong>Media Files:</strong>
                    <br>
                    <small>
                        @if($news->images && count($news->images) > 0)
                            {{ count($news->images) }} image(s)
                        @endif
                        @if($news->video_path)
                            @if($news->images && count($news->images) > 0), @endif
                            1 video
                        @endif
                        @if($news->youtube_link)
                            @if(($news->images && count($news->images) > 0) || $news->video_path), @endif
                            1 YouTube video
                        @endif
                        @if(!$news->images && !$news->video_path && !$news->youtube_link)
                            No media files
                        @endif
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this news article?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong></p>
                <p>Article: <strong>{{ $news->title }}</strong></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('admin.news.destroy', $news) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Article</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
}

.article-content h1, .article-content h2, .article-content h3,
.article-content h4, .article-content h5, .article-content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.375rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

.article-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.375rem;
}

.article-content ul, .article-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
function confirmDelete() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Auto-refresh view count (optional)
setInterval(function() {
    // You could implement real-time view count updates here
}, 30000);
</script>
@endpush