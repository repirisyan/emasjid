@extends('adminlte::page')

@section('title', 'Kelola Galeri')

@section('content_header')
    <h1>Galeri Masjid</h1>
    <hr>
@stop

@section('content')
    @livewire('pengurus.galeri')
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
