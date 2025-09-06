@extends('admin.layouts.app')

@section('title', 'Footer Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-edit me-2"></i>Footer Settings
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

                <form action="{{ route('admin.website-setup.update-footer-settings') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="card-body">
                        <div class="row">
                            <!-- Footer Description -->
                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="footer_description" class="form-label">
                                        <i class="fas fa-info-circle me-1"></i>Footer Description
                                    </label>
                                    <textarea class="form-control @error('footer_description') is-invalid @enderror" 
                                              id="footer_description" 
                                              name="footer_description" 
                                              rows="3" 
                                              placeholder="Enter footer description">{{ old('footer_description', $settings->footer_description) }}</textarea>
                                    @error('footer_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Contact Information -->
                            <div class="col-md-6 mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-address-book me-2"></i>Contact Information
                                </h5>
                                
                                <div class="form-group mb-3">
                                    <label for="footer_address" class="form-label">
                                        <i class="fas fa-map-marker-alt me-1"></i>Address
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('footer_address') is-invalid @enderror" 
                                           id="footer_address" 
                                           name="footer_address" 
                                           value="{{ old('footer_address', $settings->footer_address) }}" 
                                           placeholder="123 Business Street, City, Country">
                                    @error('footer_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="footer_phone" class="form-label">
                                        <i class="fas fa-phone me-1"></i>Phone Number
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('footer_phone') is-invalid @enderror" 
                                           id="footer_phone" 
                                           name="footer_phone" 
                                           value="{{ old('footer_phone', $settings->footer_phone) }}" 
                                           placeholder="+1 (555) 123-4567">
                                    @error('footer_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="footer_email" class="form-label">
                                        <i class="fas fa-envelope me-1"></i>Email Address
                                    </label>
                                    <input type="email" 
                                           class="form-control @error('footer_email') is-invalid @enderror" 
                                           id="footer_email" 
                                           name="footer_email" 
                                           value="{{ old('footer_email', $settings->footer_email) }}" 
                                           placeholder="info@company.com">
                                    @error('footer_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Legal Information -->
                            <div class="col-md-6 mb-4">
                                <h5 class="text-success mb-3">
                                    <i class="fas fa-gavel me-2"></i>Legal Information
                                </h5>
                                
                                <div class="form-group mb-3">
                                    <label for="footer_copyright" class="form-label">
                                        <i class="fas fa-copyright me-1"></i>Copyright Text
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('footer_copyright') is-invalid @enderror" 
                                           id="footer_copyright" 
                                           name="footer_copyright" 
                                           value="{{ old('footer_copyright', $settings->footer_copyright) }}" 
                                           placeholder="© 2025 Laravel. All rights reserved">
                                    @error('footer_copyright')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="footer_privacy_policy" class="form-label">
                                        <i class="fas fa-shield-alt me-1"></i>Privacy Policy Text
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('footer_privacy_policy') is-invalid @enderror" 
                                           id="footer_privacy_policy" 
                                           name="footer_privacy_policy" 
                                           value="{{ old('footer_privacy_policy', $settings->footer_privacy_policy) }}" 
                                           placeholder="Privacy Policy">
                                    @error('footer_privacy_policy')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="footer_terms_service" class="form-label">
                                        <i class="fas fa-file-contract me-1"></i>Terms of Service Text
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('footer_terms_service') is-invalid @enderror" 
                                           id="footer_terms_service" 
                                           name="footer_terms_service" 
                                           value="{{ old('footer_terms_service', $settings->footer_terms_service) }}" 
                                           placeholder="Terms of Service">
                                    @error('footer_terms_service')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.website-setup.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Footer Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection