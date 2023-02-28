@extends('adminlte::page')

@section('title', 'Hewan Qurban')

@section('content_header')
    <h1>Hewan Qurban</h1>
    <hr>
@stop

@section('content')
    @livewire('qurban.hewan-qurban')
@stop

@section('css')
@stop
@section('js')
    <script>
        window.livewire.on('userStore', () => {
            $('#modalTambah').modal('hide');
        });
        window.livewire.on('userUpdate', () => {
            $('#modalUbah').modal('hide');
        });
    </script>
@stop
