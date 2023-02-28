@extends('adminlte::page')

@section('title', 'Jadwal Sholat Jumat')

@section('content_header')
    <h1>Jadwal Sholat Jumat</h1>
    <hr>
@stop

@section('content')
    @livewire('pengurus.jadwal-sholat-jumat')
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
