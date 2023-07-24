@extends('layouts.app')
@section('meta_tags')
    <meta name="description" content="Tentang Kami {{ env('APP_NAME') }}">
@endsection
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }
    </style>
@endsection
@section('title', 'Profile Masjid')
@section('content')
    <div class="mt-5">
        {!! $data->visi_misi !!}
        <hr>
        {!! $data->sejarah !!}
        <hr>
        <h3>Struktur Organisasi</h3>
        <img src="{{ asset('storage/struktur_organisasi/struktur_organisasi.webp') }}" loading='lazy'
            alt="Struktur Organisasi Img">
    </div>
@endsection
