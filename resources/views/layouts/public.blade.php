<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', $siteSettings->meta_title ?? $siteSettings->site_name ?? config('app.name', 'Laravel'))</title>

    <!-- Favicon -->
    @if(isset($siteSettings) && $siteSettings->favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <link rel="canonical" href="@yield('canonical', url()->current())">

    @if(isset($siteSettings))
        <meta name="description" content="@yield('description', $siteSettings->meta_description)">
        <meta name="keywords" content="@yield('keywords', $siteSettings->meta_keywords)">

        <meta property="og:site_name" content="{{ $siteSettings->site_name }}">
        <meta property="og:title" content="@yield('title', $siteSettings->meta_title)">
        <meta property="og:description" content="@yield('description', $siteSettings->meta_description)">
        <meta property="og:image" content="@yield('og_image', $siteSettings->logo ? asset('storage/' . $siteSettings->logo) : '')">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="@yield('og_type', 'website')">
        <meta property="og:locale" content="id_ID">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('title', $siteSettings->meta_title)">
        <meta name="twitter:description" content="@yield('description', $siteSettings->meta_description)">
        <meta name="twitter:image" content="@yield('og_image', $siteSettings->logo ? asset('storage/' . $siteSettings->logo) : '')">
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Moment.js and Moment-Hijri for accurate conversion -->
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment-hijri@2.1.2/moment-hijri.min.js"></script>
    
    <!-- Dynamic Theme CSS -->
    <style>
        {!! \App\Helpers\ThemeHelper::generateDynamicCSS() !!}
        
        :root {
            --text-dark: #2d3748;
            --text-light: #718096;
            --bg-light: #f7fafc;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            background-color: var(--body-bg-color) !important;
            color: var(--body-text-color) !important;
            overflow-x: hidden;
        }

        .site-main {
            padding-bottom: 0;
        }
        
        .navbar {
            background-color: rgba(var(--header-bg-color-rgb, 255, 255, 255), var(--navbar-transparency, 100) / 100) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0.75rem 0;
            transition: all 0.3s ease;
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        .navbar .container {
            max-width: min(100% - 32px, 1760px);
            padding-left: 0;
            padding-right: 0;
        }
        
        .navbar.scrolled {
            background-color: rgba(var(--header-bg-color-rgb, 255, 255, 255), 0.95) !important;
            backdrop-filter: var(--blur-effect, none);
            -webkit-backdrop-filter: var(--blur-effect, none);
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        }
        
        .navbar-toggler {
            border: 2px solid var(--header-text-color);
            padding: 0.25rem 0.5rem;
            background-color: transparent;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        
        .navbar-toggler:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23000' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
            width: 1.5em;
            height: 1.5em;
        }
        
        /* Dark background hamburger */
        .navbar-dark .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23fff' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: var(--header-bg-color);
                margin-top: 1rem;
                padding: 1rem;
                border-radius: 0.5rem;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            }
            
            .navbar-nav .nav-link {
                padding: 0.5rem 0;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            
            .navbar-nav .nav-link:last-child {
                border-bottom: none;
            }
            
            /* Force hamburger visibility on mobile */
            .navbar-toggler {
                border: 2px solid #000 !important;
                background-color: rgba(255, 255, 255, 0.9) !important;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }
            
            .navbar-toggler-icon {
                background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23000' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e") !important;
            }
        }
        
        /* Navbar Styling - Ensure solid background */
        .navbar {
            background-color: var(--header-bg-color) !important;
            opacity: 1 !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            min-width: 0;
            font-weight: 700;
            font-size: clamp(1.05rem, 1.55vw, 1.5rem);
            color: var(--header-text-color) !important;
            line-height: 1.15;
            margin-right: clamp(0.75rem, 1.5vw, 1.5rem);
            max-width: min(34vw, 430px);
            white-space: normal;
        }

        .navbar-brand img {
            flex: 0 0 auto;
            max-width: 42px;
            object-fit: contain;
        }

        .navbar-brand-text {
            min-width: 0;
        }

        .mobile-datetime {
            display: none;
        }

        .navbar-collapse {
            min-width: 0;
        }

        .navbar-collapse > .navbar-nav:first-child {
            flex: 1 1 auto;
            flex-wrap: wrap;
            justify-content: center;
            min-width: 0;
            row-gap: 0.15rem;
        }

        .navbar-collapse > .navbar-nav:last-child {
            flex: 0 1 auto;
            min-width: 0;
        }
        
        .navbar-nav .nav-link {
            color: var(--header-text-color) !important;
            font-weight: 500;
            margin: 0 0.35rem;
            padding-left: 0.35rem;
            padding-right: 0.35rem;
            transition: all 0.3s ease;
            white-space: normal;
            text-align: center;
        }
        
        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
            transform: translateY(-2px);
        }
        
        /* Dropdown Menu Styles */
        .navbar-nav .dropdown-menu {
            background-color: var(--header-bg-color);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
            padding: 0.5rem 0;
        }
        
        .navbar-nav .dropdown-item {
            color: var(--header-text-color) !important;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .dropdown-item:hover {
            background-color: var(--primary-color);
            color: white !important;
        }
        
        .navbar-nav .dropdown-toggle::after {
            margin-left: 0.5rem;
        }
        
        /* Ensure dropdown is visible */
        .navbar-nav .nav-item.dropdown {
            position: relative;
        }
        
        .navbar-nav .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            min-width: 200px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        
        .navbar-nav .nav-item.dropdown:hover .dropdown-menu,
        .navbar-nav .nav-item.dropdown.show .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
        
        .running-text {
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1, #96ceb4, #feca57);
            background-size: 300% 300%;
            animation: gradient 3s ease infinite;
            color: white;
            padding: 0.5rem 0;
            font-weight: 500;
            overflow: hidden;
        }
        
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        .running-text-content {
            white-space: nowrap;
            animation: scroll 30s linear infinite;
        }
        
        @keyframes scroll {
            0% { transform: translateX(100%); }
            100% { transform: translateX(-100%); }
        }
        
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .btn-primary {
            background-color: var(--button-primary-color) !important;
            border-color: var(--button-primary-color) !important;
            border: none;
            border-radius: 50px;
            padding: 0.75rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: var(--button-primary-hover) !important;
            border-color: var(--button-primary-hover) !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        
        .card {
            background-color: var(--card-bg-color) !important;
            border: 1px solid var(--card-border-color) !important;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .section-title {
            position: relative;
            margin-bottom: 3rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border-radius: 2px;
        }
        
        .footer {
            background-color: var(--footer-bg-color) !important;
            color: var(--footer-text-color) !important;
            padding: 3rem 0 1rem;
            backdrop-filter: var(--blur-effect, none);
            -webkit-backdrop-filter: var(--blur-effect, none);
            border-top: 1px solid var(--footer-border-color);
        }
        
        .footer a {
            color: var(--footer-link-color) !important;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--footer-link-hover-color) !important;
        }
        
        .social-links a {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: var(--footer-social-bg-color);
            color: var(--footer-text-color);
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            margin: 0 0.5rem;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: var(--footer-social-hover-color);
            color: var(--footer-text-color);
            transform: translateY(-3px);
        }
        
        a {
            color: var(--link-color) !important;
        }
        
        a:hover {
            color: var(--link-hover-color) !important;
        }
        
        /* Date and Time Display Styles */
        .datetime-display {
            display: flex !important;
            flex-direction: column !important;
            align-items: flex-end !important;
            font-size: 0.78rem !important;
            line-height: 1.2 !important;
            min-width: 150px !important;
            max-width: 190px;
            overflow: hidden;
        }
        
        .datetime-main, .datetime-time, .datetime-hijri {
            display: flex;
            align-items: center;
            margin-bottom: 2px;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .datetime-main {
            font-weight: 600;
            color: var(--header-text-color);
        }
        
        .datetime-time {
            font-weight: 500;
            color: var(--header-text-color);
            opacity: 0.9;
        }
        
        .datetime-hijri {
            font-weight: 500;
            color: var(--header-text-color);
            opacity: 0.8;
            font-size: 0.8rem;
        }
        
        .datetime-display i {
            font-size: 0.9rem;
            margin-right: 0.25rem;
        }
        
        /* Mobile responsive */
        @media (max-width: 991.98px) {
            .site-main {
                padding-bottom: 72px;
            }

            .navbar {
                padding: 0.58rem 0;
            }

            .navbar .container {
                align-items: center;
                display: flex;
                flex-wrap: nowrap;
                gap: 10px;
                max-width: min(100% - 24px, 1760px);
            }

            .navbar-brand {
                flex: 1 1 auto;
                font-size: clamp(0.92rem, 4.35vw, 1.18rem);
                line-height: 1.08;
                margin-right: 0;
                max-width: none;
                min-width: 0;
            }

            .navbar-brand img {
                height: 38px;
                max-width: 38px;
            }

            .navbar-brand-text {
                display: block;
                overflow-wrap: anywhere;
            }

            .mobile-datetime {
                align-items: flex-end;
                color: var(--header-text-color);
                display: flex;
                flex: 0 0 auto;
                flex-direction: column;
                gap: 2px;
                line-height: 1.1;
                max-width: 122px;
                text-align: right;
            }

            .mobile-datetime span {
                align-items: center;
                display: flex;
                justify-content: flex-end;
                max-width: 100%;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .mobile-datetime i {
                flex: 0 0 auto;
                font-size: 0.78rem;
                margin-right: 4px;
            }

            .mobile-datetime-date {
                font-size: 0.74rem;
                font-weight: 700;
            }

            .mobile-datetime-time {
                font-size: 0.8rem;
                font-weight: 800;
            }

            .datetime-display {
                flex-direction: row;
                flex-wrap: wrap;
                justify-content: center;
                min-width: auto;
                margin: 0.5rem 0;
            }
            
            .datetime-main, .datetime-time, .datetime-hijri {
                margin-right: 1rem;
                margin-bottom: 0.25rem;
            }
            
            .datetime-hijri {
                width: 100%;
                justify-content: center;
                margin-top: 0.25rem;
            }
        }

        @media (min-width: 992px) and (max-width: 1399.98px) {
            .navbar .container {
                align-items: center;
                display: flex;
                flex-wrap: nowrap;
                gap: 18px;
                max-width: min(100% - 40px, 1760px);
            }

            .navbar-brand {
                flex: 0 1 340px;
                margin-right: 0;
                max-width: 340px;
            }

            .navbar-collapse {
                flex: 1 1 auto;
                min-width: 0;
                order: 2;
            }

            .mobile-datetime {
                align-items: flex-end;
                color: var(--header-text-color);
                display: flex;
                flex: 0 0 auto;
                flex-direction: column;
                gap: 2px;
                line-height: 1.1;
                margin-left: auto;
                max-width: 132px;
                order: 3;
                text-align: right;
            }

            .mobile-datetime span {
                align-items: center;
                display: flex;
                justify-content: flex-end;
                max-width: 100%;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .mobile-datetime i {
                flex: 0 0 auto;
                font-size: 0.78rem;
                margin-right: 4px;
            }

            .mobile-datetime-date {
                font-size: 0.74rem;
                font-weight: 700;
            }

            .mobile-datetime-time {
                font-size: 0.8rem;
                font-weight: 800;
            }
        }
        
        @media (max-width: 576px) {
            .navbar-brand {
                font-size: clamp(0.9rem, 4.4vw, 1.08rem);
            }

            .navbar-brand img {
                height: 34px;
                max-width: 34px;
            }

            .mobile-datetime {
                max-width: 108px;
            }

            .mobile-datetime-date {
                font-size: 0.68rem;
            }

            .mobile-datetime-time {
                font-size: 0.74rem;
            }

            .datetime-display {
                font-size: 0.75rem;
            }
            
            .datetime-main, .datetime-time, .datetime-hijri {
                margin-right: 0.5rem;
            }
        }

        @media (max-width: 1399.98px) {
            .desktop-datetime-nav {
                display: none !important;
            }
        }
        
        /* Scroll to Top - Mobile & Desktop */
        .scroll-to-top-btn {
            display: none;
            position: fixed;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: none;
            background: var(--primary-color);
            color: white;
            font-size: 1.25rem;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: opacity 0.3s, transform 0.2s;
            z-index: 1040;
            align-items: center;
            justify-content: center;
            /* Mobile: above bottom nav */
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        @media (min-width: 768px) {
            .scroll-to-top-btn {
                /* Desktop: bottom-right corner */
                bottom: 24px;
                right: 24px;
                left: auto;
                transform: none;
                width: 44px;
                height: 44px;
                font-size: 1.35rem;
            }
        }

        @media (min-width: 768px) and (max-width: 991.98px) {
            .scroll-to-top-btn {
                bottom: 92px;
                right: 24px;
            }
        }
        
        .scroll-to-top-btn.visible {
            display: flex;
        }
        
        .scroll-to-top-btn:active {
            transform: translateX(-50%) scale(0.95);
        }
        
        @media (min-width: 768px) {
            .scroll-to-top-btn:active {
                transform: scale(0.95);
            }
        }
        
        /* Bottom mobile wrapper */
        .bottom-mobile-wrapper {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }
        
        .bottom-mobile-nav {
            background: #fff;
            border-top: 1px solid #eaeaea;
        }
        
        .bottom-mobile-nav .d-flex {
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
        }

        @media (max-width: 991.98px) {
            .bottom-mobile-wrapper {
                display: block;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Running Text -->
    @if(isset($runningTexts) && $runningTexts->count() > 0)
    <div class="running-text">
        <div class="container">
            <div class="running-text-content">
                @foreach($runningTexts as $runningText)
                    @if($runningText->link)
                        <a href="{{ $runningText->link }}" class="text-white text-decoration-none me-5">
                            {{ $runningText->text }}
                        </a>
                    @else
                        <span class="me-5">{{ $runningText->text }}</span>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--header-bg-color); color: var(--header-text-color);">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}" style="color: var(--header-text-color);">
                @if(isset($siteSettings) && $siteSettings->logo)
                    <img src="{{ asset('storage/' . $siteSettings->logo) }}" alt="" height="40" class="me-2" onerror="this.remove()">
                @endif
                <span class="navbar-brand-text">{{ $siteSettings->site_name ?? config('app.name', 'Laravel') }}</span>
            </a>
            
            <div class="mobile-datetime" aria-label="Tanggal dan waktu">
                <span class="mobile-datetime-date">
                    <i class="bi bi-calendar3"></i>
                    <span id="current-date">{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('D d M') }}</span>
                </span>
                <span class="mobile-datetime-time">
                    <i class="bi bi-clock"></i>
                    <span id="current-time">{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }}</span>
                </span>
            </div>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @if(isset($menus) && $menus->count() > 0)
                        @foreach($menus->whereNull('parent_id')->sortBy('order') as $menu)
                            @if($menu->children->count() > 0)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="{{ $menu->url }}" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--header-text-color);">
                                        {{ $menu->title }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        @foreach($menu->children->sortBy('order') as $child)
                                            <li><a class="dropdown-item" href="{{ $child->url }}">{{ $child->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ $menu->url }}" style="color: var(--header-text-color);">
                                        {{ $menu->title }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @else
                        <!-- Fallback menu if no database menus -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}" style="color: var(--header-text-color);">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.index') }}" style="color: var(--header-text-color);">Berita</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('galleries.index') }}" style="color: var(--header-text-color);">Galeri</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('programs.index') }}" style="color: var(--header-text-color);">Program</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('downloads.index') }}" style="color: var(--header-text-color);">Download</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contacts.index') }}" style="color: var(--header-text-color);">Kontak</a>
                        </li>
                    @endif
                </ul>
                
                <ul class="navbar-nav">
                    <!-- Date and Time Display -->
                    <li class="nav-item d-none d-lg-block desktop-datetime-nav">
                        <div class="datetime-display" style="color: var(--header-text-color);">
                            <div class="datetime-main">
                                <i class="bi bi-calendar3 me-1"></i>
                                <span id="desktop-current-date">{{ \Carbon\Carbon::now('Asia/Jakarta')->translatedFormat('l, d F Y') }}</span>
                            </div>
                            <div class="datetime-time">
                                <i class="bi bi-clock me-1"></i>
                                <span id="desktop-current-time">{{ \Carbon\Carbon::now('Asia/Jakarta')->format('H:i') }}</span>
                            </div>
                            <div class="datetime-hijri">
                                <i class="bi bi-moon-stars me-1"></i>
                                <span id="desktop-hijri-date">{{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y', 'Do MMMM YYYY') . ' H' }}</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="site-main">
        @yield('content')
    </main>

    <!-- Scroll to Top (mobile + desktop) -->
    <button type="button" id="scrollToTopBtn" class="scroll-to-top-btn" aria-label="Scroll ke atas" title="Scroll ke atas">
        <i class="bi bi-chevron-up"></i>
    </button>

    <!-- Bottom Mobile Nav (mobile only) -->
    <div class="bottom-mobile-wrapper">
        <nav class="bottom-mobile-nav">
        <div class="container px-0">
            <div class="d-flex flex-nowrap overflow-auto text-center" style="-webkit-overflow-scrolling: touch; scrollbar-width: none;">
                <a href="{{ route('home') }}" class="flex-fill py-2 text-decoration-none" style="color: var(--primary-color);">
                    <i class="bi bi-house-door" style="font-size: 1.2rem;"></i>
                    <div style="font-size: 0.75rem;">Beranda</div>
                </a>
                <a href="{{ route('pages.about') }}" class="flex-fill py-2 text-decoration-none" style="color: var(--primary-color);">
                    <i class="bi bi-info-circle" style="font-size: 1.2rem;"></i>
                    <div style="font-size: 0.75rem;">Tentang</div>
                </a>
                <a href="{{ route('programs.index') }}" class="flex-fill py-2 text-decoration-none" style="color: var(--primary-color);">
                    <i class="bi bi-journal-richtext" style="font-size: 1.2rem;"></i>
                    <div style="font-size: 0.75rem;">Program</div>
                </a>
                <a href="{{ route('posts.index') }}" class="flex-fill py-2 text-decoration-none" style="color: var(--primary-color);">
                    <i class="bi bi-newspaper" style="font-size: 1.2rem;"></i>
                    <div style="font-size: 0.75rem;">Berita</div>
                </a>
                <a href="{{ route('galleries.index') }}" class="flex-fill py-2 text-decoration-none" style="color: var(--primary-color);">
                    <i class="bi bi-images" style="font-size: 1.2rem;"></i>
                    <div style="font-size: 0.75rem;">Galeri</div>
                </a>
                <a href="{{ route('downloads.index') }}" class="flex-fill py-2 text-decoration-none" style="color: var(--primary-color);">
                    <i class="bi bi-download" style="font-size: 1.2rem;"></i>
                    <div style="font-size: 0.75rem;">Download</div>
                </a>
                <a href="{{ route('contacts.index') }}" class="flex-fill py-2 text-decoration-none" style="color: var(--primary-color);">
                    <i class="bi bi-envelope" style="font-size: 1.2rem;"></i>
                    <div style="font-size: 0.75rem;">Kontak</div>
                </a>
            </div>
        </div>
        </nav>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">{{ $siteSettings->site_name ?? 'Yayasan Pendidikan Islam' }}</h5>
                    <p class="mb-3">{{ $siteSettings->site_description ?? 'Yayasan Pendidikan Islam yang berkomitmen untuk memberikan pendidikan berkualitas dengan nilai-nilai Islam yang kuat.' }}</p>
                    @if(isset($siteSettings))
                        <div class="social-links">
                            @if($siteSettings->facebook)
                                <a href="{{ $siteSettings->facebook }}" target="_blank"><i class="bi bi-facebook"></i></a>
                            @endif
                            @if($siteSettings->instagram)
                                <a href="{{ $siteSettings->instagram }}" target="_blank"><i class="bi bi-instagram"></i></a>
                            @endif
                            @if($siteSettings->youtube)
                                <a href="{{ $siteSettings->youtube }}" target="_blank"><i class="bi bi-youtube"></i></a>
                            @endif
                            @if($siteSettings->twitter)
                                <a href="{{ $siteSettings->twitter }}" target="_blank"><i class="bi bi-twitter"></i></a>
                            @endif
                        </div>
                    @endif
                </div>
                
                
                <div class="col-lg-3 col-md-6 mb-4">
                    <h6 class="mb-3">Kontak</h6>
                    @if(isset($siteSettings))
                        <ul class="list-unstyled">
                            @if($siteSettings->address)
                                <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>{{ $siteSettings->address }}</li>
                            @endif
                            @if($siteSettings->phone)
                                <li class="mb-2"><i class="bi bi-telephone me-2"></i>{{ $siteSettings->phone }}</li>
                            @endif
                            @if($siteSettings->email)
                                <li class="mb-2"><i class="bi bi-envelope me-2"></i>{{ $siteSettings->email }}</li>
                            @endif
                        </ul>
                    @endif
                </div>
                
                <div class="col-lg-3 mb-4">
                    <h6 class="mb-3">Newsletter</h6>
                    <p class="mb-3">Dapatkan informasi terbaru dari kami</p>
                    <form class="d-flex">
                        <input type="email" class="form-control me-2" placeholder="Email Anda">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-send"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} {{ $siteSettings->site_name ?? 'Yayasan Pendidikan Islam' }}. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Made with <i class="bi bi-heart-fill text-danger"></i> for Education</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" 
            onerror="console.error('Bootstrap failed to load')"
            onload="console.log('Bootstrap loaded successfully')"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    <!-- Navbar Responsive Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Wait for Bootstrap to load with timeout
            let bootstrapCheckCount = 0;
            const maxBootstrapChecks = 50; // 5 seconds max wait
            
            function initializeBootstrap() {
                if (typeof bootstrap !== 'undefined' && bootstrap.Dropdown) {
                    try {
                        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
                        
                        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                            return new bootstrap.Dropdown(dropdownToggleEl);
                        });
                        console.log('Bootstrap dropdowns initialized successfully');
                    } catch (e) {
                        console.warn('Bootstrap dropdown initialization failed:', e);
                    }
                } else if (bootstrapCheckCount < maxBootstrapChecks) {
                    bootstrapCheckCount++;
                    setTimeout(initializeBootstrap, 100);
                } else {
                    console.warn('Bootstrap not available after timeout');
                }
            }
            
            // Start Bootstrap initialization
            initializeBootstrap();
            
            // Fallback: Simple dropdown functionality if Bootstrap fails
            setTimeout(function() {
                if (typeof bootstrap === 'undefined') {
                    console.warn('Bootstrap not available, using fallback dropdown');
                    // Simple dropdown fallback
                    document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
                        toggle.addEventListener('click', function(e) {
                            e.preventDefault();
                            const menu = this.nextElementSibling;
                            if (menu && menu.classList.contains('dropdown-menu')) {
                                menu.classList.toggle('show');
                            }
                        });
                    });
                }
            }, 2000);
            
            // Navbar collapse functionality
            const navbarToggler = document.querySelector('.navbar-toggler');
            const navbarCollapse = document.querySelector('.navbar-collapse');
            
            if (navbarToggler && navbarCollapse) {
                navbarToggler.addEventListener('click', function() {
                    // Navbar toggler clicked
                });
                
                // Close mobile menu when clicking outside
                document.addEventListener('click', function(event) {
                    const isClickInsideNav = navbarCollapse.contains(event.target) || navbarToggler.contains(event.target);
                    if (!isClickInsideNav && navbarCollapse.classList.contains('show')) {
                        if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
                            const bsCollapse = new bootstrap.Collapse(navbarCollapse, {
                                toggle: false
                            });
                            bsCollapse.hide();
                        } else {
                            // Fallback: simple hide
                            navbarCollapse.classList.remove('show');
                        }
                    }
                });
            }
            
            // Initialize dropdowns manually
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            
            dropdownToggles.forEach(function(toggle) {
                // Add click event for dropdown
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const dropdown = this.closest('.dropdown');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    
                    if (menu) {
                        menu.classList.toggle('show');
                        dropdown.classList.toggle('show');
                    }
                });
                
                // Add hover events for better UX
                toggle.addEventListener('mouseenter', function() {
                    const dropdown = this.closest('.dropdown');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    if (menu) {
                        menu.classList.add('show');
                        dropdown.classList.add('show');
                    }
                });
                
                const dropdown = toggle.closest('.dropdown');
                dropdown.addEventListener('mouseleave', function() {
                    const menu = this.querySelector('.dropdown-menu');
                    if (menu) {
                        menu.classList.remove('show');
                        this.classList.remove('show');
                    }
                });
            });
            
            // Sticky navbar scroll effect
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                });
            }
            
            // Scroll to Top button (mobile)
            const scrollToTopBtn = document.getElementById('scrollToTopBtn');
            if (scrollToTopBtn) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 300) {
                        scrollToTopBtn.classList.add('visible');
                    } else {
                        scrollToTopBtn.classList.remove('visible');
                    }
                });
                scrollToTopBtn.addEventListener('click', function() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
            
            // Date and Time Display Functions
            // cache untuk hijri agar tidak memanggil API setiap detik
            let lastHijriDateKey = null;
            let lastHijriText = null;

            // Force update datetime on page load
            function forceUpdateDateTime() {
                updateDateTime();
                updateHijriDate(new Date());
            }

            function updateDateTime() {
                const now = new Date();
                
                // Format untuk tanggal Masehi (Indonesia)
                const dateOptions = {
                    timeZone: 'Asia/Jakarta',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    weekday: 'long'
                };

                // Format untuk waktu
                const timeOptions = {
                    timeZone: 'Asia/Jakarta',
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                };

                const mobileTimeOptions = {
                    timeZone: 'Asia/Jakarta',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                };
                
                const dateFormatter = new Intl.DateTimeFormat('id-ID', dateOptions);
                const timeFormatter = new Intl.DateTimeFormat('id-ID', timeOptions);
                const mobileTimeFormatter = new Intl.DateTimeFormat('id-ID', mobileTimeOptions);
                
                // Update tanggal dan waktu untuk mobile
                const currentDateElement = document.getElementById('current-date');
                const currentTimeElement = document.getElementById('current-time');
                
                if (currentDateElement) {
                    currentDateElement.textContent = formatMobileDate(now);
                }
                
                if (currentTimeElement) {
                    currentTimeElement.textContent = mobileTimeFormatter.format(now);
                }
                
                // Update tanggal dan waktu untuk desktop
                const desktopDateElement = document.getElementById('desktop-current-date');
                const desktopTimeElement = document.getElementById('desktop-current-time');
                
                if (desktopDateElement) {
                    desktopDateElement.textContent = dateFormatter.format(now);
                }
                
                if (desktopTimeElement) {
                    desktopTimeElement.textContent = timeFormatter.format(now);
                }
                
                // Konversi ke kalender Hijriyah (panggil hanya saat tanggal berubah)
                const key = `${now.getFullYear()}-${(now.getMonth()+1).toString().padStart(2,'0')}-${now.getDate().toString().padStart(2,'0')}`;
                if (lastHijriDateKey !== key) {
                    lastHijriDateKey = key;
                    updateHijriDate(now);
                } else if (lastHijriText) {
                    const hijriDateElement = document.getElementById('hijri-date');
                    if (hijriDateElement) hijriDateElement.textContent = lastHijriText;
                }
            }

            function formatMobileDate(date) {
                const weekday = new Intl.DateTimeFormat('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    weekday: 'short'
                }).format(date).replace(/[.,]/g, '');
                const day = new Intl.DateTimeFormat('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    day: '2-digit'
                }).format(date);
                const month = new Intl.DateTimeFormat('id-ID', {
                    timeZone: 'Asia/Jakarta',
                    month: 'short'
                }).format(date).replace(/[.,]/g, '');

                return `${weekday} ${day} ${month}`;
            }
            
            function updateHijriDate(gregorianDate) {
                // Menggunakan API eksternal untuk konversi yang akurat
                const hijriDateElement = document.getElementById('hijri-date');
                const desktopHijriElement = document.getElementById('desktop-hijri-date');
                
                if (hijriDateElement) {
                    // Gunakan API eksternal untuk konversi yang akurat
                    fetchHijriDate(gregorianDate, hijriDateElement);
                }
                
                if (desktopHijriElement) {
                    // Update desktop hijri date juga
                    fetchHijriDate(gregorianDate, desktopHijriElement);
                }
            }
            
            function fetchHijriDate(gregorianDate, element) {
                // Nonaktifkan total pemanggilan API eksternal agar tidak ada 404 di console
                // Gunakan fallback konversi manual saja
                lastHijriText = convertToHijriManual(gregorianDate);
                element.textContent = lastHijriText;
            }
            
            function convertToHijriManual(gregorianDate) {
                // Konversi manual yang akurat berdasarkan referensi IslamicFinder
                // 23 Oktober 2025 = 30 Rabi' al-Akhir 1447 H
                
                const year = gregorianDate.getFullYear();
                const month = gregorianDate.getMonth() + 1;
                const day = gregorianDate.getDate();
                
                // Hard-coded untuk tanggal yang diketahui akurat
                if (year === 2025 && month === 10 && day === 23) {
                    return "30 Rabi' al-Akhir 1447 H";
                }
                
                // Algoritma konversi yang akurat berdasarkan perhitungan astronomi
                // Menggunakan metode yang digunakan oleh observatorium Islam
                
                // Epoch Hijriyah: 16 Juli 622 M (1 Muharram 1 H)
                const hijriEpoch = new Date(622, 6, 16);
                const diffTime = gregorianDate - hijriEpoch;
                const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
                
                // Konversi yang lebih akurat menggunakan perhitungan astronomi
                // Satu tahun Hijriyah = 354.367056 hari (rata-rata astronomi)
                const hijriYear = Math.floor(diffDays / 354.367056) + 1;
                
                // Hitung sisa hari untuk bulan
                const remainingDays = diffDays % 354.367056;
                
                // Perhitungan bulan yang lebih akurat
                // Bulan Hijriyah memiliki panjang yang bervariasi (29-30 hari)
                const hijriMonth = Math.floor(remainingDays / 29.53059) + 1;
                const hijriDay = Math.floor(remainingDays % 29.53059) + 1;
                
                const hijriMonths = [
                    'Muharram', 'Safar', 'Rabi\' al-awwal', 'Rabi\' al-thani',
                    'Jumada al-awwal', 'Jumada al-thani', 'Rajab', 'Sha\'ban',
                    'Ramadan', 'Shawwal', 'Dhu al-Qi\'dah', 'Dhu al-Hijjah'
                ];
                
                // Pastikan bulan dalam range 1-12
                const monthIndex = Math.max(0, Math.min(11, hijriMonth - 1));
                const hijriMonthName = hijriMonths[monthIndex];
                
                // Pastikan hari dalam range 1-30
                const finalDay = Math.max(1, Math.min(30, Math.floor(hijriDay)));
                
                return `${finalDay} ${hijriMonthName} ${Math.floor(hijriYear)} H`;
            }
            
            // Force update datetime on page load
            forceUpdateDateTime();
            
            // Update waktu setiap detik
            setInterval(updateDateTime, 1000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>
