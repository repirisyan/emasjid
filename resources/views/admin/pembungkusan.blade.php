@extends('adminlte::page')

@section('title', 'Pembungkusan Daging Qurban')

@section('content_header')
    <h1>Pembungkusan Daging Qurban</h1>
    <hr>
@stop

@section('content')
    @livewire('pembungkusan')
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
