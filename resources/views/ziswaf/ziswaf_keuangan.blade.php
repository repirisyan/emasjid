@extends('adminlte::page')

@section('title', 'Laporan Keuangan Ziswaf')

@section('content_header')
    <h1>Laporan Keuangan Ziswaf</h1>
    <hr>
@stop

@section('content')
    @livewire('ziswaf.laporan-keuangan-ziswaf')
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
