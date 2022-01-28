@extends('adminlte::page')

@section('title', 'Kelola Pengurus')

@section('content_header')
    <h1>Kelola Pengurus</h1>
    <hr>
@stop

@section('content')
    @livewire('pengurus')
@stop

@section('css')
@stop

@section('js')
    <script>
        window.livewire.on('userUpdate', () => {
            $('#modalUbah').modal('hide');
        });
    </script>
@stop
