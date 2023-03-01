@extends('layouts.app')
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
    <h3>Laporan Keuangan Ziswaf</h3>
    @livewire('landing.keuangan-ziswaf')
    <hr>
    <h3>Galeri Kegiatan</h3>
    <div class="text-cneter mt-2" id="lightgallery">
        @foreach ($galeris as $item)
            <a href="{{ asset('storage/galeri/' . $item->picture) }}">
                <img style="width: 200px;" alt="{{ $item->keterangan }}"
                    src="{{ asset('storage/galeri/' . $item->picture) }}" />
            </a>
        @endforeach
    </div>
@endsection
@section('custom_js')
    <script src="{{ asset('plugin/lightgalery/dist/lightgallery.umd.js') }}"></script>
    <script src="{{ asset('plugin/lightgalery/dist/plugins/thumbnail/lg-thumbnail.umd.js') }}"></script>
    <script src="{{ asset('plugin/lightgalery/dist/plugins/zoom/lg-zoom.umd.js') }}"></script>
    <script type="text/javascript">
        lightGallery(document.getElementById('lightgallery'), {
            plugins: [lgZoom, lgThumbnail],
            speed: 500,
        });
    </script>
@endsection
