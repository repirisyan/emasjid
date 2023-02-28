<div wire:init="loadPosts">
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="card">
        <div class="card-header">
            {{-- @if (auth()->user()->id_jabatan == 3) --}}
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah"><i
                    class="fa fa-fw fa-plus"></i> Tambah</button>
            {{-- @endif --}}
            <a href="{{ route('keuangan_ziswaf.export', [$dari, $sampai]) }}"
                class="btn btn-sm float-right btn-secondary"><i class="fa fa-fw fa-file-excel"></i> Export</a>
            <div class="form-inline float-right mr-2">
                <input class="form-control mr-2" wire:model.lazy="dari" type="date" aria-label="Search">
                <input class="form-control" wire:model.lazy="sampai" type="date" aria-label="Search">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="white-space: nowrap">
                    <thead class="text-center">
                        <tr>
                            <th rowspan="2" class="align-middle">Tanggal</th>
                            <th rowspan="2" class="align-middle">Item</th>
                            <th colspan="3">Mutasi Keuangan Zakat</th>
                            <th colspan="5">Mutasi Keuangan Infaq/Shodaqoh</th>
                            <th rowspan="2" class="align-middle">PIUTANG</th>
                            <th rowspan="2" class="align-middle">Aksi</th>
                        </tr>
                        <tr>
                            <th>Debit</th>
                            <th>Kredit</th>
                            <th>Saldo</th>
                            <th>Debit Infaq</th>
                            <th>Debit Pinjaman</th>
                            <th>Kredit Infaq</th>
                            <th>Kredit Pinjaman</th>
                            <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($data))
                            <tr>
                                <td colspan="12" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data as $item)
                                @php
                                    $tanggal = new DateTime($item->tanggal);
                                @endphp
                                <tr>
                                    <td>{{ $tanggal->format('d M Y') }}</td>
                                    <td>{{ $item->item }}</td>
                                    <td>Rp. {{ number_format($item->debit, '0', ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->kredit, '0', ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->saldo, '0', ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->debit_infaq, '0', ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->debit_pinjaman, '0', ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->kredit_infaq, '0', ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->kredit_pinjaman, '0', ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->saldo_infaq, '0', ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->piutang, '0', ',', '.') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa fa-fw fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                <button class="dropdown-item" data-toggle="modal"
                                                    data-target="#modalUbah"
                                                    wire:click="edit('{{ $item->id }}')"><i
                                                        class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                                <button wire:loading.attr="disabled" class="dropdown-item text-danger"
                                                    wire:click="triggerConfirm({{ $item->id }})"><i
                                                        class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">
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
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalTambah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Tambah Keuangan Ziswaf</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-fw fa-calendar"></i></span>
                            <input type="date" wire:model.defer="tanggal" aria-describedby="basic-addon1" required
                                class="form-control @error('tanggal') is-invalid @enderror" placeholder="tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="item" required
                            class="form-control @error('item') is-invalid @enderror" placeholder="Item">
                        @error('item')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr>
                    Mutasi Keuangan Zakat
                    <hr>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Debit</span>
                            <input min="0" type="number" wire:model.defer="debit"
                                aria-describedby="basic-addon1"
                                class="form-control @error('debit') is-invalid @enderror">
                            @error('debit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Kredit</span>
                            <input min="0" type="number" wire:model.defer="kredit"
                                aria-describedby="basic-addon1"
                                class="form-control @error('kredit') is-invalid @enderror">
                            @error('kredit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Saldo</span>
                            <input min="0" type="number" wire:model.defer="saldo"
                                aria-describedby="basic-addon1"
                                class="form-control @error('saldo') is-invalid @enderror">
                            @error('saldo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    Mutasi Keuangan Infaq/Shodaqoh
                    <hr>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Debit Infaq</span>
                            <input min="0" type="number" wire:model.defer="debit_infaq"
                                aria-describedby="basic-addon1"
                                class="form-control @error('debit_infaq') is-invalid @enderror">
                            @error('debit_infaq')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Debit Pinjaman</span>
                            <input min="0" type="number" wire:model.defer="debit_pinjaman"
                                aria-describedby="basic-addon1"
                                class="form-control @error('debit_pinjaman') is-invalid @enderror">
                            @error('debit_pinjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Kredit Infaq</span>
                            <input min="0" type="number" wire:model.defer="kredit_infaq"
                                aria-describedby="basic-addon1"
                                class="form-control @error('kredit_infaq') is-invalid @enderror">
                            @error('kredit_infaq')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Kredit Pinjaman</span>
                            <input min="0" type="number" wire:model.defer="kredit_pinjaman"
                                aria-describedby="basic-addon1"
                                class="form-control @error('kredit_pinjaman') is-invalid @enderror">
                            @error('kredit_pinjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Saldo</span>
                            <input min="0" type="number" wire:model.defer="saldo_infaq_shodaqoh"
                                aria-describedby="basic-addon1"
                                class="form-control @error('saldo_infaq_shodaqoh') is-invalid @enderror">
                            @error('saldo_infaq_shodaqoh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Piutang</span>
                            <input min="0" type="number" wire:model.defer="piutang"
                                aria-describedby="basic-addon1"
                                class="form-control @error('piutang') is-invalid @enderror">
                            @error('piutang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalUbah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Ubah Keuangan Ziswaf</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i
                                    class="fa fa-fw fa-calendar"></i></span>
                            <input type="date" wire:model.defer="tanggal" required aria-describedby="basic-addon1"
                                class="form-control @error('tanggal') is-invalid @enderror" placeholder="tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" wire:model.defer="item" required
                            class="form-control @error('item') is-invalid @enderror" placeholder="Item">
                        @error('item')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <hr>
                    Mutasi Keuangan Zakat
                    <hr>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Debit</span>
                            <input min="0" type="number" wire:model.defer="debit"
                                aria-describedby="basic-addon1"
                                class="form-control @error('debit') is-invalid @enderror">
                            @error('debit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Kredit</span>
                            <input min="0" type="number" wire:model.defer="kredit"
                                aria-describedby="basic-addon1"
                                class="form-control @error('kredit') is-invalid @enderror">
                            @error('kredit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Saldo</span>
                            <input min="0" type="number" wire:model.defer="saldo"
                                aria-describedby="basic-addon1"
                                class="form-control @error('saldo') is-invalid @enderror">
                            @error('saldo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    Mutasi Keuangan Infaq/Shodaqoh
                    <hr>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Debit Infaq</span>
                            <input min="0" type="number" wire:model.defer="debit_infaq"
                                aria-describedby="basic-addon1"
                                class="form-control @error('debit_infaq') is-invalid @enderror">
                            @error('debit_infaq')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Debit Pinjaman</span>
                            <input min="0" type="number" wire:model.defer="debit_pinjaman"
                                aria-describedby="basic-addon1"
                                class="form-control @error('debit_pinjaman') is-invalid @enderror">
                            @error('debit_pinjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Kredit Infaq</span>
                            <input min="0" type="number" wire:model.defer="kredit_infaq"
                                aria-describedby="basic-addon1"
                                class="form-control @error('kredit_infaq') is-invalid @enderror">
                            @error('kredit_infaq')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Kredit Pinjaman</span>
                            <input min="0" type="number" wire:model.defer="kredit_pinjaman"
                                aria-describedby="basic-addon1"
                                class="form-control @error('kredit_pinjaman') is-invalid @enderror">
                            @error('kredit_pinjaman')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Saldo</span>
                            <input min="0" type="number" wire:model.defer="saldo_infaq_shodaqoh"
                                aria-describedby="basic-addon1"
                                class="form-control @error('saldo_infaq_shodaqoh') is-invalid @enderror">
                            @error('saldo_infaq_shodaqoh')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">Piutang</span>
                            <input min="0" type="number" wire:model.defer="piutang"
                                aria-describedby="basic-addon1"
                                class="form-control @error('piutang') is-invalid @enderror">
                            @error('piutang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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
</div>
