<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title')
    </title>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

        @if (config('adminlte.google_fonts.allowed', true))
            <link rel="preload" as="font"
                href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        @endif
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif


    {{-- Livewire Styles --}}
    @if (config('adminlte.livewire'))
        @if (app()->version() >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('custom_css')

    {{-- Favicon --}}
    @if (config('adminlte.use_ico_only'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
    @elseif(config('adminlte.use_full_favicon'))
        <link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('favicons/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('favicons/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('favicons/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('favicons/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('favicons/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('favicons/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('favicons/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('favicons/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicons/apple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicons/favicon-16x16.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicons/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicons/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('favicons/android-icon-192x192.png') }}">
        <link rel="manifest" crossorigin="use-credentials" href="{{ asset('favicons/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="{{ asset('favicon/ms-icon-144x144.png') }}">
    @endif
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('storage/logo/mosque.webp') }}"
                    alt="Logo Masjid" style="max-width: 25px; max-heigh:25px">
                <small>&nbsp;{{ env('APP_NAME') }}
                </small></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('landing/tentang-kami') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('landing.profile_masjid') }}"><i
                                class="fa fa-fw fa-mosque"></i>&nbsp;Tentang</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('landing/ziswaf') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('landing.ziswaf') }}"><i class="fa fa-fw fa-users"></i>&nbsp;Ziswaf</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('landing/galeri') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('landing.galeri') }}"><i class="fa fa-fw fa-image"></i>&nbsp;Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('landing/berita') ? 'active' : '' }}" aria-current="page"
                            href="{{ route('landing.berita') }}"><i
                                class="fa fa-fw fa-newspaper"></i>&nbsp;Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('landing/kajian-online') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('landing.kajian_online') }}"><i
                                class="fa fa-fw fa-quran"></i>&nbsp;Kajian Online</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('landing/qurban/monitoring') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('landing.monitoring_qurban') }}"><i
                                class="fa fa-fw fa-desktop"></i>&nbsp;Monitoring Qurban</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                            @auth
                                <a href="{{ url('/landing') }}" class="btn btn-sm text-sm text-black underline"><i
                                        class="fa fa-fw fa-sign-in-alt"></i> Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-sm text-sm text-black underline"><i
                                        class="fas fa-fw fa-sign-in-alt"></i> Masuk</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="btn btn-sm ml-4 text-sm text-black underline"><i
                                            class="fa fa-fw fa-user"></i> Registrasi</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    @yield('carousel')
    <div class="container" id="content">
        @yield('content')
    </div>
    <footer class="mt-2 mb-2 text-center">
        <hr>
        &copy; 2022 <a target="_blank" href="https://github.com/repirisyan98"><i
                class="fab fa-github"></i>&nbsp;repirisyan98</a> All Right Reserved
    </footer>

    @if (!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif

    {{-- Livewire Script --}}
    @if (config('adminlte.livewire'))
        @if (app()->version() >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif
    @yield('custom_js')
</body>

</html>
