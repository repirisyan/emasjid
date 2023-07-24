<div wire:init='loadPosts'>
    <div class="card shadow mt-5">
        <div class="card-header">
            <div class="card-title">
                <h5>Laporan Keuangan</h5>
            </div>
            <div class="form-row float-right">
                @if (!$menu_saldo)
                    <div class="col">
                        <div class="form-group">
                            <select wire:model.lazy="bulan" class="form-control" aria-label="Filter Bulan">
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
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-fw fa-calendar"></i></span>
                            <input type="number" wire:model.lazy="tahun" min="1900" aria-label="Filter Tahun"
                                aria-describedby="basic-addon1"
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
                        target="_blank" aria-label="Print Laporan Keuangan"><i class="fa fa-fw fa-print"></i> Print</a>
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
                <div class="mt-2 d-flex justify-content-center">
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
