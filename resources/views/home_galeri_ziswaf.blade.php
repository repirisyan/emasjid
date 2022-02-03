@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Galeri Kegiatan')
@section('content')
    <div class="container">
        @livewire('home-galeri-ziswaf')
    </div>
@endsection
