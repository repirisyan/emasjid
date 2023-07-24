@extends('layouts.app')
@section('meta_tags')
    <meta name="description" content="Halaman Utama {{ env('APP_NAME') }}">
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('assets/OwlCarousel2-2.3.4/dist/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.css') }}">
@endsection
@section('title', 'Halaman Utama')
@section('carousel')
    <div class="container animate__animated animate__fadeIn animate__delay-2s text-center mt-5">
        <h1 id="surah_arab"></h1>
        <h2 id="nama_surah"></h2>
        <h5 id="keterangan_surah"></h5>
        <p id="deskripsi_surah"></p>
        <audio controls>
            <source id="surah_audio" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
        <p>
            <a aria-label="Hyperlink to equran.id" href="https://equran.id" class="btn btn-outline-primary btn-sm"
                target="_blank">
                <i class="fa fa-fw fa-globe"></i> equran.id
            </a>
        </p>
    </div>
@endsection
@section('content')
    <div class="mt-5">
        @livewire('home')
    </div>
@endsection
@section('custom_js')
    <script src="{{ asset('assets/OwlCarousel2-2.3.4/dist/owl.carousel.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var surah = Math.floor(Math.random() * 114) + 1;
            $.get("https://equran.id/api/surat/" + surah,
                function(data, jqXHR) {
                    $('#surah_audio').attr("src", data.audio);
                    $('#surah_arab').text(data.nama);
                    $('#nama_surah').html('<i>' + data.nama_latin + '</i>');
                    $('#keterangan_surah').text('Nomor Surat : ' + data.nomor + ', Jumlah Ayat : ' + data
                        .jumlah_ayat + ', Diturunkan : ' + data.tempat_turun);
                    $('#deskripsi_surah').html(data.deskripsi);
                });
            $(".owl-carousel").owlCarousel({
                lazyLoad: true,
                nav: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    1000: {
                        items: 3
                    },
                }
            });
        });
    </script>
@endsection
