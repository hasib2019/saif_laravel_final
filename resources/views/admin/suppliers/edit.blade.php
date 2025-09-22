@extends('admin.layouts.app')

@section('title', 'Edit Supplier')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Supplier: {{ $supplier->name }}</h5>
                    <div>
                        <a href="{{ route('admin.suppliers.show', $supplier) }}" class="btn btn-info me-2">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                        <a href="{{ route('admin.suppliers.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i>Back to List
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.suppliers.update', $supplier) }}" method="POST" enctype="multipart/form-data" id="supplierForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Supplier Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $supplier->name) }}" 
                                           placeholder="Enter supplier name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Supplier Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" name="slug" value="{{ old('slug', $supplier->slug) }}" 
                                           placeholder="supplier-slug">
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">URL-friendly version of the name</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea class="form-control @error('short_description') is-invalid @enderror" 
                                      id="short_description" name="short_description" rows="3" 
                                      placeholder="Brief description of the supplier" maxlength="500">{{ old('short_description', $supplier->short_description) }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Maximum 500 characters</small>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Full Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="8" 
                                      placeholder="Detailed description of the supplier">{{ old('description', $supplier->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="images" class="form-label">Supplier Images</label>
                                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                                           id="images" name="images[]" multiple accept="image/*">
                                    @error('images.*')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Select new images to replace existing ones (JPEG, PNG, JPG, GIF - Max 2MB each)</small>
                                    
                                    @if($supplier->images && is_array($supplier->images) && count($supplier->images) > 0)
                                        <div class="mt-2">
                                            <small class="text-muted">Current images:</small>
                                            <div class="row mt-1">
                                                @foreach($supplier->images as $image)
                                                    <div class="col-3 mb-2">
                                                        <img src="{{ asset('storage/' . $image) }}" class="img-thumbnail" style="height: 60px; object-fit: cover;">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="pdf_file" class="form-label">PDF Document</label>
                                    <input type="file" class="form-control @error('pdf_file') is-invalid @enderror" 
                                           id="pdf_file" name="pdf_file" accept=".pdf">
                                    @error('pdf_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">PDF file (Max 10MB)</small>
                                    
                                    @if($supplier->pdf_file)
                                        <div class="mt-2">
                                            <small class="text-muted">Current PDF:</small>
                                            <div class="d-flex align-items-center mt-1">
                                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                                <a href="{{ asset('storage/' . $supplier->pdf_file) }}" target="_blank" class="text-decoration-none">
                                                    View Current PDF
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="video_file" class="form-label">Video File</label>
                                    <input type="file" class="form-control @error('video_file') is-invalid @enderror" 
                                           id="video_file" name="video_file" accept="video/*">
                                    @error('video_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Video file (MP4, AVI, MOV, WMV - Max 50MB)</small>
                                    
                                    @if($supplier->video_file)
                                        <div class="mt-2">
                                            <small class="text-muted">Current video:</small>
                                            <div class="d-flex align-items-center mt-1">
                                                <i class="fas fa-video text-primary me-2"></i>
                                                <a href="{{ asset('storage/' . $supplier->video_file) }}" target="_blank" class="text-decoration-none">
                                                    View Current Video
                                                </a>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="youtube_link" class="form-label">YouTube Link</label>
                                    <input type="url" class="form-control @error('youtube_link') is-invalid @enderror" 
                                           id="youtube_link" name="youtube_link" value="{{ old('youtube_link', $supplier->youtube_link) }}" 
                                           placeholder="https://www.youtube.com/watch?v=...">
                                    @error('youtube_link')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">YouTube video URL</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sort_order" class="form-label">Sort Order</label>
                                    <input type="number" class="form-control @error('sort_order') is-invalid @enderror" 
                                           id="sort_order" name="sort_order" value="{{ old('sort_order', $supplier->sort_order) }}" 
                                           min="0" placeholder="0">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Lower numbers appear first</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch mt-4">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Status
                                        </label>
                                    </div>
                                    <small class="form-text text-muted">Enable to make supplier visible on website</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.suppliers.show', $supplier) }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Supplier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Supplier Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Created:</strong><br>
                        <small class="text-muted">{{ $supplier->created_at->format('M d, Y \a\t g:i A') }}</small>
                    </div>
                    <div class="mb-3">
                        <strong>Last Updated:</strong><br>
                        <small class="text-muted">{{ $supplier->updated_at->format('M d, Y \a\t g:i A') }}</small>
                    </div>
                    <div class="mb-3">
                        <strong>Status:</strong><br>
                        @if($supplier->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </div>
                    
                    <div class="alert alert-info">
                        <h6><i class="fas fa-lightbulb me-2"></i>Tips:</h6>
                        <ul class="mb-0 small">
                            <li>Leave file fields empty to keep existing files</li>
                            <li>Uploading new files will replace existing ones</li>
                            <li>Changes to slug will affect the supplier's URL</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from name
    const nameInput = document.getElementById('name');
    const slugInput = document.getElementById('slug');
    
    nameInput.addEventListener('input', function() {
        const name = this.value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        slugInput.value = slug;
    });
    
    // Initialize rich text editor for description
    if (typeof tinymce !== 'undefined') {
        tinymce.init({
            selector: '#description',
            height: 300,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    }
});
</script>
@endsection