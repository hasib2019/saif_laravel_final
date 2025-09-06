@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Product: {{ $product->name }}</h5>
                    <div>
                        <a href="{{ route('admin.products.show', $product) }}" class="btn btn-info btn-sm me-2">
                            <i class="fas fa-eye me-1"></i>View
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Products
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $product->name) }}" 
                                           placeholder="Enter product name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" name="slug" value="{{ old('slug', $product->slug) }}" 
                                           placeholder="Auto-generated from name" readonly>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text">$</span>
                                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                                               id="price" name="price" value="{{ old('price', $product->price) }}" 
                                               step="0.01" min="0" placeholder="0.00" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            
                            @if($product->image)
                                <div class="mb-2">
                                    <label class="form-label text-muted">Current Image:</label>
                                    <div>
                                        <img src="{{ asset('images/products/' . $product->image) }}" 
                                             alt="{{ $product->name }}" class="img-thumbnail" 
                                             style="max-width: 200px; max-height: 200px;">
                                    </div>
                                </div>
                            @endif
                            
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Leave empty to keep current image. Supported formats: JPG, PNG, GIF. Max size: 2MB</div>
                            
                            <!-- New Image Preview -->
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <label class="form-label text-muted">New Image Preview:</label>
                                <div>
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="pdf_file" class="form-label">PDF File</label>
                            
                            @if($product->pdf_file)
                                <div class="mb-2">
                                    <label class="form-label text-muted">Current PDF:</label>
                                    <div>
                                        <a href="{{ asset('files/products/' . $product->pdf_file) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                            <i class="fas fa-file-pdf me-1"></i>{{ $product->pdf_file }}
                                        </a>
                                    </div>
                                </div>
                            @endif
                            
                            <input type="file" class="form-control @error('pdf_file') is-invalid @enderror" 
                                   id="pdf_file" name="pdf_file" accept=".pdf">
                            @error('pdf_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Leave empty to keep current PDF. Upload a PDF file (max 10MB)</div>
                        </div>

                        <div class="mb-3">
                            <label for="video_file" class="form-label">Video File</label>
                            
                            @if($product->video_file)
                                <div class="mb-2">
                                    <label class="form-label text-muted">Current Video:</label>
                                    <div>
                                        <video width="200" height="150" controls class="img-thumbnail">
                                            <source src="{{ asset('videos/products/' . $product->video_file) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <br><small class="text-muted">{{ $product->video_file }}</small>
                                    </div>
                                </div>
                            @endif
                            
                            <input type="file" class="form-control @error('video_file') is-invalid @enderror" 
                                   id="video_file" name="video_file" accept="video/*">
                            @error('video_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Leave empty to keep current video. Upload a video file (max 50MB)</div>
                        </div>

                        <div class="mb-3">
                            <label for="video_link" class="form-label">Video Link (YouTube/Vimeo)</label>
                            <input type="url" class="form-control @error('video_link') is-invalid @enderror" 
                                   id="video_link" name="video_link" value="{{ old('video_link', $product->video_link) }}" 
                                   placeholder="https://www.youtube.com/watch?v=...">
                            @error('video_link')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Enter a YouTube or Vimeo video URL</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" 
                                               name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            Active Status
                                        </label>
                                    </div>
                                    <div class="form-text">Enable this product for display</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_featured" 
                                               name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Featured Product
                                        </label>
                                    </div>
                                    <div class="form-text">Show in featured products section</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Product Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ $product->category->name }}</h4>
                                <small class="text-muted">Category</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-1">${{ number_format($product->price, 2) }}</h4>
                            <small class="text-muted">Price</small>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }} mb-1">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
                                <br><small class="text-muted">Status</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <span class="badge {{ $product->is_featured ? 'bg-warning' : 'bg-secondary' }} mb-1">{{ $product->is_featured ? 'Featured' : 'Regular' }}</span>
                            <br><small class="text-muted">Type</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Editing Guidelines</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-lightbulb me-1"></i>Editing Tips</h6>
                        <ul class="mb-0 small">
                            <li>Changes will be saved immediately</li>
                            <li>Slug will update automatically when name changes</li>
                            <li>Leave image field empty to keep current image</li>
                            <li>Featured products appear on homepage</li>
                        </ul>
                    </div>
                    
                    <div class="alert alert-secondary">
                        <h6><i class="fas fa-clock me-1"></i>Product Info</h6>
                        <ul class="mb-0 small">
                            <li><strong>Created:</strong> {{ $product->created_at->format('M d, Y') }}</li>
                            <li><strong>Updated:</strong> {{ $product->updated_at->format('M d, Y') }}</li>
                            <li><strong>ID:</strong> #{{ $product->id }}</li>
                        </ul>
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
    // Auto-generate slug from name
    $('#name').on('input', function() {
        let name = $(this).val();
        let slug = name.toLowerCase()
            .replace(/[^\w\s-]/g, '') // Remove special characters
            .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with hyphens
            .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
        $('#slug').val(slug);
    });
    
    // Image preview
    $('#image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#imagePreview').show();
            };
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
        }
    });
});
</script>
@endpush