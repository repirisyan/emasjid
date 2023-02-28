@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }
    </style>
    <link rel="stylesheet" href="{{ asset('plugin/lightgalery/dist/css/lightgallery-bundle.min.css') }}">
@endsection
@section('title', 'Galeri Foto')
@section('content')
    <div class="text-cneter mt-5" id="lightgallery">
        @foreach ($data as $item)
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
