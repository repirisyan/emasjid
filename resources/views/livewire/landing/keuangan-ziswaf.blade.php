<div wire:init="loadPosts" class="mt-5">
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="card">
        <div class="card-header">
            <a href="{{ route('keuangan_ziswaf.export', [$dari, $sampai]) }}"
                class="btn btn-sm float-right btn-success"><i class="fa fa-fw fa-file-excel"></i> Export</a>
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
                        @forelse ($data as $item)
                            @php
                                $tanggal = date_create($item->tanggal);
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
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

</div>
