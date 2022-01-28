@extends('adminlte::page')

@section('title', 'Kelola Berita')

@section('content_header')
    <h1>Kelola Berita</h1>
    <hr>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            Form Ubah Berita
        </div>
        <div class="card-body">
            @foreach ($data as $item)
                <form action="{{ url('pengurus/berita/' . $item->id . '/update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <input name="judul" placeholder="Judul" type="text" value="{{ $item->judul }}"
                            class="w-50 form-control @error('jabatan') is-invalid @enderror">
                        @error('judul') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" required name="deskripsi"
                                id="editor">{{ $item->berita }}</textarea>
                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <img src="{{ asset('storage/berita/' . $item->thumbnail) }}"
                            alt="" class="img-thumbnail mb-2">
                        <input name="thumbnail_old" type="hidden" value="{{ $item->thumbnail }}">
                        <input name="thumbnail" type="file"
                            class="form-control-file @error('thumbnail') is-invalid @enderror" style="width: 250px"
                            id="exampleFormControlFile1">
                        @error('thumbnail') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <a href="{{ url('pengurus/berita') }}" class="float-left mr-2 mt-2"><i
                            class="fa fa-fw fa-arrow-left"></i> Kembali</a>
                    <button class="btn bg-teal float-right mr-2" type="submit"><i
                            class="fa fa-fw fa-bookmark"></i>Draft</button>
                </form>
            @endforeach
        </div>
    </div>
@stop

@section('css')
    <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
@stop
@section('js')
    @include('sweetalert::alert')
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.log(error);
            });
    </script>
@stop
