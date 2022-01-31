@extends('layouts.app')
@section('custom_css')
    <style>
        .card {
            margin-bottom: 20px
        }

        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('title','Monitoring Qurban')
@section('content')
    <h1 class="animate__animated animate__fadeInDown text-center mt-5 text-muted"><img src="{{ asset('assets/img/mosque.png') }}" alt=""
            style="width: 50px;height:50px"> Monitoring Qurban {{ date('Y') }}</h1>
    <hr>
    @livewire('monitoring')
@endsection
