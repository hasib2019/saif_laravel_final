<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Home')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    
        .video-section {
            position: relative;
            width: 100%;
            height: 900px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #bg-video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            background: #000;
        }

        #bg-video::-webkit-media-controls {
            display: none !important;
        }

        #bg-video::-webkit-media-controls-enclosure {
            display: none !important;
        }

        .video-overlay {
            position: relative;
            z-index: 2;
            color: #fff;
            text-align: left;
            padding: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 30px;
            width: 100%;
        }

        .hero-badge {
            display: inline-block;
            margin-bottom: 1rem;
        }

        .badge-text {
            background: rgba(255, 255, 255, 0.2);
            color: #ffffff;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 2rem;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
        }

        .pioneer-text {
            display: block;
            color: #ffffff;
        }

        .lead-text {
            display: block;
            color: #ffffff;
            position: relative;
        }

        .lead-text::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100px;
            height: 4px;
            background: #ff0000;
        }

        .hero-subtitle p {
            font-size: 1.4rem;
            font-weight: 400;
            margin-bottom: 0;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.7);
            max-width: 600px;
        }

        .hero-actions {
            margin-top: 3rem;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }
            .hero-subtitle p {
                font-size: 1.1rem;
            }
            .hero-content {
                padding: 0 20px;
            }
            .lead-text::after {
                width: 60px;
                height: 3px;
            }
            .hero-actions {
                margin-top: 2rem;
            }
            .hero-actions .btn {
                display: block;
                width: 100%;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 2.2rem;
            }
            .hero-subtitle p {
                font-size: 1rem;
            }
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.5rem;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }

        .video-section {
            padding: 80px 0;
            background-color: #f8f9fa;
        }

        .banner-section {
            position: relative;
            height: 400px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .banner-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
        }

        .catalog-section {
            padding: 80px 0;
        }

        .product-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .category-filter {
            margin-bottom: 30px;
        }

        .stats-card {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin: 0 auto;
        }

        .feature-item {
            padding: 1.5rem;
            transition: transform 0.3s ease;
        }

        .feature-item:hover {
            transform: translateY(-3px);
        }

        .feature-item h5 {
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .footer {
            background-color: rgb(97 99 103);
            color: white;
            padding: 40px 0 20px;
        }

        .footer h5 {
            color: white;
            margin-bottom: 20px;
        }

        .footer a {
            color: white;
            text-decoration: none;
        }

        .footer a:hover {
            color: white;
        }

        /* RTL Support */
        [dir="rtl"] .navbar-nav {
            margin-left: auto;
            margin-right: 0;
        }

        [dir="rtl"] .dropdown-menu {
            left: auto;
            right: 0;
        }

        [dir="rtl"] .text-md-end {
            text-align: right !important;
        }

        [dir="rtl"] .me-3 {
            margin-left: 1rem !important;
            margin-right: 0 !important;
        }

        /* Language switcher active state */
        .dropdown-item.active {
            background-color: #f8f9fa;
            font-weight: bold;
        }
    </style>

    @stack('styles')
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">{{ __('messages.home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('catalogs') ? 'active' : '' }}"
                            href="{{ route('catalogs') }}">{{ __('messages.catalogs') }}</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button"
                            data-bs-toggle="dropdown">
                            {{ __('messages.custom_page') }}
                        </a>
                        <ul class="dropdown-menu">
                            @foreach (\App\Models\Page::where('is_active', true)->where('show_in_menu', true)->orderBy('sort_order')->get() as $page)
                                <li><a class="dropdown-item"
                                        href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">{{ __('messages.about_us') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                            href="{{ route('contact') }}">{{ __('messages.contact_us') }}</a>
                    </li>

                    <!-- Language Switcher -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button"
                            data-bs-toggle="dropdown">
                            @if (app()->getLocale() == 'ar')
                                🇸🇦 العربية
                            @else
                                🇺🇸 English
                            @endif
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                    href="{{ route('language.switch', 'en') }}">🇺🇸 English</a></li>
                            <li><a class="dropdown-item {{ app()->getLocale() == 'ar' ? 'active' : '' }}"
                                    href="{{ route('language.switch', 'ar') }}">🇸🇦 العربية</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5>{{ config('app.name', 'Laravel') }}</h5>
                    <p class="text-white">{{ $globalSettings->footer_description ?? __('messages.company_description') }}</p>
                    <div class="social-links">
                        <a href="#" class="me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>{{ __('messages.quick_links') }}</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                        <li><a href="{{ route('catalogs') }}">{{ __('messages.catalogs') }}</a></li>
                        <li><a href="{{ route('about') }}">{{ __('messages.about_us') }}</a></li>
                        <li><a href="{{ route('contact') }}">{{ __('messages.contact_us') }}</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>{{ __('messages.categories') }}</h5>
                    <ul class="list-unstyled">
                        @foreach (\App\Models\Category::where('is_active', true)->take(5)->get() as $category)
                            <li><a
                                    href="{{ route('catalogs', ['category' => $category->slug]) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>{{ __('messages.contact_info') }}</h5>
                    <ul class="list-unstyled text-white">
                        @if($globalSettings->footer_address)
                            <li><i class="fas fa-map-marker-alt me-2"></i>{{ $globalSettings->footer_address }}</li>
                        @endif
                        @if($globalSettings->footer_phone)
                            <li><i class="fas fa-phone me-2"></i>{{ $globalSettings->footer_phone }}</li>
                        @endif
                        @if($globalSettings->footer_email)
                            <li><i class="fas fa-envelope me-2"></i>{{ $globalSettings->footer_email }}</li>
                        @endif
                    </ul>
                </div>
            </div>

            <hr class="my-4">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-white mb-0">
                        {{ $globalSettings->footer_copyright ?? '&copy; ' . date('Y') . ' ' . config('app.name', 'Laravel') . '. ' . __('messages.all_rights_reserved') }}
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    @if($globalSettings->footer_privacy_policy)
                        <a href="{{ $globalSettings->footer_privacy_policy }}" class="text-white me-3">{{ __('messages.privacy_policy') }}</a>
                    @endif
                    @if($globalSettings->footer_terms_service)
                        <a href="{{ $globalSettings->footer_terms_service }}" class="text-white">{{ __('messages.terms_of_service') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>

    <!-- Video Autoplay Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const video = document.getElementById('bg-video');
            if (video) {
                // Ensure video plays automatically
                video.muted = true;
                video.autoplay = true;
                video.loop = true;
                video.playsInline = true;
                
                // Try to play the video
                const playPromise = video.play();
                
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        console.log('Video is playing automatically');
                    }).catch(error => {
                        console.log('Autoplay was prevented:', error);
                        // If autoplay fails, you could show a play button or handle it differently
                    });
                }
                
                // Handle video loading errors
                video.addEventListener('error', function(e) {
                    console.error('Video loading error:', e);
                });
                
                // Ensure video is properly sized
                video.addEventListener('loadedmetadata', function() {
                    console.log('Video metadata loaded');
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
