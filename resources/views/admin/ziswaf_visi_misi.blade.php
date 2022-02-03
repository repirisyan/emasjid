@extends('adminlte::page')

@section('title', 'Visi Misi Divisi Ziswaf')

@section('content_header')
    <h1>Visi Misi Divisi Ziswaf</h1>
    <hr>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            Visi Misi Divisi Ziswaf
        </div>
        <div class="card-body">
            <form action="{{ url('ziswaf/visimisi/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="form-group">
                    <div class="col-md-12">
                        <textarea class="form-control @error('visi_misi') is-invalid @enderror" name="visi_misi" id="editor">@isset($data->visi_misi)
                                                                        {{ $data->visi_misi }}
                                                @endisset</textarea>
                        @error('visi_misi') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <button class="btn btn-primary float-right mr-2" type="submit">Simpan</button>
            </form>
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
