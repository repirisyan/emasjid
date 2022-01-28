<div wire:init="loadPosts">
    {{-- Stop trying to control. --}}
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary"
                href="{{ route('print.shobul', ['date' => $date, 'hewan' => $id_master_hewan]) }}"
                target="__blank">Preview <i class="fa fa-fw fa-print"></i></a>
            <a class="btn btn-sm btn-success"
                href="{{ route('download.shobul', ['date' => $date, 'hewan' => $id_master_hewan]) }}">PDF <i
                    class="fa fa-fw fa-download"></i></a>
            <div class="dropdown float-right">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-fw fa-calendar"></i> {{ $date }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @for ($i = 2021; $i <= date('Y'); $i++)
                        <a class="dropdown-item" href="#"
                            wire:click="filterSearch('{{ $id_master_hewan }}','{{ $i }}')">{{ $i }}</a>
                    @endfor
                </div>
            </div>
            <div class="dropdown float-right mr-2">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-fw fa-hippo"></i> {{ $id_master_hewan == 1 ? 'Sapi' : 'Kambing' }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach ($master_hewan as $item)
                        <a class="dropdown-item" href="#"
                            wire:click="filterSearch('{{ $item->id }}','{{ $date }}')">{{ $item->nama }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive mt-2">
                <table class="table" style="white-space: nowrap">
                    <thead class="text-center">
                        <th>{{ $id_master_hewan == 1 ? 'Sapi' : 'Kambing' }} Ke</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Kontak</th>
                        <th>Permintaan Daging Qurban</th>
                        <th>Tanggal Pendaftaran</th>
                    </thead>
                    <tbody class="text-center">
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->qurban->antrian }}</td>
                                <td>{{ $item->atasNama }}</td>
                                <td>{{ $item->user->alamat }}</td>
                                <td>{{ $item->user->kontak }}</td>
                                <td>{{ $item->permintaan_daging }} Bungkus</td>
                                <td>{{ date_format($item->created_at, 'd M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($readyToLoad == true)
                <div class="float-right">
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
