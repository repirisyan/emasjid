@extends('adminlte::page')

@section('title', 'Sejarah Masjid')

@section('content_header')
    <h1>Sejarah Masjid</h1>
    <hr>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            Sejarah Masjid
        </div>
        <div class="card-body">
            <form action="{{ url('admin/settings/masjid/sejarah/update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="form-group">
                    <div class="col-md-12">
                        <textarea class="form-control @error('sejarah') is-invalid @enderror" name="sejarah"
                            id="editor">@isset($data->sejarah){{ $data->sejarah }}@endisset</textarea>
                            @error('sejarah') <div class="invalid-feedback">{{ $message }}</div>@enderror
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
