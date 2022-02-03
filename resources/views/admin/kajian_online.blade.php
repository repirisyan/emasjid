@extends('adminlte::page')

@section('title', 'Kelola Kajian Online')

@section('content_header')
    <h1>Kelola Kajian Online</h1>
    <hr>
@stop

@section('content')
    @livewire('kajian-online')
@stop

@section('css')
    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
@stop
@section('js')
    @include('sweetalert::alert')
@stop
