@extends('adminlte::page')

@section('title', 'Kelola Berita')

@section('content_header')
    <h1>Kelola Berita</h1>
    <hr>
@stop

@section('content')
    @livewire('berita')
@stop

@section('css')
    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
@stop
@section('js')
    @include('sweetalert::alert')
@stop
