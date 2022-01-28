@extends('adminlte::page')

@section('title', 'Produksi Qurban')

@section('content_header')
    <h1>Penyembelihan Qurban</h1>
    <hr>
@stop

@section('content')
    @livewire('qurban')
@stop

@section('css')
@stop
@section('js')
    <script>
        window.livewire.on('userStore', () => {
            $('#modalTambah').modal('hide');
        });
        window.livewire.on('antrian', () => {
            $('#modalAntrian').modal('hide');
        });
        window.livewire.on('userUpdate', () => {
            $('#modalUbah').modal('hide');
        });
    </script>
@stop
