@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
@endif

@section('auth_header', __('adminlte::adminlte.register_message'))

@section('auth_body')
    <form action="{{ $register_url }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6">
                {{-- Name field --}}
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}" placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @error('name') <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tanggal Lahir field --}}
                <div class="input-group mb-3">
                    <input type="text" name="TanggalLahir" class="form-control @error('TanggalLahir') is-invalid @enderror"
                        value="{{ old('TanggalLahir') }}" placeholder="Tanggal Lahir" onfocus="(this.type='date')">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-calendar {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('TanggalLahir') <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Tempat Lahir field --}}
                <div class="input-group mb-3">
                    <input type="text" name="TempatLahir" class="form-control @error('TempatLahir') is-invalid @enderror"
                        value="{{ old('TempatLahir') }}" placeholder="Tempat Lahir" autofocus>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-globe {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('TempatLahir') <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jenis Kelamin field --}}
                <div class="input-group mb-3">
                    <select name="JenisKelamin" class="form-control @error('JenisKelamin') is-invalid @enderror">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-venus-mars {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('JenisKelamin') <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email field --}}
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="{{ __('adminlte::adminlte.email') }}">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('email') <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                {{-- Kontak field --}}
                <div class="input-group mb-3">
                    <input type="text" maxlength="12" name="kontak"
                        class="form-control @error('kontak') is-invalid @enderror" placeholder="Kontak"
                        value="{{ old('kontak') }}">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('kontak') <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat field --}}
                <div class="input-group mb-3">
                    <input type="text" name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                        placeholder="Alamat" value="{{ old('alamat') }}">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-location-arrow {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Password field --}}
                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                        placeholder="{{ __('adminlte::adminlte.password') }}">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>
                    @error('password') <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm password field --}}
                <div class="input-group mb-3">
                    <input type="password" name="password_confirmation"
                        class="form-control @error('password_confirmation') is-invalid @enderror"
                        placeholder="{{ __('adminlte::adminlte.retype_password') }}">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                        </div>
                    </div>

                    @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        {{-- Register button --}}
        <button type="submit" class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
            <span class="fas fa-user-plus"></span>
            {{ __('adminlte::adminlte.register') }}
        </button>

    </form>
@stop

@section('auth_footer')
    <p class="my-0">
        <a href="{{ $login_url }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@stop
