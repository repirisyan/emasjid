<div wire:init="loadPosts">
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="row">
        @foreach ($data as $item)
            <div class="col-md-4 mt-5">
                <div class="card shadow" style="width: 18rem;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $item->nama_event }}</h5>
                        <p class="card-text"><i class="fa fa-fw fa-calendar"></i>&nbsp;{{ $item->tanggal_event }}</p>
                        <button wire:loading.attr="disabled" type="button" data-toggle="modal"
                            data-target="#modalDaftar" wire:click="$set('event_id','{{ $item->id }}')"
                            class="btn btn-primary btn-block btn-sm card-link">Daftar</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @if ($readyToLoad == true)
        <div class="d-flex justify-content-center">
            {{ $data->render('pagination::bootstrap-4') }}
        </div>
    @endif

    <!-- Modal Tambah-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalDaftar"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Daftar Event</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" wire:model.defer="nama_lengkap"
                            class="form-control @error('nama_lengkap') is-invalid @enderror" required
                            placeholder="Nama Lengkap">
                        @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="date" wire:model.defer="tanggal_lahir"
                            class="form-control @error('tanggal_lahir') is-invalid @enderror" required
                            placeholder="Tanggal Lahir">
                        @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="tempat_lahir"
                            class="form-control @error('tempat_lahir') is-invalid @enderror" required
                            placeholder="Tempat Lahir">
                        @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <select wire:model.defer="jenis_kelamin"
                            class="form-control @error('jenis_kelamin') is-invalid @enderror">
                            <option>-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" maxlength="12" wire:model.defer="no_hp"
                            class="form-control @error('no_hp') is-invalid @enderror" required placeholder="No HP">
                        @error('no_hp') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="alamat"
                            class="form-control @error('alamat') is-invalid @enderror" required placeholder="Alamat">
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="store()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>
