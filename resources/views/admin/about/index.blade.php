@extends('admin.layouts.app')

@section('title', 'About Page Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle me-2"></i>About Page Settings
                    </h3>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
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

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.about.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Hero Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-star me-2"></i>Hero Section</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hero_title" class="form-label">Hero Title</label>
                                            <input type="text" class="form-control" id="hero_title" name="hero_title" 
                                                   value="{{ old('hero_title', $settings->hero_title ?? 'About Our Company') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="hero_image" class="form-label">Hero Background Image</label>
                                            <input type="file" class="form-control" id="hero_image" name="hero_image" accept="image/*">
                                            @if($settings && $settings->hero_image)
                                                <div class="mt-2">
                                                    <img src="{{ asset($settings->hero_image) }}" alt="Current Hero Image" class="img-thumbnail" style="max-height: 100px;">
                                                    <small class="text-muted d-block">Current image</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="hero_description" class="form-label">Hero Description</label>
                                            <textarea class="form-control" id="hero_description" name="hero_description" rows="3" required>{{ old('hero_description', $settings->hero_description ?? 'We are dedicated to providing high-quality products and exceptional service to our customers worldwide.') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Our Story Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-book me-2"></i>Our Story Section</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="story_title" class="form-label">Story Title</label>
                                            <input type="text" class="form-control" id="story_title" name="story_title" 
                                                   value="{{ old('story_title', $settings->story_title ?? 'Our Story') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="story_description" class="form-label">Story Description</label>
                                            <textarea class="form-control" id="story_description" name="story_description" rows="4" required>{{ old('story_description', $settings->story_description ?? 'Founded with a vision to deliver excellence, we have grown from a small startup to a leading company in our industry.') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mission & Vision Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-bullseye me-2"></i>Mission & Vision</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="mission_title" class="form-label">Mission Title</label>
                                            <input type="text" class="form-control" id="mission_title" name="mission_title" 
                                                   value="{{ old('mission_title', $settings->mission_title ?? 'Our Mission') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="mission_description" class="form-label">Mission Description</label>
                                            <textarea class="form-control" id="mission_description" name="mission_description" rows="4" required>{{ old('mission_description', $settings->mission_description ?? 'To provide innovative, high-quality products that exceed customer expectations while maintaining the highest standards of service and integrity in everything we do.') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="vision_title" class="form-label">Vision Title</label>
                                            <input type="text" class="form-control" id="vision_title" name="vision_title" 
                                                   value="{{ old('vision_title', $settings->vision_title ?? 'Our Vision') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="vision_description" class="form-label">Vision Description</label>
                                            <textarea class="form-control" id="vision_description" name="vision_description" rows="4" required>{{ old('vision_description', $settings->vision_description ?? 'To be the global leader in our industry, recognized for our commitment to quality, innovation, and customer satisfaction, while contributing positively to our communities.') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Core Values Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-heart me-2"></i>Core Values</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="mb-3">
                                            <label for="values_title" class="form-label">Values Section Title</label>
                                            <input type="text" class="form-control" id="values_title" name="values_title" 
                                                   value="{{ old('values_title', $settings->values_title ?? 'Our Core Values') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="values_description" class="form-label">Values Section Description</label>
                                            <textarea class="form-control" id="values_description" name="values_description" rows="2" required>{{ old('values_description', $settings->values_description ?? 'The principles that guide everything we do') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="quality_title" class="form-label">Quality Title</label>
                                            <input type="text" class="form-control" id="quality_title" name="quality_title" 
                                                   value="{{ old('quality_title', $settings->quality_title ?? 'Quality') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="quality_description" class="form-label">Quality Description</label>
                                            <textarea class="form-control" id="quality_description" name="quality_description" rows="2" required>{{ old('quality_description', $settings->quality_description ?? 'We never compromise on the quality of our products and services.') }}</textarea>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="integrity_title" class="form-label">Integrity Title</label>
                                            <input type="text" class="form-control" id="integrity_title" name="integrity_title" 
                                                   value="{{ old('integrity_title', $settings->integrity_title ?? 'Integrity') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="integrity_description" class="form-label">Integrity Description</label>
                                            <textarea class="form-control" id="integrity_description" name="integrity_description" rows="2" required>{{ old('integrity_description', $settings->integrity_description ?? 'Honesty and transparency in all our business relationships.') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="innovation_title" class="form-label">Innovation Title</label>
                                            <input type="text" class="form-control" id="innovation_title" name="innovation_title" 
                                                   value="{{ old('innovation_title', $settings->innovation_title ?? 'Innovation') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="innovation_description" class="form-label">Innovation Description</label>
                                            <textarea class="form-control" id="innovation_description" name="innovation_description" rows="2" required>{{ old('innovation_description', $settings->innovation_description ?? 'Continuously improving and adapting to meet changing needs.') }}</textarea>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="customer_focus_title" class="form-label">Customer Focus Title</label>
                                            <input type="text" class="form-control" id="customer_focus_title" name="customer_focus_title" 
                                                   value="{{ old('customer_focus_title', $settings->customer_focus_title ?? 'Customer Focus') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="customer_focus_description" class="form-label">Customer Focus Description</label>
                                            <textarea class="form-control" id="customer_focus_description" name="customer_focus_description" rows="2" required>{{ old('customer_focus_description', $settings->customer_focus_description ?? 'Putting our customers at the center of everything we do.') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Team Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-users me-2"></i>Team Section</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="team_title" class="form-label">Team Section Title</label>
                                            <input type="text" class="form-control" id="team_title" name="team_title" 
                                                   value="{{ old('team_title', $settings->team_title ?? 'Meet Our Team') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="team_description" class="form-label">Team Section Description</label>
                                            <textarea class="form-control" id="team_description" name="team_description" rows="2" required>{{ old('team_description', $settings->team_description ?? 'The dedicated professionals behind our success') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Statistics</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="stats_years" class="form-label">Years of Experience</label>
                                            <input type="text" class="form-control" id="stats_years" name="stats_years" 
                                                   value="{{ old('stats_years', $settings->stats_years ?? '10+') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="stats_customers" class="form-label">Happy Customers</label>
                                            <input type="text" class="form-control" id="stats_customers" name="stats_customers" 
                                                   value="{{ old('stats_customers', $settings->stats_customers ?? '1000+') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="stats_products" class="form-label">Products Delivered</label>
                                            <input type="text" class="form-control" id="stats_products" name="stats_products" 
                                                   value="{{ old('stats_products', $settings->stats_products ?? '500+') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="stats_countries" class="form-label">Countries Served</label>
                                            <input type="text" class="form-control" id="stats_countries" name="stats_countries" 
                                                   value="{{ old('stats_countries', $settings->stats_countries ?? '50+') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Call to Action Section -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-phone me-2"></i>Call to Action</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="cta_title" class="form-label">CTA Title</label>
                                            <input type="text" class="form-control" id="cta_title" name="cta_title" 
                                                   value="{{ old('cta_title', $settings->cta_title ?? 'Ready to Work With Us?') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="cta_description" class="form-label">CTA Description</label>
                                            <textarea class="form-control" id="cta_description" name="cta_description" rows="2" required>{{ old('cta_description', $settings->cta_description ?? 'Get in touch with us today and let us help you achieve your goals.') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.card-header h5 {
    color: #495057;
    font-weight: 600;
}
</style>
@endpush