@extends('layouts.app')
@section('meta_tags')
    <meta name="description" content="Laporan Keuangan Ziswaf {{ env('APP_NAME') }}">
@endsection
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugin/lightgalery/dist/css/lightgallery-bundle.min.css') }}">
@endsection
@section('title', 'Divisi Ziswaf')
@section('content')
    <div class="mt-5"></div>
    {!! $data->visi_misi !!}
    <hr>
    <h4>Laporan Keuangan Ziswaf</h4>
    @livewire('landing.keuangan-ziswaf')
    <hr>
    <h3>Galeri Kegiatan</h3>
    <div class="text-center mt-5" id="lightgallery">
        @forelse ($galeris as $item)
            <a href="{{ asset('storage/galeri/' . $item->picture) }}">
                <img style="max-width: 200px;" alt="{{ $item->keterangan }}"
                    src="{{ asset('storage/galeri/' . $item->picture) }}" />
            </a>
        @empty
            <p>Tidak ada data</p>
        @endforelse
    </div>
@endsection
@section('custom_js')
    <script src="{{ asset('plugin/lightgalery/dist/lightgallery.umd.js') }}" defer></script>
    <script src="{{ asset('plugin/lightgalery/dist/plugins/thumbnail/lg-thumbnail.umd.js') }}" defer></script>
    <script src="{{ asset('plugin/lightgalery/dist/plugins/zoom/lg-zoom.umd.js') }}" defer></script>
    <script type="text/javascript" defer>
        lightGallery(document.getElementById('lightgallery'), {
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
        });
    </script>
@endsection
