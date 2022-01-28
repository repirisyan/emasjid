@extends('adminlte::page')

@section('title', 'Laporan Keuangan')

@section('content_header')
    <h1>Laporan Keuangan</h1>
    <hr>
@stop

@section('content')
    @livewire('laporan-keuangan')
@stop

@section('css')
@stop

@section('js')
    <script>
        window.livewire.on('userStore', () => {
            $('#modalTambah').modal('hide');
        });
        window.livewire.on('userTutup', () => {
            $('#modalTutup').modal('hide');
        });
        window.livewire.on('userUpdate', () => {
            $('#modalUbah').modal('hide');
        });
    </script>
@stop
