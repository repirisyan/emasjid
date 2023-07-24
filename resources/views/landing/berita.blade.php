@extends('layouts.app')

@section('meta_tags')
    <meta name="description" content="Berita {{ env('APP_NAME') }}">
@endsection

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

@section('title', 'Berita')

@section('content')
    <div class="container">
        @livewire('landing.berita')
    </div>
@endsection
