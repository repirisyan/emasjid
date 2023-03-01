@extends('layouts.app')
@section('custom_css')
    <style>
        #content {
            min-height: 100vh
        }
    </style>
@endsection
@section('content')
    @foreach ($data as $item)
        <div class="mt-5">
            <div class="text-center">
                <img src="{{ asset('storage/' . $item->kategori == '1' ? 'berita' : 'kajian_online' . '/' . $item->thumbnail) }}"
                    alt="{{ $item->thumbnail }}">
                <h1 class="text-center mt-2">{{ $item->judul }}</h1>
            </div>
            <hr>
            <div style="overflow-wrap: break-word;">
                {!! $item->berita !!}
            </div>
        </div>
    @endforeach
@endsection
