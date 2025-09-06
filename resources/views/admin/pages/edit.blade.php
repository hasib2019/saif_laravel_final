@extends('admin.layouts.app')

@section('title', 'Edit Page - ' . $page->title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Page</h5>
                    <div>
                        <a href="{{ route('admin.pages.show', $page) }}" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                        <span class="badge {{ $page->is_active ? 'bg-success' : 'bg-danger' }}">
                            {{ $page->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.update', $page) }}" method="POST" id="pageForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Page Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title', $page->title) }}" 
                                           placeholder="Enter page title" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Page Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" name="slug" value="{{ old('slug', $page->slug) }}" 
                                           placeholder="page-slug" readonly>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Auto-generated from title</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                           id="meta_title" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" 
                                           placeholder="SEO meta title" maxlength="60">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Recommended: 50-60 characters</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" 
                                           id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $page->meta_keywords) }}" 
                                           placeholder="keyword1, keyword2, keyword3">
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Separate keywords with commas</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                      id="meta_description" name="meta_description" rows="3" 
                                      placeholder="Brief description for search engines" maxlength="160">{{ old('meta_description', $page->meta_description) }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended: 150-160 characters</small>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Page Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="15" 
                                      placeholder="Enter page content here..." required>{{ old('content', $page->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" 
                                               name="is_active" value="1" {{ old('is_active', $page->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <strong>Active Status</strong>
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Enable to make this page visible</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="show_in_menu" 
                                               name="show_in_menu" value="1" {{ old('show_in_menu', $page->show_in_menu) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="show_in_menu">
                                            <strong>Show in Menu</strong>
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Display this page in navigation menu</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Pages
                            </a>
                            <div>
                                <button type="button" class="btn btn-outline-primary me-2" onclick="previewPage()">
                                    <i class="fas fa-eye me-1"></i>Preview
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Page
                                </button>
                            </div>
                        </div>
                    </form>
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
                                <h4 class="text-primary mb-1">{{ $page->created_at->format('M d, Y') }}</h4>
                                <small class="text-muted">Created</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info mb-1">{{ $page->updated_at->format('M d, Y') }}</h4>
                            <small class="text-muted">Last Updated</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-success mb-1">{{ str_word_count(strip_tags($page->content)) }}</h4>
                                <small class="text-muted">Words</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-warning mb-1">{{ strlen(strip_tags($page->content)) }}</h4>
                            <small class="text-muted">Characters</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Editing Guidelines</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <h6><i class="fas fa-exclamation-triangle me-1"></i>Important Notes:</h6>
                        <ul class="mb-0 small">
                            <li>Changing the slug will affect the page URL</li>
                            <li>Deactivating will hide the page from visitors</li>
                            <li>Always preview changes before saving</li>
                            <li>SEO fields help with search rankings</li>
                            <li>Use proper HTML formatting</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-code me-2"></i>HTML Support</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2">You can use HTML tags in content:</p>
                    <div class="small">
                        <code>&lt;h1&gt;</code> to <code>&lt;h6&gt;</code> - Headings<br>
                        <code>&lt;p&gt;</code> - Paragraphs<br>
                        <code>&lt;a&gt;</code> - Links<br>
                        <code>&lt;img&gt;</code> - image<br>
                        <code>&lt;ul&gt;</code>, <code>&lt;ol&gt;</code> - Lists<br>
                        <code>&lt;strong&gt;</code>, <code>&lt;em&gt;</code> - Text formatting
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-link me-2"></i>Page URL</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2">Current page URL:</p>
                    <div class="alert alert-light">
                        <code>{{ url('/page/' . $page->slug) }}</code>
                    </div>
                    <a href="{{ url('/page/' . $page->slug) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-external-link-alt me-1"></i>View Live Page
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-generate slug from title
    $('#title').on('input', function() {
        let title = $(this).val();
        let slug = title.toLowerCase()
            .replace(/[^\w\s-]/g, '') // Remove special characters
            .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with hyphens
            .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
        $('#slug').val(slug);
    });

    // Character counter for meta fields
    $('#meta_title').on('input', function() {
        let length = $(this).val().length;
        let color = length > 60 ? 'text-danger' : (length > 50 ? 'text-warning' : 'text-muted');
        $(this).next('.invalid-feedback').next('.form-text').removeClass('text-muted text-warning text-danger').addClass(color);
    });

    $('#meta_description').on('input', function() {
        let length = $(this).val().length;
        let color = length > 160 ? 'text-danger' : (length > 150 ? 'text-warning' : 'text-muted');
        $(this).next('.invalid-feedback').next('.form-text').removeClass('text-muted text-warning text-danger').addClass(color);
    });

    // Initialize rich text editor for content
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#content',
            height: 400,
            plugins: 'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount',
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; }'
        });
    }
});

function previewPage() {
    // Get form data
    let title = $('#title').val();
    let content = $('#content').val();
    
    if (!title || !content) {
        alert('Please fill in the title and content fields to preview.');
        return;
    }
    
    // Create preview window
    let previewWindow = window.open('', 'preview', 'width=800,height=600,scrollbars=yes');
    
    let previewContent = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>${title}</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-4">
                <div class="alert alert-info">
                    <strong>Preview Mode</strong> - This is how your page will appear to visitors.
                </div>
                <h1>${title}</h1>
                <div class="mt-4">
                    ${content}
                </div>
            </div>
        </body>
        </html>
    `;
    
    previewWindow.document.write(previewContent);
    previewWindow.document.close();
}
</script>
@endpush