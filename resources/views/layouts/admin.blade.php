<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    @php
        $siteSettings = \App\Models\SiteSetting::first();
        $siteName = $siteSettings->site_name ?? config('app.name', 'Web Demo Pendidikan');
    @endphp
    <title>@yield('title', 'Admin Panel') - {{ $siteName }}</title>
    @if($siteSettings && $siteSettings->favicon)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . $siteSettings->favicon) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Dynamic Admin Theme CSS -->
    <style>
        {!! \App\Helpers\ThemeHelper::generateAdminCSS() !!}
    </style>
    
    <!-- Custom Admin CSS -->
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 0.5rem;
            margin: 0.2rem 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
        }
        .main-content {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: bold;
            color: #667eea !important;
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border-radius: 0.75rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        .table th {
            border-top: none;
            font-weight: 600;
            color: #495057;
        }
        .badge {
            font-size: 0.75em;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar admin-sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        @php
                            $siteSettings = \App\Models\SiteSetting::first();
                        @endphp
                        @if($siteSettings && $siteSettings->logo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $siteSettings->logo) }}" alt="{{ $siteSettings->site_name }}" 
                                     class="img-fluid" style="max-height: 60px; max-width: 150px;">
                            </div>
                        @endif
                        <h4 class="text-white">
                            <i class="bi bi-shield-check"></i>
                            Admin Panel
                        </h4>
                        @if($siteSettings && $siteSettings->site_name)
                            <small class="text-white-50">{{ $siteSettings->site_name }}</small>
                        @endif
                    </div>
                    
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i>
                                Dashboard
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.site-settings*') ? 'active' : '' }}" href="{{ route('admin.site-settings.index') }}">
                                <i class="bi bi-gear"></i>
                                Pengaturan Website
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.sliders*') ? 'active' : '' }}" href="{{ route('admin.sliders.index') }}">
                                <i class="bi bi-images"></i>
                                Slider
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.running-texts*') ? 'active' : '' }}" href="{{ route('admin.running-texts.index') }}">
                                <i class="bi bi-text-paragraph"></i>
                                Running Text
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.menus*') ? 'active' : '' }}" href="{{ route('admin.menus.index') }}">
                                <i class="bi bi-list-ul"></i>
                                Menu
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.quick-links*') ? 'active' : '' }}" href="{{ route('admin.quick-links.index') }}">
                                <i class="bi bi-lightning-charge"></i>
                                Akses Cepat
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.institution-contacts*') ? 'active' : '' }}" href="{{ route('admin.institution-contacts.index') }}">
                                <i class="bi bi-whatsapp"></i>
                                CP Lembaga
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.pages*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                                <i class="bi bi-file-text"></i>
                                Halaman
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                                <i class="bi bi-tags"></i>
                                Kategori
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.admin-posts*') ? 'active' : '' }}" href="{{ route('admin.admin-posts.index') }}">
                                <i class="bi bi-newspaper"></i>
                                Post/Artikel
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.galleries*') ? 'active' : '' }}" href="{{ route('admin.galleries.index') }}">
                                <i class="bi bi-collection"></i>
                                Galeri
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.admin-programs*') ? 'active' : '' }}" href="{{ route('admin.admin-programs.index') }}">
                                <i class="bi bi-book"></i>
                                Program
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.announcements*') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}">
                                <i class="bi bi-megaphone"></i>
                                Pengumuman
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.downloads*') ? 'active' : '' }}" href="{{ route('admin.downloads.index') }}">
                                <i class="bi bi-download"></i>
                                Download
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}" href="{{ route('admin.testimonials.index') }}">
                                <i class="bi bi-chat-quote"></i>
                                Testimoni
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.statistics*') ? 'active' : '' }}" href="{{ route('admin.statistics.index') }}">
                                <i class="bi bi-graph-up"></i>
                                Statistik
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.features*') ? 'active' : '' }}" href="{{ route('admin.features.index') }}">
                                <i class="bi bi-star"></i>
                                Fitur
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.faqs*') ? 'active' : '' }}" href="{{ route('admin.faqs.index') }}">
                                <i class="bi bi-question-circle"></i>
                                FAQ
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.contacts*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">
                                <i class="bi bi-envelope"></i>
                                Kontak
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.comments*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                                <i class="bi bi-chat-dots"></i>
                                Komentar
                                @php
                                    $pendingComments = \App\Models\Comment::where('is_approved', false)->count();
                                @endphp
                                @if($pendingComments > 0)
                                    <span class="badge bg-warning ms-1">{{ $pendingComments }}</span>
                                @endif
                            </a>
                        </li>
                        
                        <li class="nav-item mt-3">
                            <a class="nav-link" href="{{ route('home') }}" target="_blank">
                                <i class="bi bi-eye"></i>
                                Lihat Website
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top navbar -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom admin-header">
                    <div class="d-flex align-items-center">
                        @php
                            $siteSettings = \App\Models\SiteSetting::first();
                        @endphp
                        @if($siteSettings && $siteSettings->logo)
                            <img src="{{ asset('storage/' . $siteSettings->logo) }}" alt="{{ $siteSettings->site_name }}" 
                                 class="me-3" style="max-height: 40px; max-width: 120px;">
                        @endif
                        <h1 class="h2 mb-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <div class="btn-group me-2">
                            <span class="text-muted">
                                <i class="bi bi-person-circle"></i>
                                {{ Auth::user()->name }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Page Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    
    @stack('scripts')
</body>
</html>
