@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile</h1>
    <hr>
@stop

@section('content')
    @livewire('profile')
@stop

@section('css')
@stop

@section('js')
    <script>
        window.livewire.on('updatePassword', () => {
            $('#modalUbah').modal('hide');
        });
    </script>
@stop
