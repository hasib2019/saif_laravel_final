@extends('admin.layouts.app')

@section('title', 'Site Identity & SEO Setup')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-globe me-2"></i>Site Identity & SEO Setup
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.website-setup.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('admin.website-setup.update-site-identity') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <!-- Site Identity Section -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card border-primary mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-id-card me-2"></i>Site Identity
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Site Name -->
                                        <div class="mb-3">
                                            <label for="site_name" class="form-label">
                                                <i class="fas fa-tag me-1"></i>Site Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('site_name') is-invalid @enderror" 
                                                   id="site_name" name="site_name" 
                                                   value="{{ old('site_name', $settings->site_name) }}" 
                                                   placeholder="Enter site name" required>
                                            @error('site_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Logo Upload -->
                                        <div class="mb-3">
                                            <label for="logo" class="form-label">
                                                <i class="fas fa-image me-1"></i>Logo
                                            </label>
                                            @if($settings->logo_path)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $settings->logo_path) }}" 
                                                         alt="Current Logo" class="img-thumbnail" style="max-height: 100px;">
                                                    <p class="text-muted small mt-1">Current logo</p>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                                   id="logo" name="logo" accept="image/*">
                                            <div class="form-text">Upload a new logo (JPG, PNG, SVG). Recommended size: 200x60px</div>
                                            @error('logo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Favicon Upload -->
                                        <div class="mb-3">
                                            <label for="favicon" class="form-label">
                                                <i class="fas fa-star me-1"></i>Favicon
                                            </label>
                                            @if($settings->favicon_path)
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $settings->favicon_path) }}" 
                                                         alt="Current Favicon" class="img-thumbnail" style="max-height: 32px;">
                                                    <p class="text-muted small mt-1">Current favicon</p>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control @error('favicon') is-invalid @enderror" 
                                                   id="favicon" name="favicon" accept="image/*">
                                            <div class="form-text">Upload favicon (ICO, PNG). Recommended size: 32x32px or 16x16px</div>
                                            @error('favicon')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Section -->
                            <div class="col-md-6">
                                <div class="card border-success mb-4">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">
                                            <i class="fas fa-search me-2"></i>SEO Settings
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Meta Title -->
                                        <div class="mb-3">
                                            <label for="meta_title" class="form-label">
                                                <i class="fas fa-heading me-1"></i>Meta Title <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                                   id="meta_title" name="meta_title" 
                                                   value="{{ old('meta_title', $settings->meta_title) }}" 
                                                   placeholder="Enter meta title" maxlength="60" required>
                                            <div class="form-text">Recommended length: 50-60 characters</div>
                                            @error('meta_title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Meta Description -->
                                        <div class="mb-3">
                                            <label for="meta_description" class="form-label">
                                                <i class="fas fa-align-left me-1"></i>Meta Description <span class="text-danger">*</span>
                                            </label>
                                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                                      id="meta_description" name="meta_description" rows="3" 
                                                      placeholder="Enter meta description" maxlength="160" required>{{ old('meta_description', $settings->meta_description) }}</textarea>
                                            <div class="form-text">Recommended length: 150-160 characters</div>
                                            @error('meta_description')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Meta Keywords -->
                                        <div class="mb-3">
                                            <label for="meta_keywords" class="form-label">
                                                <i class="fas fa-tags me-1"></i>Meta Keywords
                                            </label>
                                            <textarea class="form-control @error('meta_keywords') is-invalid @enderror" 
                                                      id="meta_keywords" name="meta_keywords" rows="2" 
                                                      placeholder="Enter keywords separated by commas">{{ old('meta_keywords', $settings->meta_keywords) }}</textarea>
                                            <div class="form-text">Separate keywords with commas</div>
                                            @error('meta_keywords')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Open Graph Section -->
                        <div class="row">
                            <div class="col-12">
                                <div class="card border-info mb-4">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0">
                                            <i class="fab fa-facebook me-2"></i>Open Graph (Social Media)
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <!-- OG Title -->
                                                <div class="mb-3">
                                                    <label for="og_title" class="form-label">
                                                        <i class="fas fa-heading me-1"></i>OG Title
                                                    </label>
                                                    <input type="text" class="form-control @error('og_title') is-invalid @enderror" 
                                                           id="og_title" name="og_title" 
                                                           value="{{ old('og_title', $settings->og_title) }}" 
                                                           placeholder="Enter Open Graph title">
                                                    <div class="form-text">Title for social media sharing</div>
                                                    @error('og_title')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <!-- OG Description -->
                                                <div class="mb-3">
                                                    <label for="og_description" class="form-label">
                                                        <i class="fas fa-align-left me-1"></i>OG Description
                                                    </label>
                                                    <textarea class="form-control @error('og_description') is-invalid @enderror" 
                                                              id="og_description" name="og_description" rows="3" 
                                                              placeholder="Enter Open Graph description">{{ old('og_description', $settings->og_description) }}</textarea>
                                                    <div class="form-text">Description for social media sharing</div>
                                                    @error('og_description')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <!-- OG Image -->
                                                <div class="mb-3">
                                                    <label for="og_image" class="form-label">
                                                        <i class="fas fa-image me-1"></i>OG Image
                                                    </label>
                                                    @if($settings->og_image_path)
                                                        <div class="mb-2">
                                                            <img src="{{ asset('storage/' . $settings->og_image_path) }}" 
                                                                 alt="Current OG Image" class="img-thumbnail" style="max-height: 150px;">
                                                            <p class="text-muted small mt-1">Current OG image</p>
                                                        </div>
                                                    @endif
                                                    <input type="file" class="form-control @error('og_image') is-invalid @enderror" 
                                                           id="og_image" name="og_image" accept="image/*">
                                                    <div class="form-text">Image for social media sharing. Recommended size: 1200x630px</div>
                                                    @error('og_image')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.website-setup.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Character counter for meta fields
document.addEventListener('DOMContentLoaded', function() {
    const metaTitle = document.getElementById('meta_title');
    const metaDescription = document.getElementById('meta_description');
    
    function updateCounter(element, maxLength) {
        const current = element.value.length;
        const formText = element.nextElementSibling;
        if (formText && formText.classList.contains('form-text')) {
            const color = current > maxLength ? 'text-danger' : current > maxLength * 0.8 ? 'text-warning' : 'text-muted';
            formText.className = `form-text ${color}`;
            formText.textContent = `${current}/${maxLength} characters`;
        }
    }
    
    if (metaTitle) {
        metaTitle.addEventListener('input', () => updateCounter(metaTitle, 60));
        updateCounter(metaTitle, 60);
    }
    
    if (metaDescription) {
        metaDescription.addEventListener('input', () => updateCounter(metaDescription, 160));
        updateCounter(metaDescription, 160);
    }
});
</script>
@endpush