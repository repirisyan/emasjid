<div x-data="{ open: false }">
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" @click="open = ! open">Tambah <i class="fa fa-fw fa-plus"></i></button>
            <div class="form-inline float-right">
                <input class="form-control" wire:model.lazy="search" type="search" placeholder="Cari Judul..."
                    aria-label="Search">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>Judul</th>
                        <th>Tanngal</th>
                        <th class="text-center">Status</th>
                        <th class="text-center"></th>
                    </thead>
                    <tbody wire:init="loadPosts" style="white-space: nowrap">
                        @foreach ($data_berita as $item)
                            <tr>
                                <td class="align-middle">{{ $item->judul }}</td>
                                <td class="align-middle">{{ $item->created_at->format('d M Y') }}</td>
                                <td class="text-center align-middle">
                                    @if ($item->status == 0)
                                        <span class="badge badge-pill bg-teal">Draft <i
                                                class="fa fa-fw fa-bookmark"></i></span>
                                    @else
                                        <span class="badge badge-pill badge-primary">Published <i
                                                class="fa fa-fw fa-share"></i></span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-fw fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            @if ($item->status == 0)
                                                <button wire:loading.attr="disabled"
                                                    wire:click="triggerStatus('{{ $item->id }}','1')"
                                                    class="dropdown-item text-primary"><i class="fa fa-fw fa-share"></i>
                                                    Publish</button>
                                            @else
                                                <button wire:loading.attr="disabled"
                                                    wire:click="triggerStatus('{{ $item->id }}','0')"
                                                    class="dropdown-item text-teal"><i class="fa fa-fw fa-bookmark"></i>
                                                    Draft</button>
                                            @endif
                                            <a href="{{ route('berita_edit', $item->id) }}" class="dropdown-item"><i
                                                    class="fa fa-fw fa-edit"></i>
                                                Ubah</a>
                                            <button class="dropdown-item text-danger" wire:loading.attr="disabled"
                                                wire:click="triggerConfirm('{{ $item->id }}','{{ $item->thumbnail }}')"><i
                                                    class="fa fa-fw fa-trash"></i> Hapus</button>
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
                    {{ $data_berita->links() }}
                </div>
            @endif
        </div>
    </div>
    <div class="card" x-show="open" x-transition>
        <div class="card-header">
            Form Berita
            <button type="button" class="close float-right" @click="open = false" data-dismiss="modal"
                aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
            <div class="form-group">
                <input wire:model.defer="judul" placeholder="Judul" type="text"
                    class="w-50 form-control @error('judul') is-invalid @enderror">
                @error('judul') <div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group" wire:ignore>
                <div class="col-md-12">
                    <div id="deskripsi" class="form-textarea @error('deskripsi') is-invalid @enderror w-full" x-cloak
                        x-data x-init="
                            ClassicEditor.create($refs.myIdentifierHere)
                            .then( function(editor){
                                editor.model.document.on('change:data', () => {
                                   $dispatch('input', editor.getData())
                                });
                            })
                            .catch( error => {
                                console.error( error );
                            } );
                        " wire:ignore wire:key="myIdentifierHere" x-ref="myIdentifierHere"
                        wire:model.defer="deskripsi">
                        {!! $deskripsi !!}</div>
                </div>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <input type="file" wire:model.defer="thumbnail" id="customFile"
                    class="@error('thumbnail') is-invalid @enderror"><br>
                @error('thumbnail') <div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-sm btn-primary float-right" wire:click="save('1')"><i
                    class="fa fa-fw fa-share"></i>&nbsp;Publish</button>
            <button class="btn btn-sm bg-teal float-right mr-2" wire:click="save('0')"><i
                    class="fa fa-fw fa-bookmark"></i>&nbsp;Draft</button>
        </div>
    </div>
</div>
