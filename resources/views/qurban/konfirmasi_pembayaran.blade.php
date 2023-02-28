@extends('adminlte::page')

@section('title', 'Konfirmasi Pembayaran')

@section('content_header')
    <h1>Konfirmasi Pembayaran</h1>
    <hr>
@stop

@section('content')
    @livewire('qurban.konfirmasi-pembayaran')
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
