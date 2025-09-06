@extends('admin.layouts.app')

@section('title', 'Video Section Setup')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-video me-2"></i>Video Section Setup
                    </h3>
                    <a href="{{ route('admin.website-setup.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.website-setup.update-video-section') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column - Form Fields -->
                            <div class="col-md-8">
                                <!-- Badge Text -->
                                <div class="mb-3">
                                    <label for="video_badge_text" class="form-label">
                                        <i class="fas fa-tag me-1"></i>Badge Text
                                    </label>
                                    <input type="text" class="form-control @error('video_badge_text') is-invalid @enderror" 
                                           id="video_badge_text" name="video_badge_text" 
                                           value="{{ old('video_badge_text', $settings->video_badge_text) }}" 
                                           placeholder="e.g., New launch">
                                    @error('video_badge_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Title Line 1 -->
                                <div class="mb-3">
                                    <label for="video_title_line1" class="form-label">
                                        <i class="fas fa-heading me-1"></i>Title Line 1
                                    </label>
                                    <input type="text" class="form-control @error('video_title_line1') is-invalid @enderror" 
                                           id="video_title_line1" name="video_title_line1" 
                                           value="{{ old('video_title_line1', $settings->video_title_line1) }}" 
                                           placeholder="e.g., We pioneer.">
                                    @error('video_title_line1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Title Line 2 -->
                                <div class="mb-3">
                                    <label for="video_title_line2" class="form-label">
                                        <i class="fas fa-heading me-1"></i>Title Line 2
                                    </label>
                                    <input type="text" class="form-control @error('video_title_line2') is-invalid @enderror" 
                                           id="video_title_line2" name="video_title_line2" 
                                           value="{{ old('video_title_line2', $settings->video_title_line2) }}" 
                                           placeholder="e.g., You lead.">
                                    @error('video_title_line2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Subtitle -->
                                <div class="mb-3">
                                    <label for="video_subtitle" class="form-label">
                                        <i class="fas fa-align-left me-1"></i>Subtitle
                                    </label>
                                    <textarea class="form-control @error('video_subtitle') is-invalid @enderror" 
                                              id="video_subtitle" name="video_subtitle" rows="3" 
                                              placeholder="Enter the subtitle text...">{{ old('video_subtitle', $settings->video_subtitle) }}</textarea>
                                    @error('video_subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Video File Upload -->
                                <div class="mb-3">
                                    <label for="video_file" class="form-label">
                                        <i class="fas fa-upload me-1"></i>Video File (Optional)
                                    </label>
                                    <input type="file" class="form-control @error('video_file') is-invalid @enderror" 
                                           id="video_file" name="video_file" accept=".mp4,.avi,.mov">
                                    <div class="form-text">
                                        Supported formats: MP4, AVI, MOV. Maximum size: 50MB.
                                        @if($settings->video_file_path)
                                            <br><strong>Current file:</strong> {{ basename($settings->video_file_path) }}
                                        @endif
                                    </div>
                                    @error('video_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>Update Video Section
                                    </button>
                                </div>
                            </div>

                            <!-- Right Column - Preview -->
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-header">
                                        <h6 class="mb-0">
                                            <i class="fas fa-eye me-1"></i>Preview
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <!-- Video Preview -->
                                        @if($settings->video_file_path)
                                            <div class="mb-3">
                                                <video width="100%" height="200" controls style="border-radius: 8px;">
                                                    <source src="{{ asset($settings->video_file_path) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            </div>
                                        @endif
                                        
                                        <!-- Text Preview -->
                                        <div class="preview-section p-3 bg-dark text-white rounded" style="min-height: 150px; position: relative;">
                                            <div class="badge bg-light text-dark mb-2 d-inline-block" id="preview-badge">
                                                {{ $settings->video_badge_text }}
                                            </div>
                                            <h2 class="h4 mb-1" id="preview-title1">{{ $settings->video_title_line1 }}</h2>
                                            <h2 class="h4 mb-3" id="preview-title2" style="color: #ff0000;">{{ $settings->video_title_line2 }}</h2>
                                            <p class="small" id="preview-subtitle">{{ $settings->video_subtitle }}</p>
                                        </div>
                                        <small class="text-muted mt-2 d-block">
                                            <i class="fas fa-info-circle me-1"></i>This is how your video section will appear on the website.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Live preview updates
document.addEventListener('DOMContentLoaded', function() {
    // Badge text preview
    document.getElementById('video_badge_text').addEventListener('input', function() {
        document.getElementById('preview-badge').textContent = this.value || 'Badge Text';
    });
    
    // Title line 1 preview
    document.getElementById('video_title_line1').addEventListener('input', function() {
        document.getElementById('preview-title1').textContent = this.value || 'Title Line 1';
    });
    
    // Title line 2 preview
    document.getElementById('video_title_line2').addEventListener('input', function() {
        document.getElementById('preview-title2').textContent = this.value || 'Title Line 2';
    });
    
    // Subtitle preview
    document.getElementById('video_subtitle').addEventListener('input', function() {
        document.getElementById('preview-subtitle').textContent = this.value || 'Subtitle text...';
    });
});
</script>
@endpush
@endsection