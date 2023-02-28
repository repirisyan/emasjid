<div>
    {{-- Close your eyes. Count to one. That is how long forever feels. --}}
    <div class="card">
        <div class="card-body">
            <form wire:submit.prevent='update'>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group text-center">
                            <img src="{{ asset('storage/profile/' . auth()->user()->picture) }}"
                                class="img-circle elevation-2" style="width: 100px;height: 100px;cursor: pointer;"
                                alt="Profile Picture" srcset="">
                        </div>
                        <div class="form-group text-center">
                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <!-- File Input -->
                                <input type="file" wire:model="photo" class="@error('photo') is-invalid @enderror">
                                <!-- Progress Bar -->
                                <div x-show="isUploading">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>
                            </div>
                            <small>Format : png, jpg, jepg</small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="">Nama <i class="fa fa-fw fa-signature"></i></label>
                            <input type="text" wire:model.defer="name" class="form-control"
                                placeholder="Nama Lengkap">
                            @error('name')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
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
                            @error('JenisKelamin')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for=""><i class="fa fa-fw fa-calendar"></i> Tanggal Lahir</label>
                            <input type="date" wire:model.defer="TanggalLahir" class="form-control"
                                placeholder="Tanggal Lahir">
                            @error('TanggalLahir')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for=""><i class="fa fa-fw fa-globe"></i> Tempat Lahir</label>
                            <input type="text" wire:model.defer="TempatLahir" class="form-control"
                                placeholder="Tempat Lahir" maxlength="255">
                            @error('TempatLahir')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="">Alamat <i class="fa fa-fw fa-location-arrow"></i></label>
                            <textarea class="form-control" wire:model.defer="alamat" cols="30" rows="5"></textarea>
                            @error('alamat')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">No Handphone <i class="fa fa-fw fa-phone"></i></label>
                            <input type="text" readonly wire:model.defer="kontak" class="form-control"
                                placeholder="Tempat Lahir" maxlength="12">
                            @error('kontak')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Email <i class="fa fa-fw fa-envelope"></i></label>
                            <input type="email" readonly wire:model.defer="email" class="form-control"
                                placeholder="user@emajid.com">
                            @error('email')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" data-toggle="modal" data-target="#modalUbah"
                                    class="btn btn-sm btn-secondary d-inline-flex"><i class="fa fa-fw fa-lock"></i>
                                    Ubah
                                    Kata Sandi</button>
                                <button type="submit" wire:loading.attr="disabled"
                                    class="btn btn-sm d-inline-flex btn-primary"><i class="fa fa-fw fa-save"></i>
                                    Simpan</button>
                            </div>
                            <div class="col-md-12 mt-4">
                                <small class="text-muted">Last Update {{ $updated_at }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="password"
                            wire:model.defer="password_confirmation @error('password_confirmation') is-invalid @enderror"
                            class="form-control" placeholder="Konfirmasi Password">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
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
