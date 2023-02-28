@extends('adminlte::page')

@section('title', 'Kelola Users')

@section('content_header')
    <h1>Kelola User</h1>
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
        window.livewire.on('userUpdateJabatan', () => {
            $('#modalTambahJabatan').modal('hide');
        });
    </script>
@stop
