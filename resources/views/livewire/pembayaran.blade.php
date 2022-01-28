<div wire:init="loadPosts">
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="card">
        <div class="card-header">
            @if (config('app.debug') == true)
                <button class="btn btn-sm btn-danger" wire:click="triggerReset()">Reset Data (Development Only)<i
                        class="fa fa-fw fa-exclamation-triangle"></i></button>
            @endif
            <div class="dropdown float-right">
                <img src="{{ asset('assets/icon_qurban/' . ($id_master_hewan == 1 ? 'cow.png' : 'goat.png')) }}"
                    class="mr-2" alt="" srcset="" style="width: 50px; height: 50px">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    Filter Hewan
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach ($master_hewan as $item)
                        <a class="dropdown-item" href="#"
                            wire:click="$set('id_master_hewan','{{ $item->id }}')">{{ $item->nama }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-body">
            <div>
                <table class="table text-center" style="white-space: nowrap">
                    <thead>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($data_pembayaran as $item)
                            <tr>
                                <td class="align-middle">{{ $item->user->name }}</td>
                                <td class="align-middle">{{ $item->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-fw fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <button class="dropdown-item" data-toggle="modal"
                                                data-target="#modalDetail"
                                                wire:click="detail('{{ $item->user->name }}','{{ $item->user->alamat }}','{{ $item->master_hewan->nama }}','{{ $item->hewan->tipe }}','{{ $item->hewan->harga }}','{{ $item->permintaan_daging }}','{{ $item->kode_pembayaran }}','{{ $item->metode_pembayaran }}','{{ $item->atasNama }}','{{ $item->user->kontak }}')"><i
                                                    class="fa fa-fw fa-info"></i>&nbsp;Detail</button>
                                            <button class="dropdown-item" wire:loading.attr="disabled"
                                                data-toggle="modal" data-target="#modalUbah"
                                                wire:click="setUpdate('{{ $item->id }}','{{ $item->master_hewan->id }}','{{ $item->atasNama }}','{{ $item->permintaan_daging }}')"><i
                                                    class="fa fa-fw fa-edit"></i>&nbsp;Ubah Data</button>
                                            <button class="dropdown-item text-danger" wire:loading.attr="disabled"
                                                wire:click="triggerTolak('{{ $item->id }}')"><i
                                                    class="fa fa-fw fa-times-circle"></i>&nbsp;Tolak</button>
                                            <button class="dropdown-item text-teal" wire:loading.attr="disabled"
                                                wire:click="triggerConfirm('{{ $item->hewan->id }}','{{ $item->id }}','{{ $item->master_hewan->id }}')"><i
                                                    class="fa fa-fw fa-check"></i>&nbsp;Konfirmasi</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($readyToLoad == true)
                <div>
                    {{ $data_pembayaran->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Detail-->
    <div wire:ignore.self class="modal fade" id="modalDetail" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-fw fa-user"></i>
                        {{ $nama }}</h5>
                    <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th class="text-muted">Alamat</th>
                                <td><i class="fa fa-fw fa-location-arrow"></i> {{ $alamat }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Kontak</th>
                                <td><i class="fa fa-fw fa-phone"></i> {{ $kontak }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Nama Hewan</th>
                                <td><i class="fa fa-fw fa-hippo"></i> {{ $nama_hewan }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tipe</th>
                                <td><i class="fa fa-fw fa-font"></i> {{ $tipe }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Harga</th>
                                <td><i class="fa fa-fw fa-dollar-sign"></i> {{ number_format($harga, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <th class="text-muted">Permintaan Daging</th>
                                <td><i class="fa fa-fw fa-drumstick-bite"></i> {{ $permintaan_daging }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Atas Nama</th>
                                <td><i class="fa fa-fw fa-signature"></i> {{ $atasNama }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Metode Pembayaran</th>
                                <td><i class="fa fa-fw fa-credit-card"></i> {{ $metode_pembayaran }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Kode Pembayaran</th>
                                <td><i class="fa fa-fw fa-barcode"></i> {{ $kode_pembayaran }}</td>
                            </tr>
                        </table>
                    </div>
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
                        <label class="font-weight-light" for="">Permintaan Daging</label>
                        <div class="input-group">
                            <input type="number" min="0" wire:model.defer="permintaan_daging"
                                class="form-control @error('permintaan_daging') is-invalid @enderror"
                                max="{{ $this->id_master_hewan == 1 ? 10 : 5 }}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">Bungkus</span>
                            </div>
                        </div>
                        @error('permintaan_daging') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-light" for="">Atas Nama</label>
                        <input type="text" wire:model.defer="atasNama"
                            class="form-control @error('atasNama') is-invalid @enderror">
                        @error('atasNama') <div class="invalid-feedback">{{ $message }}</div>@enderror
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
    {{-- End Of File --}}
</div>
