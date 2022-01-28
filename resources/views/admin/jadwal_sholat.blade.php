@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Kelola Jadwal Sholat Jumat</h1>
    <hr>
@stop

@section('content')
    @livewire('jadwal-sholat')
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
