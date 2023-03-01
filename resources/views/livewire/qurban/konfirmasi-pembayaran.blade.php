<div wire:init="loadPosts">
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="card">
        <div class="card-header">
            @if (config('app.debug') == true)
                <button class="btn btn-sm btn-danger" wire:click="triggerReset()">Reset Data (Development Only)<i
                        class="fa fa-fw fa-exclamation-triangle"></i></button>
            @endif
            <div class="form-row float-right">
                <div class="col">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-fw fa-filter"></i></div>
                        </div>
                        <select class="form-control" wire:model.lazy='filter_hewan'>
                            <option value="">-- Pilih jenis hewan --</option>
                            @foreach ($master_hewan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <th>Jenis Hewan</th>
                        <th>Atas Nama</th>
                        <th>Tanggal</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @if (empty($data_pembayaran))
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data_pembayaran as $item)
                                <tr>
                                    <td class="align-middle">{{ $item->master_hewan->nama }}</td>
                                    <td class="align-middle">{{ $item->atasNama }}</td>
                                    <td class="align-middle">{{ $item->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-info" data-toggle="modal"
                                                data-target="#modalDetail" wire:click="detail('{{ $item->id }}')"><i
                                                    class="fa fa-fw fa-info"></i>&nbsp;Detail</button>
                                            <button class="btn btn-sm btn-warning" wire:loading.attr="disabled"
                                                data-toggle="modal" data-target="#modalUbah"
                                                wire:click="edit('{{ $item->id }}')"><i
                                                    class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                type="button" id="dropdownMenuButton1" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa fa-fw fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <button class="dropdown-item text-danger" wire:loading.attr="disabled"
                                                    wire:click="triggerTolak('{{ $item->id }}')"><i
                                                        class="fa fa-fw fa-times-circle"></i>&nbsp;Tolak</button>
                                                <button class="dropdown-item text-success" wire:loading.attr="disabled"
                                                    wire:click="triggerConfirm('{{ $item->hewan->id }}','{{ $item->id }}','{{ $item->master_hewan->id }}')"><i
                                                        class="fa fa-fw fa-check"></i>&nbsp;Terima</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
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
                                <td><i class="fa fa-fw fa-drumstick-bite"></i> {{ $permintaan_daging }} Bungkus</td>
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
                                max="{{ $this->master_hewan_id == 1 ? 10 : 5 }}">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">Bungkus</span>
                            </div>
                        </div>
                        @error('permintaan_daging')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-light" for="">Atas Nama</label>
                        <input type="text" wire:model.defer="atasNama"
                            class="form-control @error('atasNama') is-invalid @enderror">
                        @error('atasNama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
