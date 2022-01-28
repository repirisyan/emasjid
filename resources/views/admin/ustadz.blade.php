@extends('adminlte::page')

@section('title', 'Kelola Ustadz')

@section('content_header')
    <h1>Kelola Ustadz</h1>
    <hr>
@stop

@section('content')
    @livewire('ustadz')
@stop

@section('css')
@stop

@section('js')
    <script>
        window.livewire.on('userUpdate', () => {
            $('#modalUbah').modal('hide');
        });
    </script>
    
@stop
