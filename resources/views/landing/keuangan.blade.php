@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }
    </style>
@endsection
@section('title', 'Laporan Keuangan')
@section('content')
    <div class="container">
        @livewire('landing.keuangan')
    </div>
@endsection
