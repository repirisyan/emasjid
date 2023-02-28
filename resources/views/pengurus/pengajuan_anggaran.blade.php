@extends('adminlte::page')

@section('title', 'Pengajuan Anggaran')

@section('content_header')
    <h1>Pengajuan Anggaran</h1>
    <hr>
@stop

@section('content')
    @livewire('pengurus.pengajuan-anggaran')
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
