@extends('layouts.app')
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
        <h3>Visi & Misi</h3>
        {!! $data->visi_misi !!}
        <hr>
        <h3>Sejarah</h3>
        {!! $data->sejarah !!}
        <hr>
        <h3>Struktur Organisasi</h3>
        <img src="{{ asset('storage/struktur_organisasi/struktur_organisasi.png') }}" alt="Struktur Organisasi Img">
    </div>
@endsection
@section('custom_js')
@endsection
