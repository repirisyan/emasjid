@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Event')
@section('content')
    <div class="container">
        @livewire('home-event')
    </div>
@endsection
@section('custom_js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <x-livewire-alert::scripts />
    <script>
        window.livewire.on('userStore', () => {
            $('#modalDaftar').modal('hide');
        });
    </script>
@endsection
