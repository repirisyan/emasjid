@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Database Ustadz')
@section('content')
    <div class="container">
        @livewire('home-ustadz')
    </div>
@endsection
