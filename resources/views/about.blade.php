@extends('layouts.app')

@section('title', __('messages.about_us'))

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    {{ $aboutSettings->hero_title ?? __('messages.about_company') }}
                </h1>
                <p class="lead mb-4">
                    {{ $aboutSettings->hero_description ?? __('messages.about_company_description') }}
                </p>
            </div>
            <div class="col-lg-6">
                @if($aboutSettings && $aboutSettings->hero_image)
                    <img src="{{ asset($aboutSettings->hero_image) }}" class="img-fluid rounded shadow" alt="About Us">
                @else
                    <img src="https://via.placeholder.com/600x400/ffffff/007bff?text=About+Us" class="img-fluid rounded shadow" alt="About Us">
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Our Story Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4">
                    {{ $aboutSettings->story_title ?? __('messages.our_story') }}
                </h2>
                <p class="lead text-muted mb-5">
                    {{ $aboutSettings->story_description ?? __('messages.our_story_description') }}
                </p>
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
                            <h4 class="mb-0">
                                {{ $aboutSettings->mission_title ?? __('messages.our_mission') }}
                            </h4>
                        </div>
                        <p class="text-muted">
                            {{ $aboutSettings->mission_description ?? __('messages.our_mission_description') }}
                        </p>
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
                            <h4 class="mb-0">
                                {{ $aboutSettings->vision_title ?? __('messages.our_vision') }}
                            </h4>
                        </div>
                        <p class="text-muted">
                            {{ $aboutSettings->vision_description ?? __('messages.our_vision_description') }}
                        </p>
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
                <h2 class="mb-3">
                    {{ $aboutSettings->values_title ?? __('messages.our_core_values') }}
                </h2>
                <p class="lead text-muted">
                    {{ $aboutSettings->values_description ?? __('messages.core_values_description') }}
                </p>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="bg-primary text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-star fa-2x"></i>
                    </div>
                    <h5>{{ $aboutSettings->quality_title ?? __('messages.quality') }}</h5>
                    <p class="text-muted">{{ $aboutSettings->quality_description ?? __('messages.quality_description') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="bg-success text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-handshake fa-2x"></i>
                    </div>
                    <h5>{{ $aboutSettings->integrity_title ?? __('messages.integrity') }}</h5>
                    <p class="text-muted">{{ $aboutSettings->integrity_description ?? __('messages.integrity_description') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="bg-info text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-rocket fa-2x"></i>
                    </div>
                    <h5>{{ $aboutSettings->innovation_title ?? __('messages.innovation') }}</h5>
                    <p class="text-muted">{{ $aboutSettings->innovation_description ?? __('messages.innovation_description') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="text-center">
                    <div class="bg-warning text-white rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                    <h5>{{ $aboutSettings->customer_focus_title ?? __('messages.customer_focus') }}</h5>
                    <p class="text-muted">{{ $aboutSettings->customer_focus_description ?? __('messages.customer_focus_description') }}</p>
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
                <h2 class="mb-3">
                    {{ $aboutSettings->team_title ?? __('messages.meet_our_team') }}
                </h2>
                <p class="lead text-muted">
                    {{ $aboutSettings->team_description ?? __('messages.team_description') }}
                </p>
            </div>
        </div>
        
        <div class="row">
            @if($teamMembers && $teamMembers->count() > 0)
                @foreach($teamMembers as $member)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card border-0 shadow-sm">
                            @if($member->image)
                                <img src="{{ asset($member->image) }}" class="card-img-top" alt="{{ $member->name }}" style="height: 300px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/300x300/f8f9fa/6c757d?text={{ urlencode($member->name) }}" class="card-img-top" alt="{{ $member->name }}">
                            @endif
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $member->name }}</h5>
                                <p class="text-muted mb-2">{{ $member->position }}</p>
                                @if($member->bio)
                                    <p class="card-text">{{ Str::limit($member->bio, 100) }}</p>
                                @endif
                                <div class="social-links">
                                    @if($member->linkedin_url)
                                        <a href="{{ $member->linkedin_url }}" target="_blank" class="text-primary me-2"><i class="fab fa-linkedin"></i></a>
                                    @endif
                                    @if($member->twitter_url)
                                        <a href="{{ $member->twitter_url }}" target="_blank" class="text-info me-2"><i class="fab fa-twitter"></i></a>
                                    @endif
                                    @if($member->email)
                                        <a href="mailto:{{ $member->email }}" class="text-danger"><i class="fas fa-envelope"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback team members if no data in database -->
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
            @endif
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="counter">
                    <h2 class="display-4 fw-bold mb-2">
                        {{ $aboutSettings->stats_years ?? '10+' }}
                    </h2>
                    <p class="lead mb-0">{{ __('messages.years_experience') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="counter">
                    <h2 class="display-4 fw-bold mb-2">
                        {{ $aboutSettings->stats_customers ?? '1000+' }}
                    </h2>
                    <p class="lead mb-0">{{ __('messages.happy_customers') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="counter">
                    <h2 class="display-4 fw-bold mb-2">
                        {{ $aboutSettings->stats_products ?? '500+' }}
                    </h2>
                    <p class="lead mb-0">{{ __('messages.products_delivered') }}</p>
                </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="counter">
                    <h2 class="display-4 fw-bold mb-2">
                        {{ $aboutSettings->stats_countries ?? '50+' }}
                    </h2>
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
                <h2 class="mb-4">
                    {{ $aboutSettings->cta_title ?? __('messages.ready_to_work') }}
                </h2>
                <p class="lead text-muted mb-4">
                    {{ $aboutSettings->cta_description ?? __('messages.ready_to_work_description') }}
                </p>
                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('contact') }}" class="btn btn-primary btn-lg">{{ __('messages.contact_us') }}</a>
                    <a href="{{ route('catalogs') }}" class="btn btn-outline-primary btn-lg">{{ __('messages.view_products') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection