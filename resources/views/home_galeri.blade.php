@extends('layouts.app')
@section('custom_css')
    <style>
        .card {
            margin-bottom: 20px
        }

        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title','Galeri Foto')
@section('content')
    <div class="container">
        @livewire('home-galeri')
    </div>
@endsection
