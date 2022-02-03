@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title', 'Laporan Keuangan Ziswaf')
@section('content')
    <div class="container">
        @livewire('home-keuangan-ziswaf')
    </div>
@endsection
