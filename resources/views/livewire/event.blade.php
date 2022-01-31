<div wire:init="loadPosts" x-data="{ open: false }">
    {{-- In work, do what you enjoy. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" @click="open = false" data-toggle="modal" data-target="#modalTambah"><i
                    class="fa fa-fw fa-plus"></i>&nbsp;Tambah</button>
            <div class="dropdown float-right">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-fw fa-filter"></i> {{ $status == 1 ? 'Aktif' : 'Nonaktif' }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" wire:click="$set('status','1')" @click="open = false">Aktif</a>
                    <a class="dropdown-item" href="#" wire:click="$set('status','2')" @click="open = false">Nonaktif</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm" style="white-space: nowrap">
                <thead>
                    <th scope="col">Nama Event</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center"></th>
                </thead>
                <tbody>
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $item->nama_event }}</td>
                            <td>{{ $item->tanggal_event }}</td>
                            <td>
                                @if ($item->status == 1)
                                    <small class="badge badge-primary">Aktif</small>
                                @else
                                    <small class="badge badge-danger">Tidak AKtif</small>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                        id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa fa-fw fa-ellipsis-h"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <button wire:loading.attr="disabled" type="button" @click="open = true"
                                            class="dropdown-item"
                                            wire:click="contributor('{{ $item->id }}','{{ $item->nama_event }}')"><i
                                                class="fa fa-fw fa-eye"></i>&nbsp;Peserta</button>
                                        <button wire:loading.attr="disabled" type="button" data-toggle="modal"
                                            data-target="#modalUbah" class="dropdown-item"
                                            wire:click="edit('{{ $item->id }}')"><i
                                                class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                        @if ($item->status == 1)
                                            <button wire:loading.attr="disabled" class="dropdown-item text-danger"
                                                wire:click="triggerUpdate('{{ $item->id }}','2')"><i
                                                    class="fa fa-fw fa-times-circle"></i>&nbsp;Nonaktifkan</button>
                                        @else
                                            <button wire:loading.attr="disabled" class="dropdown-item text-success"
                                                wire:click="triggerUpdate('{{ $item->id }}','1')"><i
                                                    class="fa fa-fw fa-check"></i>&nbsp;Aktifkan</button>
                                        @endif
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

    <div class="card" x-show="open" x-transition>
        <div class="card-header">
            <span class="font-weight-bold">{{ $nama_event }}</span>
            <button @click="open = false" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Tanggal Lahir</th>
                            <th>Tempat Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>No Handphone</th>
                            <th>Alamat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($contributor == '[]')
                            <tr>
                                <td colspan="6" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @else
                            @foreach ($contributor as $item)
                                <tr>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>{{ $item->tanggal_lahir }}</td>
                                    <td>{{ $item->tempat_lahir }}</td>
                                    <td><i
                                            class="fa fa-fw fa-{{ $item->jenis_kelamin == 'Laki-laki' ? 'mars' : 'venus' }}"></i>{{ $item->jenis_kelamin }}
                                    </td>
                                    <td>
                                        {{ $item->no_hp }}
                                    </td>
                                    <td>{{ $item->alamat }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah-->
    <div wire:ignore.self class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Event</h5>
                    <button type="button" class="close" wire:click="resetFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" wire:model.defer="nama"
                            class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Event">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="date" wire:model.defer="tanggal"
                            class="form-control @error('tannggal') is-invalid @enderror" placeholder="Tanggal">
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div>@enderror
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

    <!-- Modal Lihat-->
    <div wire:ignore.self class="modal fade" id="modalPeserta" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Peserta Event</h5>
                    <button type="button" class="close" wire:click="resetFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (isset($contributor))
                        <table>
                            @foreach ($contributor as $item)
                            @endforeach
                        </table>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
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
                            class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Event">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="date" wire:model.defer="tanggal"
                            class="form-control @error('tannggal') is-invalid @enderror" placeholder="Tanggal">
                        @error('tanggal') <div class="invalid-feedback">{{ $message }}</div>@enderror
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
