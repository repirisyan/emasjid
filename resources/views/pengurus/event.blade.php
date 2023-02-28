@extends('adminlte::page')

@section('title', 'Kelola Event')

@section('content_header')
    <h1>Kelola Event</h1>
    <hr>
@stop

@section('content')
    @livewire('pengurus.event')
@stop

@section('css')
@stop

@section('js')
    <script>
        window.livewire.on('userStore', () => {
            $('#modalTambah').modal('hide');
        });

        window.livewire.on('userDaftar', () => {
            $('#modalDaftar').modal('hide');
        });

        window.livewire.on('userDaftarUpdate', () => {
            $('#modalDaftarUpdate').modal('hide');
        });

        window.livewire.on('userUpdate', () => {
            $('#modalUbah').modal('hide');
        });
    </script>
@stop
