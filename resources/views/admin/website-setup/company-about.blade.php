@extends('admin.layouts.app')

@section('title', 'Company About Section Setup')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-building me-2"></i>Company About Section Setup
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

                    <form action="{{ route('admin.website-setup.update-company-about') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column - Basic Information -->
                            <div class="col-md-6">
                                <h5 class="mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Basic Information
                                </h5>

                                <!-- Company Title -->
                                <div class="mb-3">
                                    <label for="company_title" class="form-label">
                                        <i class="fas fa-heading me-1"></i>Company Title
                                    </label>
                                    <input type="text" class="form-control @error('company_title') is-invalid @enderror" 
                                           id="company_title" name="company_title" 
                                           value="{{ old('company_title', $settings->company_title) }}" 
                                           placeholder="e.g., About DEROWN Tech">
                                    @error('company_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Short Description -->
                                <div class="mb-3">
                                    <label for="company_short_description" class="form-label">
                                        <i class="fas fa-align-left me-1"></i>Short Description
                                    </label>
                                    <textarea class="form-control @error('company_short_description') is-invalid @enderror" 
                                              id="company_short_description" name="company_short_description" rows="3" 
                                              placeholder="Brief description of your company...">{{ old('company_short_description', $settings->company_short_description) }}</textarea>
                                    @error('company_short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Full Description -->
                                <div class="mb-3">
                                    <label for="company_description" class="form-label">
                                        <i class="fas fa-file-alt me-1"></i>Full Description
                                    </label>
                                    <textarea class="form-control @error('company_description') is-invalid @enderror" 
                                              id="company_description" name="company_description" rows="5" 
                                              placeholder="Detailed description of your company...">{{ old('company_description', $settings->company_description) }}</textarea>
                                    @error('company_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column - Statistics -->
                            <div class="col-md-6">
                                <h5 class="mb-3">
                                    <i class="fas fa-chart-bar me-2"></i>Company Statistics
                                </h5>

                                <div class="row">
                                    <!-- Happy Clients -->
                                    <div class="col-md-6 mb-3">
                                        <label for="happy_clients" class="form-label">
                                            <i class="fas fa-smile me-1"></i>Happy Clients
                                        </label>
                                        <input type="number" class="form-control @error('happy_clients') is-invalid @enderror" 
                                               id="happy_clients" name="happy_clients" 
                                               value="{{ old('happy_clients', $settings->happy_clients) }}" 
                                               placeholder="500" min="0">
                                        @error('happy_clients')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Awards Won -->
                                    <div class="col-md-6 mb-3">
                                        <label for="awards_won" class="form-label">
                                            <i class="fas fa-trophy me-1"></i>Awards Won
                                        </label>
                                        <input type="number" class="form-control @error('awards_won') is-invalid @enderror" 
                                               id="awards_won" name="awards_won" 
                                               value="{{ old('awards_won', $settings->awards_won) }}" 
                                               placeholder="25" min="0">
                                        @error('awards_won')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Projects Completed -->
                                    <div class="col-md-6 mb-3">
                                        <label for="projects_completed" class="form-label">
                                            <i class="fas fa-project-diagram me-1"></i>Projects Completed
                                        </label>
                                        <input type="number" class="form-control @error('projects_completed') is-invalid @enderror" 
                                               id="projects_completed" name="projects_completed" 
                                               value="{{ old('projects_completed', $settings->projects_completed) }}" 
                                               placeholder="1000" min="0">
                                        @error('projects_completed')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Years of Experience -->
                                    <div class="col-md-6 mb-3">
                                        <label for="years_experience" class="form-label">
                                            <i class="fas fa-calendar-alt me-1"></i>Years of Experience
                                        </label>
                                        <input type="number" class="form-control @error('years_experience') is-invalid @enderror" 
                                               id="years_experience" name="years_experience" 
                                               value="{{ old('years_experience', $settings->years_experience) }}" 
                                               placeholder="10" min="0">
                                        @error('years_experience')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Company Features -->
                                <h6 class="mb-3 mt-4">
                                    <i class="fas fa-star me-2"></i>Company Features
                                </h6>

                                <!-- Feature 1 -->
                                <div class="mb-3">
                                    <label for="industry_leadership" class="form-label">
                                        <i class="fas fa-star text-warning me-1"></i>Industry Leadership
                                    </label>
                                    <input type="text" class="form-control @error('industry_leadership') is-invalid @enderror" 
                                           id="industry_leadership" name="industry_leadership" 
                                           value="{{ old('industry_leadership', $settings->industry_leadership) }}" 
                                           placeholder="e.g., Recognized as pioneers in our field">
                                    @error('industry_leadership')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Feature 2 -->
                                <div class="mb-3">
                                    <label for="quality_standards" class="form-label">
                                        <i class="fas fa-award text-success me-1"></i>Quality Standards
                                    </label>
                                    <input type="text" class="form-control @error('quality_standards') is-invalid @enderror" 
                                           id="quality_standards" name="quality_standards" 
                                           value="{{ old('quality_standards', $settings->quality_standards) }}" 
                                           placeholder="e.g., Committed to maintaining highest quality">
                                    @error('quality_standards')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Feature 3 -->
                                <div class="mb-3">
                                    <label for="innovative_design" class="form-label">
                                        <i class="fas fa-lightbulb text-info me-1"></i>Innovative Design
                                    </label>
                                    <input type="text" class="form-control @error('innovative_design') is-invalid @enderror" 
                                           id="innovative_design" name="innovative_design" 
                                           value="{{ old('innovative_design', $settings->innovative_design) }}" 
                                           placeholder="e.g., Continuous research to develop solutions">
                                    @error('innovative_design')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>Update Company About Section
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">
                    <i class="fas fa-eye me-2"></i>Preview Company About Section
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="preview-content">
                    <div class="text-center mb-4">
                        <h2 id="preview-title">{{ $settings->company_title }}</h2>
                        <p class="text-muted" id="preview-short-desc">{{ $settings->company_short_description }}</p>
                    </div>
                    
                    <div class="row text-center mb-4">
                        <div class="col-3">
                            <div class="stat-item">
                                <h3 class="text-primary" id="preview-clients">{{ $settings->happy_clients }}+</h3>
                                <p class="mb-0">Happy Clients</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="stat-item">
                                <h3 class="text-success" id="preview-awards">{{ $settings->awards_won }}+</h3>
                                <p class="mb-0">Awards Won</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="stat-item">
                                <h3 class="text-info" id="preview-projects">{{ $settings->projects_completed }}+</h3>
                                <p class="mb-0">Projects Completed</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="stat-item">
                                <h3 class="text-warning" id="preview-years">{{ $settings->years_experience }}+</h3>
                                <p class="mb-0">Years Experience</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p id="preview-description">{{ $settings->company_description }}</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span id="preview-feature1">{{ $settings->industry_leadership }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span id="preview-feature2">{{ $settings->quality_standards }}</span>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="feature-item">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <span id="preview-feature3">{{ $settings->innovative_design }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Preview Button -->
<div class="position-fixed bottom-0 end-0 p-3">
    <button type="button" class="btn btn-info btn-lg rounded-circle" data-bs-toggle="modal" data-bs-target="#previewModal" title="Preview">
        <i class="fas fa-eye"></i>
    </button>
</div>

@push('scripts')
<script>
// Live preview updates
document.addEventListener('DOMContentLoaded', function() {
    // Update preview when modal is shown
    document.getElementById('previewModal').addEventListener('show.bs.modal', function() {
        updatePreview();
    });
    
    function updatePreview() {
        // Update title
        document.getElementById('preview-title').textContent = 
            document.getElementById('company_title').value || 'Company Title';
        
        // Update short description
        document.getElementById('preview-short-desc').textContent = 
            document.getElementById('company_short_description').value || 'Short description...';
        
        // Update description
        document.getElementById('preview-description').textContent = 
            document.getElementById('company_description').value || 'Full description...';
        
        // Update statistics
        document.getElementById('preview-clients').textContent = 
            (document.getElementById('happy_clients').value || '0') + '+';
        document.getElementById('preview-awards').textContent = 
            (document.getElementById('awards_won').value || '0') + '+';
        document.getElementById('preview-projects').textContent = 
            (document.getElementById('projects_completed').value || '0') + '+';
        document.getElementById('preview-years').textContent = 
            (document.getElementById('years_experience').value || '0') + '+';
        
        // Update features
                        document.getElementById('preview-feature1').textContent = 
                            document.getElementById('industry_leadership').value || 'Industry Leadership';
                        document.getElementById('preview-feature2').textContent = 
                            document.getElementById('quality_standards').value || 'Quality Standards';
                        document.getElementById('preview-feature3').textContent = 
                            document.getElementById('innovative_design').value || 'Innovative Design';
    }
});
</script>
@endpush
@endsection