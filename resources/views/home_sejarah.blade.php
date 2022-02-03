@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Profile Sejarah')
@section('content')
    <div class="container">
        @livewire('sejarah')
    </div>
@endsection
