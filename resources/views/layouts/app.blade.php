<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ env('APP_NAME') }} | @yield('title')</title>

    <!-- Fonts -->
    @if (!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
            integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
        {{-- Configured Stylesheets --}}
        @include('adminlte::plugins', ['type' => 'css'])
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/flash.css') }}">
    @yield('custom_css')
    @livewireStyles
    <link rel="shortcut icon" href="{{ asset('storage/favicons/favicon.ico') }}" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('storage/logo/mosque.png') }}"
                    alt="" style="width: 25px; heigh:25px">
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
                            href="{{ route('landing.berita') }}"><i class="fa fa-fw fa-newspaper"></i>&nbsp;Berita</a>
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
                class="fab fa-github"></i>&nbsp;repirisyan98</a>
    </footer>
    @livewireScripts
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    @yield('custom_js')
</body>

</html>
