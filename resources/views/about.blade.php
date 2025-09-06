@extends('layouts.app')

@section('title', __('messages.about_us'))

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">{{ __('messages.about_company') }}</h1>
                <p class="lead mb-4">{{ __('messages.about_company_description') }}</p>
            </div>
            <div class="col-lg-6">
                <img src="https://via.placeholder.com/600x400/ffffff/007bff?text=About+Us" class="img-fluid rounded shadow" alt="About Us">
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">{{ __('messages.our_story') }}</h2>
                <p class="lead text-muted mb-5">{{ __('messages.our_story_description') }}</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle p-3 me-3">
                                <i class="fas fa-lightbulb fa-lg"></i>
                            </div>
                            <h4 class="mb-0">{{ __('messages.our_mission') }}</h4>
                        </div>
                        <p class="text-muted">{{ __('messages.our_mission_description') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success text-white rounded-circle p-3 me-3">
                                <i class="fas fa-eye fa-lg"></i>
                            </div>
                            <h4 class="mb-0">{{ __('messages.our_vision') }}</h4>
                        </div>
                        <p class="text-muted">{{ __('messages.our_vision_description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="mb-3">{{ __('messages.our_core_values') }}</h2>
                <p class="lead text-muted">{{ __('messages.core_values_description') }}</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                    <h5>{{ __('messages.quality') }}</h5>
                    <p class="text-muted">{{ __('messages.quality_description') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-handshake fa-2x"></i>
                    </div>
                    <h5>{{ __('messages.integrity') }}</h5>
                    <p class="text-muted">{{ __('messages.integrity_description') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="bg-info text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-rocket fa-2x"></i>
                    </div>
                    <h5>{{ __('messages.innovation') }}</h5>
                    <p class="text-muted">{{ __('messages.innovation_description') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h5>{{ __('messages.customer_focus') }}</h5>
                    <p class="text-muted">{{ __('messages.customer_focus_description') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h2 class="mb-3">{{ __('messages.meet_our_team') }}</h2>
                <p class="lead text-muted">{{ __('messages.team_description') }}</p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <img src="https://via.placeholder.com/300x300/f8f9fa/6c757d?text=CEO" class="card-img-top" alt="CEO">
                    <div class="card-body text-center">
                        <h5 class="card-title">John Smith</h5>
                        <p class="text-muted mb-2">{{ __('messages.ceo_title') }}</p>
                        <p class="card-text">{{ __('messages.ceo_description') }}</p>
                        <div class="social-links">
                            <a href="#" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-info me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-danger"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <img src="https://via.placeholder.com/300x300/f8f9fa/6c757d?text=CTO" class="card-img-top" alt="CTO">
                    <div class="card-body text-center">
                        <h5 class="card-title">Sarah Johnson</h5>
                        <p class="text-muted mb-2">{{ __('messages.cto_title') }}</p>
                        <p class="card-text">{{ __('messages.cto_description') }}</p>
                        <div class="social-links">
                            <a href="#" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-info me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-danger"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <img src="https://via.placeholder.com/300x300/f8f9fa/6c757d?text=CMO" class="card-img-top" alt="CMO">
                    <div class="card-body text-center">
                        <h5 class="card-title">Michael Brown</h5>
                        <p class="text-muted mb-2">{{ __('messages.cmo_title') }}</p>
                        <p class="card-text">{{ __('messages.cmo_description') }}</p>
                        <div class="social-links">
                            <a href="#" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="text-info me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="text-danger"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="counter">
                    <h2 class="display-4 fw-bold mb-2">10+</h2>
                    <p class="lead mb-0">{{ __('messages.years_experience') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="counter">
                    <h2 class="display-4 fw-bold mb-2">1000+</h2>
                    <p class="lead mb-0">{{ __('messages.happy_customers') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="counter">
                    <h2 class="display-4 fw-bold mb-2">500+</h2>
                    <p class="lead mb-0">{{ __('messages.products_delivered') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="counter">
                    <h2 class="display-4 fw-bold mb-2">50+</h2>
                    <p class="lead mb-0">{{ __('messages.countries_served') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">{{ __('messages.ready_to_work') }}</h2>
                <p class="lead text-muted mb-4">{{ __('messages.ready_to_work_description') }}</p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">{{ __('messages.contact_us') }}</a>
                    <a href="{{ route('catalogs') }}" class="btn btn-outline-primary btn-lg">{{ __('messages.view_products') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection