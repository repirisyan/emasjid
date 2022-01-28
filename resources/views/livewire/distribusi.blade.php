<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah <i
                    class="fa fa-fw fa-plus"></i></button>
            <div class="dropdown float-right">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    Filter Progress <i
                        class="fa fa-fw {{ $status == 0 ? 'fa-clock fa-spin' : 'fa-check-circle' }}"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" wire:click="filterSearch('1')">Terpenuhi</a>
                    <a class="dropdown-item" href="#" wire:click="filterSearch('0')">Menunggu</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <th scope="col">Nama</th>
                        <th scope="col" class="text-center">Jumlah</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </thead>
                    <tbody wire:init="loadPosts">
                        @foreach ($data_distribusi as $item)
                            <tr>
                                <td class="align-middle">{{ $item->nama }}</td>
                                <td class="align-middle text-center">
                                    {{ $item->jumlah }}/{{ $item->progressDistribusi }}</td>
                                <td class="align-middle">
                                    @if ($item->status != 0)
                                        <span class="badge bg-teal">Distribusi Terpenuhi <i
                                                class="fa fa-fw fa-check"></i></span>
                                    @endif
                                </td>
                                <td>
                                    @if ($item->status == 0)
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-fw fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                                <button data-toggle="modal" type="button" data-target="#modalProgress"
                                                    wire:click="setProgress('{{ $item->id }}','{{ $item->jumlah }}','{{ $item->progressDistribusi }}')"
                                                    class="dropdown-item text-primary"><i
                                                        class="fa fa-fw fa-plus"></i>&nbsp;Input
                                                    Progress</button>
                                                <button class="dropdown-item" type="button"
                                                    wire:click="setData('{{ $item->id }}','{{ $item->nama }}','{{ $item->jumlah }}')"
                                                    data-toggle="modal" data-target="#modalUbah"><i
                                                        class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                                <button wire:loading.attr="disabled" type="button"
                                                    wire:click="triggerConfirm('{{ $item->id }}')"
                                                    class="dropdown-item text-danger"><i
                                                        class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
                                                <button wire:loading.attr="disabled" type="button"
                                                    {{ $item->jumlah != $item->progressDistribusi ? 'hidden' : null }}
                                                    wire:click="verified('{{ $item->id }}')"
                                                    class="dropdown-item text-teal"><i
                                                        class="fa fa-fw fa-check"></i>&nbsp;Terpenuhi</button>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($readyToLoad == true)
                <div class="float-right">
                    {{ $data_distribusi->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah-->
    <div wire:ignore.self class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Distribusi</h5>
                    <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" wire:model.defer="nama" placeholder="Nama"
                            class="form-control @error('nama') is-invalid @enderror">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="number" min="0" placeholder="Jumlah"
                                class="form-control @error('jumlah') is-invalid @enderror" wire:model.defer="jumlah">
                            <span class="input-group-text" id="basic-addon1">Bungkus</span>
                            @error('jumlah') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
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
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Ubah Data Distribusi</h5>
                    <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" wire:model.defer="nama"
                            class="form-control @error('nama') is-invalid @enderror">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="number" min="0" class="form-control @error('jumlah') is-invalid @enderror"
                            wire:model.defer="jumlah">
                        @error('jumlah') <div class="invalid-feedback">{{ $message }}</div>@enderror
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

    <!-- Modal Input progress-->
    <div wire:ignore.self class="modal fade" id="modalProgress" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Progress Distribusi</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="for-group">
                        <input type="number" placeholder="Jumlah Progress"
                            class="form-control @error('progress') is-invalid @enderror" wire:model.defer="progress">
                        @error('progress') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="resetFields()"
                        data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" wire:click="progressDistribusi()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End of File --}}
</div>
