@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Jadwal Sholat Jumat')
@section('content')
    <div class="container">
        @livewire('home-sholat-jumat')
    </div>
@endsection
