@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Struktur Organisasi')
@section('content')
    <div class="container">
        @livewire('home-organisasi')
    </div>
@endsection
