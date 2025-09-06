@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title)

@push('styles')
@if($page->meta_description)
<meta name="description" content="{{ $page->meta_description }}">
@endif
@endpush

@section('content')
<!-- Page Header -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if($page->featured_image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $page->featured_image) }}" 
                             class="img-fluid rounded shadow" 
                             alt="{{ $page->title }}"
                             style="max-height: 300px; object-fit: cover;">
                    </div>
                @endif
                
                <div class="text-center">
                    <h1 class="display-4 fw-bold mb-3">{{ $page->title }}</h1>
                    
                    @if($page->excerpt)
                        <p class="lead text-muted">{{ $page->excerpt }}</p>
                    @endif
                    
                    <div class="text-muted">
                        <small>
                            <i class="fas fa-calendar me-1"></i>
                            {{ __('messages.published_on') }} {{ $page->created_at->format('F j, Y') }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Page Content -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="content">
                    {!! nl2br(e($page->content)) !!}
                </div>
                
                <!-- Navigation -->
                <div class="mt-5 pt-4 border-top">
                    <div class="row">
                        <div class="col-6">
                            @php
                                $prevPage = \App\Models\Page::where('is_active', true)
                                    ->where('sort_order', '<', $page->sort_order)
                                    ->orderBy('sort_order', 'desc')
                                    ->first();
                            @endphp
                            @if($prevPage)
                                <a href="{{ route('page.show', $prevPage->slug) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-arrow-left me-2"></i>{{ $prevPage->title }}
                                </a>
                            @endif
                        </div>
                        <div class="col-6 text-end">
                            @php
                                $nextPage = \App\Models\Page::where('is_active', true)
                                    ->where('sort_order', '>', $page->sort_order)
                                    ->orderBy('sort_order', 'asc')
                                    ->first();
                            @endphp
                            @if($nextPage)
                                <a href="{{ route('page.show', $nextPage->slug) }}" class="btn btn-outline-primary">
                                    {{ $nextPage->title }}<i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Back to Home -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>{{ __('messages.back_to_home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.content p {
    margin-bottom: 1.5rem;
}

.content h1, .content h2, .content h3, .content h4, .content h5, .content h6 {
    margin-top: 2rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.content h1 { font-size: 2.5rem; }
.content h2 { font-size: 2rem; }
.content h3 { font-size: 1.75rem; }
.content h4 { font-size: 1.5rem; }
.content h5 { font-size: 1.25rem; }
.content h6 { font-size: 1.1rem; }

.content ul, .content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.content li {
    margin-bottom: 0.5rem;
}

.content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 2rem 0;
    font-style: italic;
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.25rem;
}

.content code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 0.25rem;
    font-size: 0.9rem;
}

.content pre {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 0.25rem;
    overflow-x: auto;
    margin: 1.5rem 0;
}
</style>
@endpush