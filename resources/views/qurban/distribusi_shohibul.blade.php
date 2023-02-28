@extends('adminlte::page')

@section('title', 'Distribusi Shohibul Qurban')

@section('content_header')
    <h1>Distribusi Shohibul Qurban</h1>
    <hr>
@stop

@section('content')
    @livewire('qurban.distribusi-shohibul')
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

        window.livewire.on('userProgress', () => {
            $('#modalProgress').modal('hide');
        });
    </script>
@stop
