@extends('layouts.app')

@section('meta_tags')
    <meta name="description" content="Galeri {{ env('APP_NAME') }}">
@endsection

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
    <div class="text-center mt-5" id="lightgallery">
        @forelse ($data as $item)
            <a href="{{ asset('storage/galeri/' . $item->picture) }}">
                <img style="width: 200px;" alt="{{ $item->keterangan }}" loading='lazy'
                    src="{{ asset('storage/galeri/' . $item->picture) }}" />
            </a>
        @empty
            <img src="{{ asset('assets/img/image_file_not_found.svg') }}" alt="Image Not Found" loading='lazy'
                style="max-width: 300px">
            <p class="text-center mt-2">
                Tidak ada data
            </p>
        @endforelse
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
