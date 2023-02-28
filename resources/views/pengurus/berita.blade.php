@extends('adminlte::page')

@section('title', 'Kelola Berita')

@section('content_header')
    <h1>Kelola Berita</h1>
    <hr>
@stop

@section('content')
    @livewire('pengurus.berita')
@stop

@section('css')
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@stop

@section('js')
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
@stop
