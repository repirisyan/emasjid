<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <form id="form-picture" wire:submit.prevent="change_picture">
                            <img onclick="change_picture()" data-toggle="tooltip" data-placement="right"
                                title="Klik untuk mengubah foto"
                                src="{{ asset('storage/profile/' . auth()->user()->picture) }}"
                                class="img-circle elevation-2" style="width: 100px;height: 100px;cursor: pointer;"
                                alt="Profile Picture" srcset="">
                            <input type="file" id="imgupload" wire:model.defer="photo" style="display:none">
                            @if ($photo != null)
                                <button class="ml-2 btn btn-sm btn-success mt-2" type="submit">Ubah <i
                                        class="fa fa-fw fa-upload"></i></button>
                            @endif
                            @if (auth()->user()->picture != 'default_picture.png')
                                <button class="ml-2 btn btn-sm btn-danger mt-2" wire:click="triggerConfirm()"
                                    type="button">Hapus <i class="fa fa-fw fa-trash"></i></button>
                            @endif
                            <br>
                            @error('photo') <span class="error">{{ $message }}</span> @enderror
                        </form>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="">Nama <i class="fa fa-fw fa-signature"></i></label>
                        <input type="text" wire:model.defer="name" class="form-control" placeholder="Nama Lengkap">
                        @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="">Jenis Kelamin</label>
                        <div class="form-check">
                            <div class="row">
                                <div class="col-md-6">
                                    <input class="form-check-input" type="radio" wire:model.lazy="JenisKelamin"
                                        value="Laki-laki">
                                    <label class="form-check-label mr-4" for="exampleRadios1">
                                        <i class="fa fa-fw fa-mars"></i> Laki-laki
                                    </label>
                                </div>
                                <div class="col-md-6">
                                    <input class="form-check-input" type="radio" wire:model.lazy="JenisKelamin"
                                        value="Perempuan">
                                    <label class="form-check-label" for="exampleRadios2">
                                        <i class="fa fa-fw fa-venus"></i> Perempuan
                                    </label>
                                </div>
                            </div>
                        </div>
                        @error('JenisKelamin') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for=""><i class="fa fa-fw fa-calendar"></i> Tanggal Lahir</label>
                        <input type="date" wire:model.defer="TanggalLahir" class="form-control"
                            placeholder="Tanggal Lahir">
                        @error('TanggalLahir') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for=""><i class="fa fa-fw fa-globe"></i> Tempat Lahir</label>
                        <input type="text" wire:model.defer="TempatLahir" class="form-control"
                            placeholder="Tempat Lahir" maxlength="255">
                        @error('TempatLahir') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="">Alamat <i class="fa fa-fw fa-location-arrow"></i></label>
                        <textarea class="form-control" wire:model.defer="alamat" cols="30" rows="5"></textarea>
                        @error('alamat') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="">No Handphone <i class="fa fa-fw fa-phone"></i></label>
                        <input type="text" readonly wire:model.defer="kontak" class="form-control"
                            placeholder="Tempat Lahir" maxlength="12">
                        @error('kontak') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="">Email <i class="fa fa-fw fa-envelope"></i></label>
                        <input type="email" readonly wire:model.defer="email" class="form-control"
                            placeholder="user@emajid.com">
                        @error('email') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="button" data-toggle="modal" data-target="#modalUbah"
                                class="btn btn-sm btn-secondary d-inline-flex"><i class="fa fa-fw fa-lock"></i> Ubah
                                Kata Sandi</button>
                            <button type="button" wire:loading.attr="disabled" wire:click="update()"
                                class="btn btn-sm d-inline-flex btn-primary"><i class="fa fa-fw fa-save"></i>
                                Simpan</button>
                        </div>
                        <div class="col-md-12 mt-4">
                            <small class="text-muted">Last Update {{ $updated_at }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" wire:ignore.self id="modalUbah" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Ubah Kata Sandi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="password" wire:model.defer="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password Baru">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="password"
                            wire:model.defer="password_confirmation @error('password_confirmation') is-invalid @enderror"
                            class="form-control" placeholder="Konfirmasi Password">
                        @error('password_confirmation') <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="update_password()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
