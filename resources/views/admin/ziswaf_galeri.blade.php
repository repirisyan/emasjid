@extends('adminlte::page')

@section('title', 'Kelola Galeri Kegiatan')

@section('content_header')
    <h1>Galeri Kegiatan</h1>
    <hr>
@stop

@section('content')
    @livewire('galeri-ziswaf')
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
