<div wire:init="loadPosts">
    {{-- In work, do what you enjoy. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah"><i
                    class="fa fa-fw fa-plus"></i> Tambah</button>
            <a class="btn btn-sm btn-secondary" href="#" target="__blank">Export&nbsp;<i
                    class="fa fa-fw fa-file-excel"></i></a>
            <div class="form-inline float-right">
                <input class="form-control" wire:model.lazy="search" type="search" placeholder="Cari Nama..."
                    aria-label="Search">
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm" style="white-space: nowrap">
                <thead>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Desa</th>
                    <th scope="col">Kecamatan</th>
                    <th scope="col">Blok</th>
                    <th scope="col">Gender</th>
                    <th scope="col">Pekerjaan</th>
                    <th scope="col" class="text-center"></th>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->nama_lengkap }}</td>
                            <td>{{ $item->alamat }}</td>
                            <td>{{ $item->desa }}</td>
                            <td>{{ $item->kecamatan }}</td>
                            <td>{{ $item->blok }}</td>
                            <td><i
                                    class="fa fa-fw fa-{{ $item->gender == 'Laki-laki' ? 'mars' : 'venus' }}"></i>{{ $item->gender }}
                            </td>
                            <td>{{ $item->pekerjaan }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                        id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-fw fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <button wire:loading.attr="disabled" type="button" data-toggle="modal"
                                            data-target="#modalUbah" class="dropdown-item"
                                            wire:click="edit('{{ $item->id }}')"><i
                                                class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                        <button wire:loading.attr="disabled" class="dropdown-item text-danger"
                                            wire:click="triggerConfirm('{{ $item->id }}')"><i
                                                class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if ($readyToLoad == true)
                <div>
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah-->
    <div wire:ignore.self class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Mustahik</h5>
                    <button type="button" class="close" wire:click="resetFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" wire:model.defer="nama"
                            class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Lengkap">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="alamat"
                            class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="desa"
                            class="form-control @error('desa') is-invalid @enderror" placeholder="Desa">
                        @error('desa') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="kecamatan"
                            class="form-control @error('kecamatan') is-invalid @enderror" placeholder="Kecamatan">
                        @error('kecamatan') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="blok"
                            class="form-control @error('blok') is-invalid @enderror" placeholder="Blok">
                        @error('blok') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <select wire:model.defer="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option>-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        @error('gender') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="pekerjaan"
                            class="form-control @error('pekerjaan') is-invalid @enderror" placeholder="Pekerjaan">
                        @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div>@enderror
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

    <!-- Modal Ubah-->
    <div wire:ignore.self class="modal fade" id="modalUbah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Event</h5>
                    <button type="button" class="close" wire:click="resetFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" wire:model.defer="nama"
                            class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Lengkap">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="alamat"
                            class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">
                        @error('alamat') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="desa"
                            class="form-control @error('desa') is-invalid @enderror" placeholder="Desa">
                        @error('desa') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="kecamatan"
                            class="form-control @error('kecamatan') is-invalid @enderror" placeholder="Kecamatan">
                        @error('kecamatan') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="blok"
                            class="form-control @error('blok') is-invalid @enderror" placeholder="Blok">
                        @error('blok') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <select wire:model.defer="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="Laki-laki"><i class="fa fa-fw fa-mars"></i>&nbsp;Laki-laki</option>
                            <option value="Perempuan"><i class="fa fa-fw fa-venus"></i>&nbsp;Perempuan</option>
                        </select>
                        @error('gender') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="pekerjaan"
                            class="form-control @error('pekerjaan') is-invalid @enderror" placeholder="Pekerjaan">
                        @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="update()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End of line --}}
</div>
