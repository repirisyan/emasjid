@extends('adminlte::page')

@section('title', 'Pendaftaran Qurban')

@section('content_header')
    <h1>Pendaftaran Qurban</h1>
    <hr>
@stop

@section('content')
    @livewire('pendaftaran-qurban')
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
