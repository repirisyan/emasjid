<div wire:init="loadPosts">
    {{-- Stop trying to control. --}}
    <div class="card">
        <div class="card-header">
            <a class="btn btn-sm btn-primary" href="{{ route('print.distribusi', $date) }}" target="__blank">Preview <i
                    class="fa fa-fw fa-print"></i></a>
            <a class="btn btn-sm btn-success" href="{{ route('download.distribusi', $date) }}">PDF <i
                    class="fa fa-fw fa-download"></i></a>
            <div class="dropdown float-right">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1"
                    data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-fw fa-calendar"></i> {{ $date }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    @for ($i = 2021; $i <= date('Y'); $i++)
                        <a class="dropdown-item" href="#"
                            wire:click="filterSearch('{{ $i }}')">{{ $i }}</a>
                    @endfor
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <th>Nama</th>
                        <th class="text-center">Pengajuan</th>
                        <th class="text-center">Realisasi</th>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td class="align-middle text-center">{{ $item->jumlah }}</td>
                                <td class="align-middle text-center">{{ $item->progressDistribusi }}</td>
                                <td></td>
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
