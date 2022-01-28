@extends('adminlte::page')

@section('title', 'Kelola Jadwal Kajian')

@section('content_header')
    <h1>Kelola Jadwal Kajian</h1>
    <hr>
@stop

@section('content')
    @livewire('jadwal-kajian')
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
