@extends('adminlte::page')

@section('title', 'Profile Masjid')

@section('content_header')
    <h1>Profile Masjid</h1>
    <hr>
@stop

@section('content')
    @livewire('admin.profile-masjid')
@stop

@section('css')
    <link href="//cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@stop

@section('js')
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
@stop
