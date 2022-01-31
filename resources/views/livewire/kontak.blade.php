<div wire:init="loadPosts">
    {{-- Care about people's approval and you will be their prisoner. --}}<div class="card">
        <div class="card-header">
            <div class="dropdown float-right">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-fw fa-{{ $status == 1 ? 'envelope' : 'envelope-open' }}"></i>
                    {{ $status == 1 ? 'Belum Dibuka' : 'Sudah Dibuka' }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" wire:click="$set('status','1')">Belum Dibuka</a>
                    <a class="dropdown-item" href="#" wire:click="$set('status','2')">Sudah Dibuka</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->subject }}</td>
                                <td>{{ date_format($item->created_at, 'd-m-y') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-fw fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            <button wire:loading.attr="disabled" type="button" data-toggle="modal"
                                                data-target="#modalLihat" class="dropdown-item" @if ($item->status == 1)
                                                wire:click="open_mail('{{ $item->id }}','{{ $item->pesan }}')"
                                            @else
                                                wire:click="see_mail('{{ $item->pesan }}')"
                                                @endif><i class="fa fa-fw fa-envelope"></i>&nbsp;Buka</button>
                                            <button wire:loading.attr="disabled" class="dropdown-item text-danger"
                                                wire:click="triggerConfirm('{{ $item->id }}')"><i
                                                    class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
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

    <!-- Modal Lihat Pesan-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalLihat"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{ $pesan }}</p>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
