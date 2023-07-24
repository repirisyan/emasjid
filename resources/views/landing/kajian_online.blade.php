@extends('layouts.app')

@section('meta_tags')
    <meta name="description" content="Kajian Online {{ env('APP_NAME') }}">
@endsection

@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }
    </style>
@endsection

@section('title', 'Kajian Online')

@section('content')
    <div class="container">
        @livewire('landing.kajian-online')
    </div>
@endsection
