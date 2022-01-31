@extends('adminlte::page')

@section('title', 'Kelola Mustahik')

@section('content_header')
    <h1>Kelola Mustahik</h1>
    <hr>
@stop

@section('content')
    @livewire('mustahik')
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
