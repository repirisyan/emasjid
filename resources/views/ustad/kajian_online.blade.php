@extends('adminlte::page')

@section('title', 'Kajian Online')

@section('content_header')
    <h1>Kajian Online</h1>
    <hr>
@stop

@section('content')
    @livewire('ustad.kajian-online')
@stop

@section('css')
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@stop

@section('js')
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
@stop
