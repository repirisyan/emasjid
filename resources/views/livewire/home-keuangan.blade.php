<div wire:init="loadPosts">
    {{-- Stop trying to control. --}}
    <div class="card mt-5">
        <div class="card-header">
            <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#modalPreview"><i
                    class="fa fa-fw fa-print"></i> Preview</button>
            <button type="button" class="float-right btn btn-sm btn-secondary" data-toggle="modal"
                data-target="#modalFilter">
                <i class="fa fa-fw fa-calendar"></i>&nbsp;{{ $bulan }} {{ $tahun }}&nbsp;<i
                    class="fa fa-fw fa-sort-down"></i>
            </button>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" style="white-space: nowrap">
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
                    @if ($menu_saldo == false)
                        <thead>
                            <tr>
                                <th>Keterangan</th>
                                <th>Nilai</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                @php
                                    $tanggal = new DateTime($item->tanggal);
                                @endphp
                                <tr>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>Rp. {{ number_format($item->nilai, '0', ',', '.') }}</td>
                                    <td>{{ $tanggal->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                    @if ($menu_saldo == true)
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
                            @foreach ($data_saldo as $item)
                                @php
                                    $tanggal = new DateTime($item->tanggal);
                                @endphp
                                <tr>
                                    <td>{{ $tanggal->format('M Y') }}</td>
                                    <td> Rp. {{ number_format($item->pemasukan, '0', ',', '.') }}</td>
                                    <td> Rp. {{ number_format($item->pengeluaran, '0', ',', '.') }}</td>
                                    <td>Rp. {{ number_format($item->pemasukan - $item->pengeluaran, '0', ',', '.') }}
                                    </td>
                                    <td> Rp. {{ number_format($item->saldo_awal, '0', ',', '.') }}</td>
                                    <td> Rp. {{ number_format($item->saldo, '0', ',', '.') }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                                id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
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
                            @endforeach
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

    <!-- Modal Filter-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalFilter"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Filter</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if ($menu_saldo == false)
                        <div class="form-group">
                            <select wire:model.defer="bulan" class="form-control">
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
                    @endif
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-fw fa-calendar"></i></span>
                            <input type="text" wire:model.defer="tahun" aria-describedby="basic-addon1"
                                class="form-control @error('tahun') is-invalid @enderror"
                                placeholder="{{ date('Y') }}">
                            @error('tahun') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" data-dismiss="modal" wire:click="filter()"
                        class="btn btn-primary">Filter</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalPreview"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Preview Laporan Keuangan</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select wire:model.defer="bulan_preview" class="form-control">
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
                            <span class="input-group-text" id="basic-addon1"><i class="fa fa-fw fa-calendar"></i></span>
                            <input type="text" wire:model.defer="tahun_preview" aria-describedby="basic-addon1"
                                class="form-control @error('tahun_preview') is-invalid @enderror"
                                placeholder="{{ date('Y') }}">
                            @error('tahun_preview') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                    <a wire:click="preview()" class="btn btn-primary" href="#" target="_blank">Preview</a>
                </div>
            </div>
        </div>
    </div>

</div>
