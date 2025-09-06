@extends('admin.layouts.app')

@section('title', 'Page Details - ' . $page->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-file-alt me-2"></i>{{ $page->title }}</h5>
                    <div>
                        <span class="badge {{ $page->is_active ? 'bg-success' : 'bg-danger' }} me-2">
                            {{ $page->is_active ? 'Active' : 'Inactive' }}
                        </span>
                        @if($page->show_in_menu)
                            <span class="badge bg-info">In Menu</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Page Information -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Page Details</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td width="120"><strong>Title:</strong></td>
                                    <td>{{ $page->title }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Slug:</strong></td>
                                    <td><code>{{ $page->slug }}</code></td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge {{ $page->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $page->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>In Menu:</strong></td>
                                    <td>
                                        <span class="badge {{ $page->show_in_menu ? 'bg-info' : 'bg-secondary' }}">
                                            {{ $page->show_in_menu ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-2">Timestamps</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td width="120"><strong>Created:</strong></td>
                                    <td>{{ $page->created_at->format('M d, Y \\a\\t g:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Updated:</strong></td>
                                    <td>{{ $page->updated_at->format('M d, Y \\a\\t g:i A') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Word Count:</strong></td>
                                    <td>{{ str_word_count(strip_tags($page->content)) }} words</td>
                                </tr>
                                <tr>
                                    <td><strong>Characters:</strong></td>
                                    <td>{{ strlen(strip_tags($page->content)) }} characters</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- SEO Information -->
                    @if($page->meta_title || $page->meta_description || $page->meta_keywords)
                        <div class="mb-4">
                            <h6 class="text-muted mb-3">SEO Information</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    @if($page->meta_title)
                                        <div class="mb-2">
                                            <strong>Meta Title:</strong>
                                            <div class="text-muted">{{ $page->meta_title }}</div>
                                        </div>
                                    @endif
                                    @if($page->meta_description)
                                        <div class="mb-2">
                                            <strong>Meta Description:</strong>
                                            <div class="text-muted">{{ $page->meta_description }}</div>
                                        </div>
                                    @endif
                                    @if($page->meta_keywords)
                                        <div class="mb-0">
                                            <strong>Meta Keywords:</strong>
                                            <div class="text-muted">{{ $page->meta_keywords }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    <div class="mb-4">
                        <h6 class="text-muted mb-3">Page Content</h6>
                        <div class="card">
                            <div class="card-body">
                                {!! $page->content !!}
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Pages
                        </a>
                        <div>
                            <a href="{{ url('/page/' . $page->slug) }}" target="_blank" class="btn btn-outline-primary me-2">
                                <i class="fas fa-external-link-alt me-1"></i>View Live
                            </a>
                            <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning me-2">
                                <i class="fas fa-edit me-1"></i>Edit Page
                            </a>
                            <button type="button" class="btn btn-danger" onclick="deletePage({{ $page->id }})">
                                <i class="fas fa-trash me-1"></i>Delete
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Page Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ str_word_count(strip_tags($page->content)) }}</h4>
                                <small class="text-muted">Words</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info mb-1">{{ strlen(strip_tags($page->content)) }}</h4>
                            <small class="text-muted">Characters</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-success mb-1">{{ $page->created_at->diffForHumans() }}</h4>
                                <small class="text-muted">Created</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning mb-1">{{ $page->updated_at->diffForHumans() }}</h4>
                            <small class="text-muted">Updated</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-link me-2"></i>Page URL</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-light mb-3">
                        <code>{{ url('/page/' . $page->slug) }}</code>
                    </div>
                    <div class="d-grid">
                        <a href="{{ url('/page/' . $page->slug) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt me-1"></i>View Live Page
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-search me-2"></i>SEO Score</h6>
                </div>
                <div class="card-body">
                    @php
                        $seoScore = 0;
                        $maxScore = 100;
                        
                        // Title check (20 points)
                        if($page->title && strlen($page->title) >= 10) $seoScore += 20;
                        
                        // Meta title check (20 points)
                        if($page->meta_title && strlen($page->meta_title) >= 30 && strlen($page->meta_title) <= 60) $seoScore += 20;
                        
                        // Meta description check (20 points)
                        if($page->meta_description && strlen($page->meta_description) >= 120 && strlen($page->meta_description) <= 160) $seoScore += 20;
                        
                        // Content length check (20 points)
                        if(str_word_count(strip_tags($page->content)) >= 300) $seoScore += 20;
                        
                        // Keywords check (10 points)
                        if($page->meta_keywords) $seoScore += 10;
                        
                        // Active status check (10 points)
                        if($page->is_active) $seoScore += 10;
                        
                        $scoreColor = $seoScore >= 80 ? 'success' : ($seoScore >= 60 ? 'warning' : 'danger');
                    @endphp
                    
                    <div class="text-center mb-3">
                        <div class="progress mb-2" style="height: 10px;">
                            <div class="progress-bar bg-{{ $scoreColor }}" style="width: {{ $seoScore }}%"></div>
                        </div>
                        <h4 class="text-{{ $scoreColor }}">{{ $seoScore }}/{{ $maxScore }}</h4>
                        <small class="text-muted">SEO Score</small>
                    </div>
                    
                    <div class="small">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Title Quality</span>
                            <span class="text-{{ $page->title && strlen($page->title) >= 10 ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $page->title && strlen($page->title) >= 10 ? 'check' : 'times' }}"></i>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Meta Title</span>
                            <span class="text-{{ $page->meta_title && strlen($page->meta_title) >= 30 && strlen($page->meta_title) <= 60 ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $page->meta_title && strlen($page->meta_title) >= 30 && strlen($page->meta_title) <= 60 ? 'check' : 'times' }}"></i>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Meta Description</span>
                            <span class="text-{{ $page->meta_description && strlen($page->meta_description) >= 120 && strlen($page->meta_description) <= 160 ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $page->meta_description && strlen($page->meta_description) >= 120 && strlen($page->meta_description) <= 160 ? 'check' : 'times' }}"></i>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Content Length</span>
                            <span class="text-{{ str_word_count(strip_tags($page->content)) >= 300 ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ str_word_count(strip_tags($page->content)) >= 300 ? 'check' : 'times' }}"></i>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-1">
                            <span>Keywords</span>
                            <span class="text-{{ $page->meta_keywords ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $page->meta_keywords ? 'check' : 'times' }}"></i>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Active Status</span>
                            <span class="text-{{ $page->is_active ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $page->is_active ? 'check' : 'times' }}"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-tools me-2"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit Page
                        </a>
                        <a href="{{ url('/page/' . $page->slug) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-external-link-alt me-1"></i>View Live
                        </a>
                        @if($page->is_active)
                            <button class="btn btn-outline-secondary btn-sm" onclick="toggleStatus({{ $page->id }}, 0)">
                                <i class="fas fa-eye-slash me-1"></i>Deactivate
                            </button>
                        @else
                            <button class="btn btn-outline-success btn-sm" onclick="toggleStatus({{ $page->id }}, 1)">
                                <i class="fas fa-eye me-1"></i>Activate
                            </button>
                        @endif
                        <button class="btn btn-outline-danger btn-sm" onclick="deletePage({{ $page->id }})">
                            <i class="fas fa-trash me-1"></i>Delete Page
                        </button>
                    </div>
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
                <p>Are you sure you want to delete this page? This action cannot be undone.</p>
                <div class="alert alert-warning">
                    <strong>Warning:</strong> Deleting this page will also remove it from any navigation menus and break any existing links to this page.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Page</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function deletePage(pageId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/pages/${pageId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}

function toggleStatus(pageId, status) {
    if (confirm(`Are you sure you want to ${status ? 'activate' : 'deactivate'} this page?`)) {
        // Create a form to submit the status change
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/pages/${pageId}`;
        
        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        // Add method override
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'PUT';
        form.appendChild(methodField);
        
        // Add status field
        const statusField = document.createElement('input');
        statusField.type = 'hidden';
        statusField.name = 'is_active';
        statusField.value = status;
        form.appendChild(statusField);
        
        // Add other required fields (to avoid validation errors)
        const titleField = document.createElement('input');
        titleField.type = 'hidden';
        titleField.name = 'title';
        titleField.value = '{{ $page->title }}';
        form.appendChild(titleField);
        
        const contentField = document.createElement('input');
        contentField.type = 'hidden';
        contentField.name = 'content';
        contentField.value = `{!! addslashes($page->content) !!}`;
        form.appendChild(contentField);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush