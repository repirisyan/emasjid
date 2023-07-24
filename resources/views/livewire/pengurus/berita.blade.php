<div wire:init='loadPosts' x-data="{ tambah: @entangle('tambah'), ubah: @entangle('ubah') }">
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" @click="tambah = ! tambah, ubah = false"
                wire:click='resetFields()'>Tambah <i class="fa fa-fw fa-plus"></i></button>
            <div class="form-row float-right">
                <div class="col">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-fw fa-filter"></i></div>
                        </div>
                        <select class="form-control" wire:model.lazy='filter_status'>
                            <option value="">-- Pilih Status --</option>
                            <option value="1">Published</option>
                            <option value="0">Draft</option>
                        </select>
                    </div>
                </div>
                <div class="col">
                    <input class="form-control" wire:model.lazy="search" type="search" placeholder="Cari Judul..."
                        aria-label="Search">
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <th>Judul</th>
                        <th>Tanngal</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody wire:init="loadPosts" style="white-space: nowrap">
                        @if (empty($beritas))
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($beritas as $item)
                                <tr>
                                    <td class="align-middle">{{ $item->judul }}</td>
                                    <td class="align-middle">{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="align-middle">
                                        @if ($item->status == 0)
                                            <span class="badge badge-pill badge-primary">Draft <i
                                                    class="fa fa-fw fa-bookmark"></i></span>
                                        @else
                                            <span class="badge badge-pill badge-success">Published <i
                                                    class="fa fa-fw fa-share"></i></span>
                                        @endif
                                    </td>
                                    <td>
                                        <button wire:click="edit('{{ $item->id }}')"
                                            @click="ubah = true; tambah = false" class="btn btn-sm btn-warning"><i
                                                class="fa fa-fw fa-edit"></i>
                                            Ubah</button>
                                        <button class="btn btn-sm btn-danger" wire:loading.attr="disabled"
                                            wire:click="triggerConfirm('{{ $item->id }}','{{ $item->thumbnail }}')"><i
                                                class="fa fa-fw fa-trash"></i> Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
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
                    {{ $beritas->links() }}
                </div>
            @endif
        </div>
    </div>
    <div wire:ignore.self class="card mt-5" x-show="$wire.tambah" x-transition>
        <div class="card-body">
            <button @click="tambah = false" type="button" wire:click='resetFields()'
                class="mb-4 float-right btn-sm close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            <form wire:submit.prevent='store' enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <input type="text" required class="form-control @error('judul') is-invalid @enderror"
                                placeholder="Judul" wire:model.defer='judul'>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <label for="staticEmail" class="col-12">Thumbnail</label>
                                <div class="col-12">
                                    <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                                        x-on:livewire-upload-finish="isUploading = false"
                                        x-on:livewire-upload-error="isUploading = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <!-- File Input -->
                                        <input type="file" wire:model="thumbnail"
                                            class="@error('thumbnail') is-invalid @enderror">
                                        <!-- Progress Bar -->
                                        <div x-show="isUploading">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    <small>Format : png, jpg, jepg</small>
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <select required class="@error('visible') is-invalid @enderror" wire:model.defer='visible'
                                style="width: 200px">
                                <option value="">-- Pilih Status --</option>
                                <option value="1">Publish</option>
                                <option value="0">Hidden</option>
                            </select>
                            @error('visible')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="tambah-keterangan">Keterangan</label>
                            @if ($thumbnail != null)
                                <div x-data x-ref="quillEditor" x-init="quill = new Quill($refs.quillEditor, { theme: 'snow' });" style="height: 400px">
                                    {!! $deskripsi !!}
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
                <button type="submit" wire:loading.attr='disabled' wire:target='thumbnail'
                    wire:click='$set("deskripsi",quill.root.innerHTML)'
                    class="btn btn-sm btn-primary float-right">Simpan</button>
            </form>
        </div>
    </div>

    <div wire:ignore.self class="card mt-5" x-show="$wire.ubah" x-transition>
        <div class="card-body">
            <button @click="ubah = false" type="button" wire:click='resetFields()'
                class="mb-4 float-right btn-sm close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
            @if ($thumbnail != null)
                <img src="{{ asset('storage/berita/' . $thumbnail) }}" class="img-fluid mb-3" alt=""
                    srcset="" style="max-width: 200px;max-height:200px">
            @endif
            <form wire:submit.prevent='update' enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <input type="text" required class="form-control @error('judul') is-invalid @enderror"
                                placeholder="Judul" wire:model.defer='judul'>
                            @error('judul')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <label for="staticEmail" class="col-12 col-form-label">Thumbnail (Optional)</label>
                                <div class="col-sm-12">
                                    <div x-data="{ isUploadingUpdate: false, progress: 0 }" x-on:livewire-upload-start="isUploadingUpdate = true"
                                        x-on:livewire-upload-finish="isUploadingUpdate = false"
                                        x-on:livewire-upload-error="isUploadingUpdate = false"
                                        x-on:livewire-upload-progress="progress = $event.detail.progress">
                                        <!-- File Input -->
                                        <input type="file" wire:model="new_thumbnail"
                                            class="@error('new_thumbnail') is-invalid @enderror">
                                        <!-- Progress Bar -->
                                        <div x-show="isUploadingUpdate">
                                            <progress max="100" x-bind:value="progress"></progress>
                                        </div>
                                    </div>
                                    <small>Format : png, jpg, jepg</small>
                                    @error('new_thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <select required class="form-select @error('visible') is-invalid @enderror"
                                wire:model.defer='visible'>
                                <option value="">-- Pilih Status --</option>
                                <option value="1">Publish</option>
                                <option value="0">Hidden</option>
                            </select>
                            @error('visible')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="Keterangan">Keterangan</label>
                            <div x-data x-ref="quillEditorEdit" x-init="quillEdit = new Quill($refs.quillEditorEdit, { theme: 'snow' });" style="height: 400px">
                                {!! $deskripsi !!}
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" wire:loading.attr='disabled' wire:target='new_thumbnail'
                    wire:click='$set("deskripsi",quillEdit.root.innerHTML)'
                    class="btn btn-sm btn-primary float-right">Simpan</button>
            </form>
        </div>
    </div>
</div>
