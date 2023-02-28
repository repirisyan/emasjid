@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }
    </style>
@endsection
@section('title', 'Kajian Online')
@section('content')
    <div class="container">
        @livewire('landing.kajian-online')
    </div>
@endsection