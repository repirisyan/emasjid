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
@section('title', 'Berita')
@section('content')
    <div class="container">
        @livewire('landing.berita')
    </div>
@endsection