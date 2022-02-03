@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Divisi Ziswaf Visi Misi')
@section('content')
    <div class="container">
        @livewire('home-ziswaf-visimisi')
    </div>
@endsection
