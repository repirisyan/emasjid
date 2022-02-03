@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Imam & Muadzin')
@section('content')
    <div class="container">
        @livewire('home-imam-muadzin')
    </div>
@endsection
