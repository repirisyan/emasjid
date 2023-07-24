<div wire:init="loadPosts">
    {{-- Stop trying to control. --}}
    <div class="card">
        <div class="card-header">
            @if (auth()->user()->id_jabatan == 3)
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah"><i
                        class="fa fa-fw fa-plus"></i> Tambah</button>
                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modalTutup"><i
                        class="fa fa-fw fa-book"></i> Tutup Buku</button>
            @endif
            <div class="form-row float-right">
                @if (!$menu_saldo)
                    <div class="col">
                        <div class="form-group">
                            <select wire:model.lazy="bulan" class="form-control">
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                @endif
                <div class="col">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="filter-tahun"><i class="fa fa-fw fa-calendar"></i></span>
                            <input type="number" wire:model.lazy="tahun" min="1900"
                                aria-describedby="filter-tahun"
                                class="form-control @error('tahun') is-invalid @enderror"
                                placeholder="{{ date('Y') }}">
                            @error('tahun')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="col">
                    <a class="btn btn-sm btn-danger" href="{{ route('print.laporan_keuangan', [$bulan, $tahun]) }}"
                        target="_blank"><i class="fa fa-fw fa-print"></i> Print</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ $kategori == 1 ? 'active' : null }}" href="#"
                        wire:click="menu('1')">Pemasukan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $kategori == 2 ? 'active' : null }}" href="#"
                        wire:click="menu('2')">Pengeluaran</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $menu_saldo == true ? 'active' : null }}" href="#"
                        wire:click="menu_saldo()">Saldo</a>
                </li>
            </ul>
            <div class="table-responsive">
                <table class="table table-responsive-sm" style="white-space: nowrap">
                    @if ($menu_saldo)
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Total Pemasukan</th>
                                <th>Total Pengeluaran</th>
                                <th>Saldo</th>
                                <th>Saldo Awal</th>
                                <th>Saldo Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data_saldo as $item)
                                @php
                                    $tanggal = date_create($item->tanggal);
                                @endphp
                                <tr>
                                    <td>{{ date_format($tanggal, 'M Y') }}</td>
                                    <td> Rp. {{ number_format($item->pemasukan, '0', ',', '.') }}</td>
                                    <td> Rp. {{ number_format($item->pengeluaran, '0', ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->pemasukan - $item->pengeluaran, '0', ',', '.') }}
                                    </td>
                                    <td> Rp. {{ number_format($item->saldo_awal, '0', ',', '.') }}</td>
                                    <td> Rp. {{ number_format($item->saldo, '0', ',', '.') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa fa-fw fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                <button wire:loading.attr="disabled" type="button"
                                                    class="dropdown-item"
                                                    wire:click="detail_saldo('{{ $tanggal->format('m') }}','{{ $tanggal->format('Y') }}','1')"><i
                                                        class="fa fa-fw fa-info"></i>&nbsp;Pemasukan</button>
                                                <button wire:loading.attr="disabled" class="dropdown-item"
                                                    wire:click="detail_saldo('{{ $tanggal->format('m') }}','{{ $tanggal->format('Y') }}','2')"><i
                                                        class="fa fa-fw fa-info"></i>&nbsp;Pengeluaran</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Tidak ada data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    @else
                        <thead>
                            <tr>
                                <th>Keterangan</th>
                                <th>Nilai</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                @php
                                    $tanggal = date_create($item->tanggal);
                                @endphp
                                <tr>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>Rp. {{ number_format($item->nilai, '0', ',', '.') }}</td>
                                    <td>{{ date_format($tanggal, 'd M Y') }}</td>
                                    <td>
                                        @if (empty($item->detail_saldo_id))
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                    type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="fa fa-fw fa-ellipsis-h"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                    <button class="dropdown-item" data-toggle="modal"
                                                        data-target="#modalUbah"
                                                        wire:click="edit('{{ $item->id }}','{{ $item->keterangan }}', '{{ $item->nilai }}', '{{ $item->tanggal }}')"><i
                                                            class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                                    <button wire:loading.attr="disabled"
                                                        class="dropdown-item text-danger"
                                                        wire:click="triggerConfirm({{ $item->id }})"><i
                                                            class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
                                        Tidak ada data
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    @endif
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
                    <h5 class="modal-title" id="exampleModalLabel">Modal Tambah Keuangan</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='store'>
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control @error('kategori') is-invalid @enderror"
                                wire:model.defer="kategori" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="1">Pemasukkan</option>
                                <option value="2">Pengeluaran</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-fw fa-calendar"></i></span>
                                <input type="date" wire:model.defer="tanggal" aria-describedby="basic-addon1"
                                    required class="form-control @error('tanggal') is-invalid @enderror"
                                    placeholder="tanggal">
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="keterangan">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input min="0" type="number" wire:model.defer="nilai" required
                                    aria-describedby="basic-addon1"
                                    class="form-control @error('nilai') is-invalid @enderror" placeholder="100000">
                                @error('nilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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

    <!-- Modal Tutup Buku-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalTutup"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Tutup Buku</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='tutup_buku'>
                    <div class="modal-body">
                        <div class="form-group">
                            <select wire:model.defer="bulan" class="form-control">
                                <option>Pilih Bulan</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-fw fa-calendar"></i></span>
                                <input type="text" wire:model.defer="tahun" aria-describedby="basic-addon1"
                                    required class="form-control @error('tahun') is-invalid @enderror"
                                    placeholder="{{ date('Y') }}">
                                @error('tahun')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="konfirmasi" required
                                class="form-control @error('konfirmasi') is-invalid @enderror""
                                placeholder=" KONFIRMASI">
                            <small id="emailHelp" class="form-text text-muted">Ketik : KONFIRMASI</small>
                            @error('konfirmasi')
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
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalUbah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Ubah Keuangan</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update'>
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control @error('kategori') is-invalid @enderror"
                                wire:model.defer="kategori" required>
                                <option value="1">Pemasukkan</option>
                                <option value="2">Pengeluaran</option>
                            </select>
                            @error('kategori')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-fw fa-calendar"></i></span>
                                <input type="date" wire:model.defer="tanggal" aria-describedby="basic-addon1"
                                    required class="form-control @error('tanggal') is-invalid @enderror"
                                    placeholder="tanggal">
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="keterangan">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input min="0" type="number" wire:model.defer="nilai" required
                                    aria-describedby="basic-addon1"
                                    class="form-control @error('nilai') is-invalid @enderror" placeholder="100000">
                                @error('nilai')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
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
</div>
