@extends('layouts.app')

@section('meta_tags')
    <meta name="description" content="Monitring Qurban {{ env('APP_NAME') }}">
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

@section('title', 'Monitoring Qurban')

@section('content')
    <h1 class="animate__animated animate__fadeInDown text-center mt-5"><img src="{{ asset('assets/img/mosque.webp') }}"
            alt="Logo Mesjid" style="max-width: 50px;max-height:50px"> Monitoring Qurban
        {{ date('Y') }}</h1>
    <hr>
    @livewire('qurban.monitoring')
@endsection
