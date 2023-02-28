<div wire:init="loadPosts">
    {{-- In work, do what you enjoy. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah"><i
                    class="fa fa-fw fa-plus"></i> Tambah</button>
            <a class="btn btn-sm btn-success" href="{{ url('mustahik/export/') }}">Export&nbsp;<i
                    class="fa fa-fw fa-file-excel"></i></a>
            <div class="form-inline float-right">
                <div class="input-group mb-2">
                    <input class="form-control" wire:model.lazy="search" type="search"
                        placeholder="Cari nama mustahik..." aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="fa fa-fw fa-search"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>Desa</th>
                        <th>Kecamatan</th>
                        <th>Blok</th>
                        <th>Gender</th>
                        <th>Pekerjaan</th>
                        <th class="text-center"></th>
                    </thead>
                    <tbody>
                        @if (empty($data))
                            <tr>
                                <td colspan="8" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data as $item)
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
                                        <button wire:loading.attr="disabled" type="button" data-toggle="modal"
                                            data-target="#modalUbah" class="btn btn-sm btn-warning"
                                            wire:click="edit('{{ $item->id }}')"><i
                                                class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                        <button wire:loading.attr="disabled" class="btn btn-sm btn-danger"
                                            wire:click="triggerConfirm('{{ $item->id }}')"><i
                                                class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center align-middle">
                                        Tidak ada data
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
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
                <form wire:submit.prevent='store'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model.defer="nama" required
                                class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Lengkap">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="alamat" required
                                class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="desa" required
                                class="form-control @error('desa') is-invalid @enderror" placeholder="Desa">
                            @error('desa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="kecamatan" required
                                class="form-control @error('kecamatan') is-invalid @enderror" placeholder="Kecamatan">
                            @error('kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="blok" required
                                class="form-control @error('blok') is-invalid @enderror" placeholder="Blok">
                            @error('blok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select wire:model.defer="gender" required
                                class="form-control @error('gender') is-invalid @enderror">
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki"><i class="fa fa-fw fa-mars"></i>&nbsp;Laki-laki</option>
                                <option value="Perempuan"><i class="fa fa-fw fa-venus"></i>&nbsp;Perempuan</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="pekerjaan" required
                                class="form-control @error('pekerjaan') is-invalid @enderror" placeholder="Pekerjaan">
                            @error('pekerjaan')
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

    <!-- Modal Ubah-->
    <div wire:ignore.self class="modal fade" id="modalUbah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Mustahik</h5>
                    <button type="button" class="close" wire:click="resetFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model.defer="nama" required
                                class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Lengkap">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="alamat" required
                                class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="desa" required
                                class="form-control @error('desa') is-invalid @enderror" placeholder="Desa">
                            @error('desa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="kecamatan" required
                                class="form-control @error('kecamatan') is-invalid @enderror"
                                placeholder="Kecamatan">
                            @error('kecamatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="blok" required
                                class="form-control @error('blok') is-invalid @enderror" placeholder="Blok">
                            @error('blok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select wire:model.defer="gender" required
                                class="form-control @error('gender') is-invalid @enderror">
                                <option value="Laki-laki"><i class="fa fa-fw fa-mars"></i>&nbsp;Laki-laki</option>
                                <option value="Perempuan"><i class="fa fa-fw fa-venus"></i>&nbsp;Perempuan</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="pekerjaan" required
                                class="form-control @error('pekerjaan') is-invalid @enderror"
                                placeholder="Pekerjaan">
                            @error('pekerjaan')
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
    {{-- End of line --}}
</div>
