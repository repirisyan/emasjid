<div wire:init="loadPosts">
    {{-- In work, do what you enjoy. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah"><i
                    class="fa fa-fw fa-plus"></i> Tambah</button>
            <div class="dropdown float-right">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-fw fa-hippo"></i> {{ $master_id == 1 ? 'Sapi' : 'Kambing' }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach ($data_master as $item)
                        <a class="dropdown-item" href="#"
                            wire:click="filterSearch('{{ $item->id }}')">{{ $item->nama }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm" style="white-space: nowrap">
                <thead>
                    <th scope="col">Tipe</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Tahun</th>
                    <th scope="col" class="text-center"></th>
                </thead>
                <tbody>
                    @foreach ($data_hewan as $item)
                        <tr>
                            <td class="align-middle">
                                {{ $item->tipe }}
                            </td>
                            <td class="align-middle">
                                Rp. {{ number_format($item->harga, '0', ',', '.') }}
                            </td>
                            <td class="align-middle">
                                {{ date_format($item->created_at, 'Y') }}
                            </td>
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
                    {{ $data_hewan->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- Modal Tambah-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalTambah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Tambah Data Hewan</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control @error('master_id') is-invalid @enderror"
                            wire:model.defer="master_id">
                            @foreach ($data_master as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('master_id') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="tipe"
                            class="form-control @error('tipe') is-invalid @enderror" placeholder="Tipe">
                        @error('tipe') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Rp</span>
                            <input type="number" wire:model.defer="harga" aria-describedby="basic-addon1"
                                class="form-control @error('harga') is-invalid @enderror" placeholder="Harga">
                            @error('harga') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" value="{{ date('Y') }}" readonly class="form-control">
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
    <div wire:ignore.self.prevent data-backdrop="static" data-keyboard="false" class="modal fade" id="modalUbah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Ubah Data Hewan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control @error('master_id') is-invalid @enderror"
                            wire:model.defer="master_id">
                            @foreach ($data_master as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                        @error('master_id') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="tipe"
                            class="form-control @error('tipe') is-invalid @enderror" placeholder=" Limousin">
                        @error('tipe') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="number" wire:model.defer="harga"
                            class="form-control @error('harga') is-invalid @enderror" placeholder=" 12000000">
                        @error('harga') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="tahun" readonly class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="resetFields()"
                        data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="update()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End of line --}}
</div>
