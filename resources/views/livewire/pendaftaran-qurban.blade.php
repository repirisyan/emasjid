<div>
    {{-- Be like water. --}}
    @php
        $no = 1;
    @endphp
    <div x-data="{ open: false }">
        <div class="card">
            <div class="card-header">
                <button @click="open = ! open" class="btn btn-sm btn-primary"><i
                        class="fa fa-fw fa-plus"></i>Daftar</button>
                <div class="dropdown float-right">
                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-expanded="false">Filter Status
                        @if ($status == 0)
                            <i class="fa fa-fw fa-clock fa-spin"></i>
                        @elseif($status == 1)
                            <i class="fa fa-fw fa-check"></i>
                        @elseif($status == 2)
                            <i class="fa fa-fw fa-times-circle"></i>
                        @elseif($status == 3)
                            <i class="fa fa-fw fa-check-double"></i>
                        @endif
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" wire:click="filterSearch('0')">Menunggu</a>
                        <a class="dropdown-item" href="#" wire:click="filterSearch('1')">Terkonfirmasi</a>
                        <a class="dropdown-item" href="#" wire:click="filterSearch('2')">Ditolak</a>
                        <a class="dropdown-item" href="#" wire:click="filterSearch('3')">Selesai</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table text-center" style='white-space: nowrap'>
                        <thead>
                            <th>Nama Hewan</th>
                            <th>Antrian Sembelih</th>
                            <th>Permintaan Daging</th>
                            <th>Status Pembayaran</th>
                            <th></th>
                        </thead>
                        <tbody wire:init="loadPosts">
                            @foreach ($data_pendaftaran as $item)
                                <tr>
                                    <td>
                                        {{ $item->master_hewan->nama }}
                                    </td>
                                    <td class="align-middle">
                                        @if ($item->status == 1 || $item->status == 3)
                                            @if ($item->qurban->antrian == null)
                                                <small class="text-muted">Data antrian tidak tersedia</small>
                                            @else
                                                {{ $item->qurban->antrian }}
                                            @endif

                                        @else
                                            <small class="text-muted">Tidak tersedia</small>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if ($item->status == 3)
                                            <i class="fa fa-fw fa-lg fa-check text-success"></i>
                                        @else
                                            <small class="text-muted">Belum Terpenuhi</small>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if ($item->status == 0)
                                            <i class="fa fa-fw fa-spinner fa-spin"></i>
                                        @elseif($item->status == 1 || $item->status == 3)
                                            <i class="fa fa-fw fa-lg fa-check text-success"></i>
                                        @elseif($item->status == 2)
                                            <i class="fa fa-fw fa-lg fa-times-circle text-danger"></i>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                                id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                                <i class="fa fa-fw fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                <button class="dropdown-item" data-toggle="modal"
                                                    data-target="#modalDetail"
                                                    wire:click="detail('{{ $item->user->name }}','{{ $item->user->alamat }}','{{ $item->master_hewan->nama }}','{{ $item->hewan->tipe }}','{{ $item->hewan->harga }}','{{ $item->permintaan_daging }}','{{ $item->kode_pembayaran }}','{{ $item->metode_pembayaran }}','{{ $item->atasNama }}','{{ $item->user->kontak }}', '{{ $item->created_at->format('d M Y') }}')"><i
                                                        class="fa fa-fw fa-info"></i> Detail</button>
                                                @if ($item->status == 0)
                                                    <button @click="open = false" class="dropdown-item"
                                                        data-toggle="modal" data-target="#modalUbah"
                                                        wire:click="setUpdate('{{ $item->id }}','{{ $item->master_hewan->id }}','{{ $item->permintaan_daging }}','{{ $item->metode_pembayaran }}','{{ $item->atasNama }}')"><i
                                                            class="fa fa-fw fa-edit"></i>Ubah Data</button>
                                                    <button @click="open = false" wire:loading.attr="disabled"
                                                        class="dropdown-item text-danger"
                                                        wire:click="triggerConfirm({{ $item->id }})"><i
                                                            class="fa fa-fw fa-trash"></i>
                                                        Hapus</button>
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
                    <div>
                        {{ $data_pendaftaran->links() }}
                    </div>
                @endif
            </div>
        </div>
        <div class="card" x-show="open" x-transition>
            <div class="card-header">
                <div class="dropdown float-left">
                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-fw fa-hippo"></i> {{ $id_master_hewan == 1 ? 'Sapi' : 'Kambing' }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @foreach ($master_hewan as $item)
                            <a class="dropdown-item" href="#"
                                wire:click="$set('id_master_hewan','{{ $item->id }}')">{{ $item->nama }}</a>
                        @endforeach
                    </div>
                </div>
                <button @click="open = false" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                @if ($data_hewan == '[]')
                    <p class="text-center">
                        Data Tidak Ditemukan
                    </p>
                @endif
                <div class="row">
                    @foreach ($data_hewan as $item)
                        <div class="col-md-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    @if ($item->master_hewan->id == 1)
                                        <img src="{{ asset('assets/icon_qurban/cow.png') }}"
                                            style="width: 100px;height: 100px" class="rounded mx-auto d-block" alt="">
                                    @else
                                        <img src="{{ asset('assets/icon_qurban/goat.png') }}"
                                            style="width: 100px;height: 100px" class="rounded mx-auto d-block" alt="">
                                    @endif
                                    <br>
                                    <h5 class="text-center">
                                        Tipe
                                    </h5>
                                    <h3 class="text-center">{{ $item->tipe }}</h3>
                                    <h5 class="animate__animated animate__pulse text-center bg-light"><b>Rp
                                            {{ number_format($item->harga, '0', ',', '.') }}</b></h5>
                                    <button class="btn bg-teal btn-block"
                                        wire:click="setData('{{ $item->id }}','{{ $item->master_hewan_id }}','{{ auth()->user()->name }}')"
                                        data-toggle="modal" data-target="#modalTambah">
                                        Bayar <i class="fa fa-fw fa-money-bill-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- Modal Tambah-->
        <div wire:ignore.self class="modal fade" data-backdrop="static" data-keyboard="false" id="modalTambah"
            tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal Daftar Qurban</h5>
                        <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <select wire:model.defer="pembayaran"
                                class="form-control @error('pembayaran') is-invalid @enderror">
                                <option>Pilih Metode Pembayaran</option>
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                            @error('pembayaran') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" placeholder="Permintaan Daging" min="0"
                                    wire:model.defer="permintaan"
                                    class="form-control @error('permintaan') is-invalid @enderror">
                                <div class="  input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Bungkus</span>
                                </div>
                                @error('permintaan') <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="  input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Atas Nama</span>
                                </div>
                                <input type="text" wire:model.defer="atasNama"
                                    class="form-control @error('atasNama') is-invalid @enderror">
                                @error('atasNama') <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="resetFields()"
                            data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" wire:click="daftar()">Simpan</button>
                    </div>
                </div>
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
                                    <td><i class="fa fa-fw fa-dollar-sign"></i>
                                        {{ number_format($harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Permintaan Daging</th>
                                    <td><i class="fa fa-fw fa-drumstick-bite"></i> {{ $permintaan }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Atas Nama</th>
                                    <td><i class="fa fa-fw fa-signature"></i> {{ $atasNama }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Metode Pembayaran</th>
                                    <td><i class="fa fa-fw fa-credit-card"></i> {{ $pembayaran }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Kode Pembayaran</th>
                                    <td><i class="fa fa-fw fa-barcode"></i> {{ $kode_pembayaran }}</td>
                                </tr>
                                <tr>
                                    <th class="text-muted">Tanggal</th>
                                    <td><i class="fa fa-fw fa-calendar"></i> {{ $date }}</td>
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
                            <select wire:model.defer="pembayaran" class="form-control">
                                <option value="Tunai">Tunai</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                            @error('pembayaran') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" min="0" wire:model.defer="permintaan"
                                    class="form-control @error('permintaan') is-invalid @enderror">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Bungkus</span>
                                </div>
                                @error('permintaan') <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="  input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Atas Nama</span>
                                </div>
                                <input type="text" wire:model.defer="atasNama"
                                    class="form-control @error('atasNama') is-invalid @enderror">
                                @error('atasNama') <div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
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
    </div>
    {{-- End of File --}}
</div>
