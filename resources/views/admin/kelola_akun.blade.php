@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Kelola Akun</h1>
    <hr>
@stop

@section('content')
    @livewire('users')
@stop

@section('css')
@stop

@section('js')
    <script>
        window.livewire.on('userUpdate', () => {
            $('#modalUbah').modal('hide');
        });
        window.livewire.on('userStore', () => {
            $('#modalTambah').modal('hide');
        });
    </script>

@stop
