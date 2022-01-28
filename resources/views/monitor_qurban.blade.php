@extends('adminlte::page')

@section('title', 'Monitor Qurban')

@section('content_header')
    <h1 class="animate__animated animate__flash text-center text-muted"><img src="{{ asset('assets/img/mosque.png') }}" alt=""
            style="width: 50px;height:50px"> Monitoring Qurban</h1>
    <hr>
@stop

@section('content')
    @livewire('monitoring')
@stop

@section('css')
@stop
@section('js')
@stop
