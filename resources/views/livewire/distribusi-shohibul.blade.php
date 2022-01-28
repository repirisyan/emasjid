<div wire:init="loadPosts">
    {{-- Stop trying to control. --}}
    <div class="card">
        <div class="card-header">
            <div class="form-inline float-right">
                <input class="form-control" wire:model.lazy="search" type="search" placeholder="Cari Nama..."
                    aria-label="Search">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <th>Atas Nama</th>
                        <th>Alamat</th>
                        <th>Hewan Qurban</th>
                        <th class="text-center">Antrian</th>
                        <th class="text-center">Jumlah Permintaan</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($data_shohibul as $item)
                            <tr>
                                <td class="align-middle">{{ $item->atasNama }}</td>
                                <td class="align-middle">{{ $item->user->alamat }}</td>
                                <td class="align-middle text-center">{{ $item->master_hewan->nama }}</td>
                                <td class="align-middle text-center">
                                    <small class="text-muted">
                                        {{ $item->qurban->antrian == null ? 'Tidak tersedia' : $item->qurban->antrian }}
                                    </small>
                                </td>
                                <td class="align-middle text-center">{{ $item->permintaan_daging }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-fw fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <button class="dropdown-item" data-toggle="modal" data-target="#modalUbah"
                                                wire:click="setUpdate('{{ $item->id }}','{{ $item->master_hewan->id }}','{{ $item->permintaan_daging }}','{{ $item->atasNama }}')"><i
                                                    class="fa fa-fw fa-edit"></i>Ubah Data</button>
                                            @if ($item->qurban->status == 2)
                                                <button
                                                    wire:click="triggerConfirm('{{ $item->id }}','{{ $item->permintaan_daging }}')"
                                                    class="dropdown-item text-teal"><i
                                                        class="fa fa-fw fa-check"></i>&nbsp;Konfirmasi</button>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($readyToLoad == true)
                <div>{{ $data_shohibul->links() }}</div>
            @endif
        </div>
    </div>
    <!-- Modal Ubah-->
    <div wire:ignore.self class="modal fade" id="modalUbah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal Ubah</h5>
                    <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Permintaan Daging</label>
                        <div class="input-group">
                            <input type="number" min="0" wire:model.defer="permintaan"
                                class="form-control @error('permintaan') is-invalid @enderror">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">Bungkus</span>
                            </div>
                        </div>
                        @error('permintaan') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label for="">Atas Nama</label>
                        <input type="text" wire:model.defer="atasNama"
                            class="form-control @error('atasNama') is-invalid @enderror">
                        @error('atasNama') <span class="text-danger error">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="resetFields()" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="update()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End of file --}}
</div>
