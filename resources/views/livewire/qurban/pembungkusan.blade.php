<div>
    {{-- In work, do what you enjoy. --}}
    <button class="btn btn-primary mb-4 mr-4" data-toggle="modal" data-target="#modalTambah">Tambah <i
            class="fa fa-fw fa-plus"></i></button>
    <div class="row" wire:init="loadPosts">
        @foreach ($data_pembungkusan as $item)
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-light">
                        <div class="dropdown">
                            <b><time>{{ $item->created_at->format('Y') }}</time></b>
                            <span>{{ $item->master_hewan->nama }}</span>
                            <a role="button" id="dLabel{{ $item->id }}" class="float-right" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-fw fa-ellipsis-v"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dLabel{{ $item->id }}">
                                <a class="dropdown-item" wire:click="info()" role="button"><i
                                        class="fa fa-fw fa-info-circle text-info"></i>&nbsp;Informasi</a>
                                <a class="dropdown-item" data-toggle="modal" data-target="#modalUbah"
                                    wire:click="$set('new_id',{{ $item->id }})" role="button"><i
                                        class="fa fa-fw fa-edit"></i>
                                    Ubah</a>
                                <a class="dropdown-item" wire:click="triggerConfirm('{{ $item->id }}')"
                                    role="button"><i class="fa fa-fw fa-trash text-danger"></i> Hapus</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="text-center"><b>{{ $item->jumlah }}</b>/<b>{{ $item->jumlahProduksi }}</b>
                        </h3>
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="number" wire:model.defer="jumlahProduksi" class="form-control"
                                    aria-describedby="basic-addon{{ $item->id }}">
                                <div class="input-group-prepend">
                                    <button class="input-group-text bg-success"
                                        wire:click="inputJumlah('{{ $item->id }}')"
                                        id="basic-addon{{ $item->id }}"><i class="fa fa-fw fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Ubah-->
    <div wire:ignore.self class="modal fade" id="modalUbah" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal Ubah Pebungkusan</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input placeholder="Total Pembungkusan" required
                                class="form-control @error('jumlah') is-invalid @enderror" type="number"
                                wire:model.defer="jumlah">
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Tambah-->
    <div wire:ignore.self class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal Tambah Pembungkusan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='store'>
                    <div class="modal-body">
                        <div class="form-group">
                            <select wire:model.defer="nama" required
                                class="form-control @error('nama') is-invalid @enderror">
                                <option>-- Pilih Hewan Qurban --</option>
                                @foreach ($master_hewan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input class="form-control" type="text" readonly value="{{ date('Y') }}">
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" placeholder="Total Bungkus" min="0" required
                                    class="form-control @error('jumlah') is-invalid @enderror"
                                    wire:model.defer="jumlah">
                                <span class="input-group-text">Bungkus</span>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End Of File --}}
</div>
