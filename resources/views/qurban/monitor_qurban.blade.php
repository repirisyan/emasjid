@extends('adminlte::page')

@section('title', 'Monitor Qurban')

@section('content_header')
    <h1 class="text-center"><img src="{{ asset('assets/img/mosque.png') }}" alt="" style="width: 50px;height:50px">
        Monitoring Qurban</h1>
    <hr>
@stop

@section('content')
    @livewire('qurban.monitoring')
@stop

@section('css')
@stop
@section('js')
@stop
