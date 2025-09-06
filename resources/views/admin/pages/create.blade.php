@extends('admin.layouts.app')

@section('title', 'Create New Page')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-plus me-2"></i>Create New Page</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pages.store') }}" method="POST" id="pageForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Page Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" 
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
                                           id="slug" name="slug" value="{{ old('slug') }}" 
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
                                           id="meta_title" name="meta_title" value="{{ old('meta_title') }}" 
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
                                           id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" 
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
                                      placeholder="Brief description for search engines" maxlength="160">{{ old('meta_description') }}</textarea>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Recommended: 150-160 characters</small>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Page Content <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="15" 
                                      placeholder="Enter page content here..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" 
                                               name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
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
                                               name="show_in_menu" value="1" {{ old('show_in_menu') ? 'checked' : '' }}>
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
                                    <i class="fas fa-save me-1"></i>Create Page
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
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Page Guidelines</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-lightbulb me-1"></i>Tips for Creating Pages:</h6>
                        <ul class="mb-0 small">
                            <li>Use descriptive and SEO-friendly titles</li>
                            <li>Keep meta descriptions under 160 characters</li>
                            <li>Use proper HTML formatting in content</li>
                            <li>Enable "Show in Menu" for navigation pages</li>
                            <li>Preview before publishing</li>
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
                    <h6 class="mb-0"><i class="fas fa-search me-2"></i>SEO Settings</h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <p><strong>Meta Title:</strong> Appears in search results and browser tabs</p>
                        <p><strong>Meta Description:</strong> Brief summary shown in search results</p>
                        <p><strong>Meta Keywords:</strong> Help search engines understand page content</p>
                        <p class="mb-0"><strong>URL Slug:</strong> Clean, readable URL for the page</p>
                    </div>
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