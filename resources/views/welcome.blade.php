@extends('layouts.app')
@section('custom_css')
    <style>
        .card {
            margin-bottom: 20px
        }
    </style>
@endsection
@section('title', 'Beranda')
@section('carousel')
    <div class="container animate__animated animate__fadeIn animate__delay-2s text-center mt-5">
        <h1 id="surah_arab"></h1>
        <h2 id="nama_surah"></h2>
        <h5 id="keterangan_surah"></h5>
        <p id="deskripsi_surah"></p>
        <audio controls>
            <source id="surah_audio" type="audio/mpeg">
            Your browser does not support the audio element.
        </audio>
    </div>
@endsection
@section('content')
    <div class="mt-5">
        @livewire('home')
    </div>
@endsection
@section('custom_js')
    <script>
        $(document).ready(function() {
            var surah = Math.floor(Math.random() * 114) + 1;
            $.get("https://equran.id/api/surat/" + surah,
                function(data, jqXHR) {
                    $('#surah_audio').attr("src", data.audio);
                    $('#surah_arab').text(data.nama);
                    $('#nama_surah').html('<i>' + data.nama_latin + '</i>');
                    $('#keterangan_surah').text('Nomor Surat : ' + data.nomor + ', Jumlah Ayat : ' + data
                        .jumlah_ayat + ', Diturunkan : ' + data.tempat_turun);
                    $('#deskripsi_surah').html(data.deskripsi);
                });
        });
    </script>
@endsection
