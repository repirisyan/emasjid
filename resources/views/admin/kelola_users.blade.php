@extends('adminlte::page')

@section('title', 'Kelola Users')

@section('content_header')
    <h1>Users</h1>
    <hr>
@stop

@section('content')
    @livewire('admin.users')
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
