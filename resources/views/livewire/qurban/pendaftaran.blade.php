<div wire:init='loadPosts'>
    {{-- Be like water. --}}
    <div x-data="{ open: false }">
        <div class="card">
            <div class="card-header">
                <button @click="open = ! open" class="btn btn-sm btn-primary"><i
                        class="fa fa-fw fa-plus"></i>Daftar</button>
                <div class="form-row float-right">
                    <div class="col">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-fw fa-filter"></i></div>
                            </div>
                            <select class="form-control" wire:model.lazy='filter_status'>
                                <option value="">-- Pilih status --</option>
                                <option value="0">Menunggu</option>
                                <option value="1">Terkonfirmasi</option>
                                <option value="2">Ditolak</option>
                                <option value="3">Selesai</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" style='white-space: nowrap'>
                        <thead>
                            <th>Nama Hewan</th>
                            <th class="text-center">Antrian Sembelih</th>
                            <th>Permintaan Daging</th>
                            <th>Status Pembayaran</th>
                            <th></th>
                        </thead>
                        <tbody>
                            @if (empty($data_pendaftaran))
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <i class="fa fa-spinner fa-spin"></i>
                                    </td>
                                </tr>
                            @else
                                @forelse ($data_pendaftaran as $item)
                                    <tr>
                                        <td>
                                            {{ $item->master_hewan->nama }}
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($item->status == 1 || $item->status == 3)
                                                @if ($item->qurban->antrian == null)
                                                    Data antrian tidak tersedia
                                                @else
                                                    {{ $item->qurban->antrian }}
                                                @endif
                                            @else
                                                Tidak tersedia
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if ($item->status == 3)
                                                Terpenuhi&nbsp;<i class="fa fa-fw fa-check text-success"></i>
                                            @else
                                                Belum Terpenuhi&nbsp;<i
                                                    class="fa fa-fw fa-times-circle text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @if ($item->status == 0)
                                                Menunggu Konfirmasi
                                            @elseif($item->status == 1 || $item->status == 3)
                                                Diterima&nbsp;<i class="fa fa-fw fa-check text-success"></i>
                                            @elseif($item->status == 2)
                                                Ditolak&nbsp;<i class="fa fa-fw fa-times-circle text-danger"></i>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <button class="btn btn-sm btn-info" data-toggle="modal"
                                                data-target="#modalDetail" wire:click="detail('{{ $item->id }}')"><i
                                                    class="fa fa-fw fa-info"></i> Detail</button>
                                            @if ($item->status == 0)
                                                <button @click="open = false" class="btn btn-sm btn-warning"
                                                    data-toggle="modal" data-target="#modalUbah"
                                                    wire:click="edit('{{ $item->id }}')"><i
                                                        class="fa fa-fw fa-edit"></i>Ubah</button>
                                                <button @click="open = false" wire:loading.attr="disabled"
                                                    class="btn btn-sm btn-danger"
                                                    wire:click="triggerConfirm({{ $item->id }})"><i
                                                        class="fa fa-fw fa-trash"></i>
                                                    Hapus</button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
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
                        {{ $data_pendaftaran->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- modal daftar --}}
        <div class="card" x-show="open" x-transition>
            <div class="card-header">
                <div class="form-row">
                    <div class="col">
                        <select wire:model.lazy='filter_hewan'>
                            <option value="">-- Pilih jenis hewan --</option>
                            @foreach ($master_hewan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col">
                        <button @click="open = false" type="button" class="close float-right" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

            </div>
            <div class="card-body">
                <div class="row">
                    @forelse ($data_hewan as $item)
                        <div class="col-md-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    @if ($item->master_hewan->id == 1)
                                        <img src="{{ asset('assets/icon_qurban/cow.png') }}"
                                            style="width: 100px;height: 100px" class="rounded mx-auto d-block"
                                            alt="">
                                    @else
                                        <img src="{{ asset('assets/icon_qurban/goat.png') }}"
                                            style="width: 100px;height: 100px" class="rounded mx-auto d-block"
                                            alt="">
                                    @endif
                                    <br>
                                    <h5 class="text-center">
                                        Tipe
                                    </h5>
                                    <h3 class="text-center">{{ $item->tipe }}</h3>
                                    <h5 class="text-center">
                                        <b>Rp&nbsp;{{ number_format($item->harga, '0', ',', '.') }}</b>
                                    </h5>
                                    <button class="btn bg-teal btn-block"
                                        wire:click="setData('{{ $item->id }}','{{ $item->master_hewan_id }}','{{ auth()->user()->name }}')"
                                        data-toggle="modal" data-target="#modalTambah">
                                        Bayar <i class="fa fa-fw fa-money-bill-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col">
                            <p class="text-center">
                                Tidak ada data
                            </p>
                        </div>
                    @endforelse
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
                    <form wire:submit.prevent='daftar'>
                        <div class="modal-body">
                            <div class="form-group">
                                <select wire:model.defer="metode_pembayaran" required
                                    class="form-control @error('metode_pembayaran') is-invalid @enderror">
                                    <option value="">-- Pilih metode pembayaran --</option>
                                    <option value="Tunai">Tunai</option>
                                    <option value="Transfer">Transfer</option>
                                </select>
                                @error('metode_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" placeholder="Permintaan Daging" min="0" required
                                        wire:model.defer="permintaan"
                                        class="form-control @error('permintaan') is-invalid @enderror">
                                    <div class="  input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Bungkus</span>
                                    </div>
                                    @error('permintaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="  input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Atas Nama</span>
                                    </div>
                                    <input type="text" wire:model.defer="atasNama" required
                                        class="form-control @error('atasNama') is-invalid @enderror">
                                    @error('atasNama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="resetFields()"
                                data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
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
                                    <td><i class="fa fa-fw fa-credit-card"></i> {{ $metode_pembayaran }}</td>
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
                        <h5 class="modal-title" id="staticBackdropLabel">Modal Ubah Data Qurban</h5>
                        <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form wire:submit.prevent='update'>
                        <div class="modal-body">
                            <div class="form-group">
                                <select wire:model.defer="metode_pembayaran" required class="form-control">
                                    <option value="Tunai">Tunai</option>
                                    <option value="Transfer">Transfer</option>
                                </select>
                                @error('metode_pembayaran')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="number" min="0" wire:model.defer="permintaan" required
                                        class="form-control @error('permintaan') is-invalid @enderror">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Bungkus</span>
                                    </div>
                                    @error('permintaan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="  input-group-append">
                                        <span class="input-group-text" id="basic-addon2">Atas Nama</span>
                                    </div>
                                    <input type="text" wire:model.defer="atasNama" required
                                        class="form-control @error('atasNama') is-invalid @enderror">
                                    @error('atasNama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button wire:click="resetFields()" type="button" class="btn btn-secondary"
                                data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- End of File --}}
</div>
