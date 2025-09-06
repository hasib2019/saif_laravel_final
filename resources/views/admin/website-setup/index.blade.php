@extends('admin.layouts.app')

@section('title', 'Website Setup')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Website Setup Dashboard</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Video Section Setup -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-video me-2"></i>Video Section Setup
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Manage the hero video section content including title, subtitle, badge text, and video file.</p>
                                    
                                    <div class="mb-3">
                                        <strong>Current Settings:</strong>
                                        <ul class="list-unstyled mt-2">
                                            <li><strong>Badge:</strong> {{ $settings->video_badge_text }}</li>
                                            <li><strong>Title Line 1:</strong> {{ $settings->video_title_line1 }}</li>
                                            <li><strong>Title Line 2:</strong> {{ $settings->video_title_line2 }}</li>
                                            <li><strong>Subtitle:</strong> {{ Str::limit($settings->video_subtitle, 50) }}</li>
                                        </ul>
                                    </div>
                                    
                                    <a href="{{ route('admin.website-setup.video-section') }}" class="btn btn-primary">
                                        <i class="fas fa-edit me-2"></i>Edit Video Section
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Company About Section Setup -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-success">
                                <div class="card-header bg-success text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-building me-2"></i>Company About Section
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Manage company information, statistics, and feature descriptions.</p>
                                    
                                    <div class="mb-3">
                                        <strong>Current Settings:</strong>
                                        <ul class="list-unstyled mt-2">
                                            <li><strong>Title:</strong> {{ $settings->company_title }}</li>
                                            <li><strong>Happy Clients:</strong> {{ number_format($settings->happy_clients) }}+</li>
                                            <li><strong>Awards Won:</strong> {{ number_format($settings->awards_won) }}+</li>
                                            <li><strong>Projects:</strong> {{ number_format($settings->projects_completed) }}+</li>
                                            <li><strong>Experience:</strong> {{ $settings->years_experience }}+ years</li>
                                        </ul>
                                    </div>
                                    
                                    <a href="{{ route('admin.website-setup.company-about') }}" class="btn btn-success">
                                        <i class="fas fa-edit me-2"></i>Edit Company About
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats Overview -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Quick Stats Overview</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-3">
                                            <div class="bg-light p-3 rounded">
                                                <h3 class="text-primary">{{ number_format($settings->happy_clients) }}+</h3>
                                                <p class="mb-0">Happy Clients</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="bg-light p-3 rounded">
                                                <h3 class="text-success">{{ number_format($settings->awards_won) }}+</h3>
                                                <p class="mb-0">Awards Won</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="bg-light p-3 rounded">
                                                <h3 class="text-info">{{ number_format($settings->projects_completed) }}+</h3>
                                                <p class="mb-0">Projects Completed</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="bg-light p-3 rounded">
                                                <h3 class="text-warning">{{ $settings->years_experience }}+</h3>
                                                <p class="mb-0">Years Experience</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Site Identity & SEO Setup -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h5 class="mb-0">
                                        <i class="fas fa-globe me-2"></i>Site Identity & SEO
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Manage site branding, logo, favicon, and SEO settings for better search engine visibility.</p>
                                    
                                    <div class="mb-3">
                                        <strong>Current Settings:</strong>
                                        <ul class="list-unstyled mt-2">
                                            <li><strong>Site Name:</strong> {{ $settings->site_name }}</li>
                                            <li><strong>Logo:</strong> {{ $settings->logo_path ? 'Uploaded' : 'Not set' }}</li>
                                            <li><strong>Favicon:</strong> {{ $settings->favicon_path ? 'Uploaded' : 'Not set' }}</li>
                                            <li><strong>Meta Title:</strong> {{ Str::limit($settings->meta_title, 50) }}</li>
                                        </ul>
                                    </div>
                                    
                                    <a href="{{ route('admin.website-setup.site-identity') }}" class="btn btn-info">
                                        <i class="fas fa-edit me-2"></i>Edit Site Identity & SEO
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Settings -->
                        <div class="col-md-6 mb-4">
                            <div class="card border-warning">
                                <div class="card-header bg-warning text-dark">
                                    <h5 class="mb-0">
                                        <i class="fas fa-edit me-2"></i>Footer Settings
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Manage footer content including company description, contact information, and legal links.</p>
                                    
                                    <div class="mb-3">
                                        <strong>Current Settings:</strong>
                                        <ul class="list-unstyled mt-2">
                                            <li><strong>Description:</strong> {{ Str::limit($settings->footer_description, 50) }}</li>
                                            <li><strong>Phone:</strong> {{ $settings->footer_phone }}</li>
                                            <li><strong>Email:</strong> {{ $settings->footer_email }}</li>
                                            <li><strong>Address:</strong> {{ Str::limit($settings->footer_address, 40) }}</li>
                                        </ul>
                                    </div>
                                    
                                    <a href="{{ route('admin.website-setup.footer-settings') }}" class="btn btn-warning">
                                        <i class="fas fa-edit me-2"></i>Edit Footer Settings
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection