@extends('adminlte::page')

@section('title', 'Visi Misi Divisi Ziswaf')

@section('content_header')
    <h1>Visi Misi Divisi Ziswaf</h1>
    <hr>
@stop

@section('content')
    @livewire('ziswaf.visi-misi')
@stop

@section('css')
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@stop

@section('js')
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
@stop
