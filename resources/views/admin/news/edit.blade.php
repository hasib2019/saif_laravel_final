@extends('admin.layouts.app')

@section('title', 'Edit News Article')
@section('page-title', 'Edit News Article')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="mb-0">Edit Article</h4>
        <p class="text-muted mb-0">Update your news article</p>
    </div>
    <div>
        <a href="{{ route('admin.news.show', $news) }}" class="btn btn-outline-info me-2">
            <i class="fas fa-eye me-2"></i>
            View Article
        </a>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Back to News
        </a>
    </div>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <h6><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h6>
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Main Content Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Article Content</h5>
                </div>
                <div class="card-body">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title', $news->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Short Description -->
                    <div class="mb-3">
                        <label for="short_description" class="form-label">Short Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                  id="short_description" name="short_description" rows="3" 
                                  placeholder="Brief summary of the article (max 500 characters)" required>{{ old('short_description', $news->short_description) }}</textarea>
                        <div class="form-text">This will be displayed in article previews and search results.</div>
                        @error('short_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rich Text Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Article Content <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="15" required>{{ old('description', $news->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Current Media -->
            @if($news->images || $news->video_path || $news->youtube_link)
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Current Media</h5>
                </div>
                <div class="card-body">
                    @if($news->images && count($news->images) > 0)
                        <div class="mb-3">
                            <label class="form-label">Current Images</label>
                            <div class="row">
                                @foreach($news->images as $image)
                                    <div class="col-md-3 mb-2">
                                        <img src="{{ asset('storage/' . $image) }}" 
                                             class="img-thumbnail" 
                                             style="width: 100%; height: 150px; object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($news->video_path)
                        <div class="mb-3">
                            <label class="form-label">Current Video</label>
                            <video controls class="w-100" style="max-height: 300px;">
                                <source src="{{ asset('storage/' . $news->video_path) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    @endif

                    @if($news->youtube_link)
                        <div class="mb-3">
                            <label class="form-label">Current YouTube Video</label>
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ $news->youtube_embed_url }}" allowfullscreen></iframe>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Media Upload Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update Media Content</h5>
                </div>
                <div class="card-body">
                    <!-- Multiple Images Upload -->
                    <div class="mb-3">
                        <label for="images" class="form-label">Replace Images</label>
                        <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                               id="images" name="images[]" multiple accept="image/*">
                        <div class="form-text">Select new images to replace existing ones. Supported formats: JPEG, PNG, JPG, GIF (Max: 2MB each)</div>
                        @error('images.*')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div id="imagePreview" class="mt-3 row"></div>
                    </div>

                    <!-- Video Upload -->
                    <div class="mb-3">
                        <label for="video" class="form-label">Replace Video</label>
                        <input type="file" class="form-control @error('video') is-invalid @enderror" 
                               id="video" name="video" accept="video/*">
                        <div class="form-text">Upload a new video to replace the existing one. Supported formats: MP4, AVI, MOV, WMV (Max: 20MB)</div>
                        @error('video')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- YouTube Link -->
                    <div class="mb-3">
                        <label for="youtube_link" class="form-label">YouTube Link</label>
                        <input type="url" class="form-control @error('youtube_link') is-invalid @enderror" 
                               id="youtube_link" name="youtube_link" value="{{ old('youtube_link', $news->youtube_link) }}" 
                               placeholder="https://www.youtube.com/watch?v=...">
                        <div class="form-text">Paste a YouTube video URL to embed it in the article</div>
                        @error('youtube_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Article Stats -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Article Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ number_format($news->views) }}</h4>
                                <small class="text-muted">Views</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info mb-1">{{ $news->created_at->diffForHumans() }}</h4>
                            <small class="text-muted">Created</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Publishing Options -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Publishing Options</h5>
                </div>
                <div class="card-body">
                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('status', $news->status) == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Published Date -->
                    <div class="mb-3">
                        <label for="published_at" class="form-label">Publish Date</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                               id="published_at" name="published_at" 
                               value="{{ old('published_at', $news->published_at ? $news->published_at->format('Y-m-d\TH:i') : '') }}">
                        <div class="form-text">Leave empty to use current date when publishing</div>
                        @error('published_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Featured -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" 
                                   value="1" {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_featured">
                                <i class="fas fa-star text-warning me-1"></i>
                                Featured Article
                            </label>
                        </div>
                        <div class="form-text">Featured articles will be highlighted on the homepage</div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card">
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            Update Article
                        </button>
                        <button type="button" class="btn btn-outline-secondary" onclick="saveDraft()">
                            <i class="fas fa-file-alt me-2"></i>
                            Save as Draft
                        </button>
                        <a href="{{ route('admin.news.show', $news) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-2"></i>
                            Preview Article
                        </a>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-danger">
                            <i class="fas fa-times me-2"></i>
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
.ql-editor {
    min-height: 300px;
}
.image-preview {
    position: relative;
    display: inline-block;
}
.image-preview .remove-image {
    position: absolute;
    top: 5px;
    right: 5px;
    background: rgba(255, 0, 0, 0.8);
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    font-size: 12px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
// Initialize Quill Rich Text Editor
var quill = new Quill('#description', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['link', 'image', 'video'],
            ['clean']
        ]
    }
});

// Set initial content
quill.root.innerHTML = document.querySelector('#description').value;

// Update hidden textarea when form is submitted
document.querySelector('form').addEventListener('submit', function() {
    document.querySelector('#description').value = quill.root.innerHTML;
});

// Image preview functionality
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    Array.from(e.target.files).forEach((file, index) => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const col = document.createElement('div');
                col.className = 'col-md-4 mb-3';
                col.innerHTML = `
                    <div class="image-preview">
                        <img src="${e.target.result}" class="img-thumbnail" style="width: 100%; height: 150px; object-fit: cover;">
                        <button type="button" class="btn btn-sm remove-image" onclick="removeImage(${index})">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                preview.appendChild(col);
            };
            reader.readAsDataURL(file);
        }
    });
});

function removeImage(index) {
    const preview = document.getElementById('imagePreview');
    const images = preview.children;
    if (images[index]) {
        images[index].remove();
    }
}

function saveDraft() {
    document.getElementById('status').value = 'draft';
    document.querySelector('form').submit();
}

// Auto-save functionality (optional)
let autoSaveTimer;
function autoSave() {
    clearTimeout(autoSaveTimer);
    autoSaveTimer = setTimeout(() => {
        console.log('Auto-saving...');
    }, 30000);
}

// Trigger auto-save on content change
quill.on('text-change', autoSave);
document.getElementById('title').addEventListener('input', autoSave);
document.getElementById('short_description').addEventListener('input', autoSave);
</script>
@endpush