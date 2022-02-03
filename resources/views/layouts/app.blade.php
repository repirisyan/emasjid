<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

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
    <script data-pace-options='{ "ajax": false }' src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/flash.css') }}">
    @yield('custom_css')
    @livewireStyles
    <link rel="shortcut icon" href="{{ asset('storage/favicons/favicon.ico') }}" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}"><img src="{{ asset('storage/logo/mosque.png') }}"
                    alt="" style="width: 25px; heigh:25px">
                <small> E-Masjid</small></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item @if (Request::is('home/ustadz') || Request::is('home/profile/visimisi') || Request::is('home/profile/sejarah') || Request::is('home/profile/organisasi') || Request::is('home/imam-muadzin')) active @endif dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-fw fa-mosque"></i>&nbsp;Profil
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('home/profile/visimisi') }}">Visi Misi</a>
                            <a class="dropdown-item" href="{{ url('home/profile/sejarah') }}">Sejarah</a>
                            <a class="dropdown-item" href="{{ url('home/profile/organisasi') }}">Struktur
                                Organisasi</a>
                            <a class="dropdown-item" href="{{ url('home/imam-muadzin') }}">Imam dan Muadzin</a>
                            <a class="dropdown-item" href="{{ url('home/ustadz') }}">Database Ustadz</a>
                        </div>
                    </li>
                    <li class="nav-item @if (Request::is('home/kajian-rutin') || Request::is('home/sholat-jumat') || Request::is('home/kajian-online')) active @endif dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown1" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-fw fa-quran"></i>&nbsp;Kajian
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown1">
                            <a class="dropdown-item" href="{{ url('home/kajian-online') }}">Kajian Online</a>
                            <a class="dropdown-item" href="{{ url('home/sholat-jumat') }}">Jadwal Imam dan Khotib
                                Jumat</a>
                            <a class="dropdown-item" href="{{ url('home/kajian-rutin') }}">Jadwal Kajian Rutin</a>
                        </div>
                    </li>
                    <li class="nav-item @if (Request::is('home/ziswaf/visimisi') || Request::is('home/galeri/ziswaf')) active @endif dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-fw fa-users"></i>&nbsp;Divisi Ziswaf
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                            <a class="dropdown-item" href="{{ url('home/ziswaf/visimisi') }}">Visi Misi</a>
                            <a class="dropdown-item" href="{{ url('home/galeri/ziswaf') }}">Galeri Kegiatan</a>
                        </div>
                    </li>
                    <li class="nav-item @if (Request::is('home/keuangan') || Request::is('home/keuangan/ziswaf')) active @endif dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-fw fa-file"></i>&nbsp;Laporan
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
                            <a class="dropdown-item" href="{{ url('home/keuangan') }}">Laporan Kas Operational
                                Masjid</a>
                            <a class="dropdown-item" href="{{ url('home/keuangan/ziswaf') }}">Laporan Ziswaf</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('home/event') ? 'active' : '' }}" aria-current="page"
                            href="{{ url('home/event') }}"><i class="fa fa-fw fa-calendar"></i> Event</a>
                    </li>
                    <li class="nav-item @if (Request::is('home/galeri') || Request::is('home/berita')) active @endif dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown4" role="button"
                            data-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-fw fa-image"></i>&nbsp;Galeri
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown4">
                            <a class="dropdown-item" href="{{ url('home/galeri') }}">Foto</a>
                            <a class="dropdown-item" href="{{ url('home/berita') }}">Berita</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('home/qurban/monitoring') ? 'active' : '' }}"
                            aria-current="page" href="{{ route('home.monitoring_qurban') }}"><i
                                class="fa fa-fw fa-desktop"></i> Monitoring Qurban</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Request::is('home/kontak') ? 'active' : '' }}" aria-current="page"
                            href="{{ url('home/kontak') }}"><i class="fa fa-fw fa-envelope"></i>&nbsp;Kontak</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    @if (Route::has('login'))
                        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                            @auth
                                <a href="{{ url('/home') }}" class="btn btn-sm text-sm text-black underline"><i
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
    <footer class="mt-3 mb-3">
        <hr>
        <div class="card-footer bg-light bg-gradient text-black text-center">
            <div>
                CopyRight &copy; Repi Maulana Risyan</div> <a target="__blank" href="https://github.com/repirisyan98"><i
                    class="fab fa-github"></i>&nbsp;repirisyan98</a>
        </div>
    </footer>
    @livewireScripts
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    @yield('custom_js')
</body>

</html>
