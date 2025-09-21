@extends('admin.layouts.app')

@section('title', 'News & Media')
@section('page-title', 'News & Media Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">All News Articles</h4>
        <p class="text-muted mb-0">Manage your news and media content</p>
    </div>
    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        Add New Article
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.news.index') }}" class="row g-3">
            <div class="col-md-4">
                <label for="search" class="form-label">Search Articles</label>
                <input type="text" class="form-control" id="search" name="search" 
                       value="{{ request('search') }}" placeholder="Search by title or description...">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label">Filter by Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">All Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="featured" class="form-label">Featured Articles</label>
                <select class="form-select" id="featured" name="featured">
                    <option value="">All Articles</option>
                    <option value="1" {{ request('featured') == '1' ? 'selected' : '' }}>Featured Only</option>
                    <option value="0" {{ request('featured') == '0' ? 'selected' : '' }}>Non-Featured</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">&nbsp;</label>
                <div class="d-grid">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- News Table -->
<div class="card">
    <div class="card-body">
        @if($news->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover" id="newsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Views</th>
                            <th>Published Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $article)
                            <tr>
                                <td>
                                    @if($article->images && count($article->images) > 0)
                                        <img src="{{ asset($article->images[0]) }}" 
                                             alt="{{ $article->title }}" 
                                             class="img-thumbnail" 
                                             style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-1">{{ Str::limit($article->title, 50) }}</h6>
                                        <small class="text-muted">{{ Str::limit($article->short_description, 80) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('admin.news.toggle-status', $article) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $article->status === 'published' ? 'success' : ($article->status === 'draft' ? 'warning' : 'secondary') }}">
                                            <i class="fas fa-{{ $article->status === 'published' ? 'eye' : ($article->status === 'draft' ? 'edit' : 'archive') }}"></i>
                                            {{ ucfirst($article->status) }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('admin.news.toggle-featured', $article) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-{{ $article->is_featured ? 'warning' : 'secondary' }}">
                                            <i class="fas fa-star{{ $article->is_featured ? '' : '-o' }}"></i>
                                            {{ $article->is_featured ? 'Featured' : 'Regular' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ number_format($article->views) }}</span>
                                </td>
                                <td>
                                    @if($article->published_at)
                                        <small>{{ $article->published_at->format('M d, Y') }}</small>
                                    @else
                                        <small class="text-muted">Not published</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.news.show', $article) }}" 
                                           class="btn btn-sm btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.news.edit', $article) }}" 
                                           class="btn btn-sm btn-outline-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                onclick="confirmDelete({{ $article->id }})" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <p class="text-muted mb-0">
                        Showing {{ $news->firstItem() }} to {{ $news->lastItem() }} of {{ $news->total() }} results
                    </p>
                </div>
                <div>
                    {{ $news->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No news articles found</h5>
                <p class="text-muted">Start by creating your first news article.</p>
                <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    Create First Article
                </a>
            </div>
        @endif
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
                <p>Are you sure you want to delete this news article? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmDelete(newsId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/news/${newsId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

// Initialize DataTable if needed
$(document).ready(function() {
    if ($('#newsTable tbody tr').length > 10) {
        $('#newsTable').DataTable({
            "pageLength": 25,
            "order": [[ 5, "desc" ]],
            "columnDefs": [
                { "orderable": false, "targets": [0, 6] }
            ]
        });
    }
});
</script>
@endpush