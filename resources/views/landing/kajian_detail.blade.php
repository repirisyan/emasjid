@extends('layouts.app')
@section('custom_css')
    <style>
        .card {
            margin-bottom: 20px
        }

        #content {
            min-height: 100vh
        }

    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-8">
            @foreach ($data as $item)
                <div class="col-md-12 mt-5">
                    <div style="width: 100%;">
                        <img src="{{ asset('storage/kajian_online/' . $item->thumbnail) }}"
                            class="card-img-top rounded mx-auto d-block" style="height:300px" alt="...">
                        <div class="card-body">
                            <h1 class="text-center">{{ $item->judul }}</h1>
                            <hr>
                            <p>{!! $item->berita !!}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-md-4 mt-5 d-none d-sm-block">
            <span class="text-uppercase">Kajian Online terbaru</span>
            <hr>
            @foreach ($berita_terbaru as $item)
                <div class="row">
                    <div class="col-md-4 col-sm-6 mb-4">
                        <img src="{{ asset('storage/kajian_online/' . $item->thumbnail) }}" class="img-thumbnail">
                    </div>
                    <div class="col-md-8 col-sm-6">
                        <div class="col-md-12">
                            <a href="{{ url('/home/kajian/detail/' . $item->id) }}"
                                class="text-decoration-none text-uppercase" style="font-size: 18px">{{ $item->judul }}</a>
                        </div>
                        <div class="col-md-12">
                            <small class="text-muted"><i class="fa fa-fw fa-calendar"></i>
                                {{ $item->created_at->format('d M Y') }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
