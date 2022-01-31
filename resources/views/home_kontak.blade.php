@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Kontak Pesan')
@section('content')
    <div class="container">
        @livewire('home-kontak')
    </div>
@endsection
@section('custom_js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
@endsection
