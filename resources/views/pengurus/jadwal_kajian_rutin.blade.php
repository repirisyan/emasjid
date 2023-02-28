@extends('adminlte::page')

@section('title', 'Jadwal Kajian Rutin')

@section('content_header')
    <h1>Jadwal Kajian Rutin</h1>
    <hr>
@stop

@section('content')
    @livewire('pengurus.jadwal-kajian-rutin')
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
