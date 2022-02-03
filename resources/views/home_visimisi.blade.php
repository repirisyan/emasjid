@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Profil Visi Misi')
@section('content')
    <div class="container">
        @livewire('home-visi-misi')
    </div>
@endsection
