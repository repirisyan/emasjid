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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($data))
                            <tr>
                                <td colspan="5" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $item->user->name }}</td>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>Rp. {{ number_format($item->nilai, '0', ',', '.') }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>
                                        <button wire:loading.attr="disabled" class="btn btn-sm btn-success"
                                            wire:click="triggerConfirm({{ $item->id }})">Konfirmasi&nbsp;<i
                                                class="fa fa-fw fa-check"></i></button>
                                        <button wire:loading.attr="disabled" class="btn btn-sm btn-danger"
                                            wire:click="triggerDeny({{ $item->id }})">Tolak&nbsp;<i
                                                class="fa fa-fw fa-times"></i></button>
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
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
