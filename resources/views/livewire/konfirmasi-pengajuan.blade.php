<div wire:init="loadPosts">
    {{-- Stop trying to control. --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-responsive-sm" style="white-space: nowrap">
                    <thead>
                        <tr>
                            <th>Pengaju</th>
                            <th>Keterangan</th>
                            <th>Nilai</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->keterangan }}</td>
                                <td>Rp. {{ number_format($item->nilai, '0', ',', '.') }}</td>
                                <td>{{ $item->tanggal }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-fw fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            <button wire:loading.attr="disabled" class="dropdown-item text-success"
                                                wire:click="triggerConfirm({{ $item->id }})">Konfirmasi&nbsp;<i
                                                    class="fa fa-fw fa-check"></i></button>
                                            <button wire:loading.attr="disabled" class="dropdown-item text-danger"
                                                wire:click="triggerDeny({{ $item->id }})">Tolak&nbsp;<i
                                                    class="fa fa-fw fa-times"></i></button>
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
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
