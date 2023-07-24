<div wire:init="loadPosts">
    {{-- In work, do what you enjoy. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah"><i
                    class="fa fa-fw fa-plus"></i> Tambah</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Foto</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($data))
                            <tr>
                                <td colspan="3" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data as $item)
                                <tr>
                                    <td class="align-middle">{{ $item->keterangan }}</td>
                                    <td>
                                        <a href="{{ asset('storage/galeri/' . $item->picture) }}">
                                            <img src="{{ asset('storage/galeri/' . $item->picture) }}"
                                                alt="{{ $item->keterangan }}" style="max-height: 50px;max-weight:50px"
                                                loading='lazy'>
                                        </a>
                                    </td>
                                    <td class="align-middle">
                                        <button wire:loading.attr="disabled" type="button" data-toggle="modal"
                                            data-target="#modalUbah" class="btn btn-sm btn-warning"
                                            wire:click="edit('{{ $item->id }}')"><i
                                                class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                        <button wire:loading.attr="disabled" class="btn btn-sm btn-danger"
                                            wire:click="triggerConfirm('{{ $item->id }}','{{ $item->picture }}')"><i
                                                class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">
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

    <!-- Modal Tambah-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalTambah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Tambah Foto Galeri</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='store'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model.defer="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror" required
                                placeholder="Keterangan Foto">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Thumbnail</label>
                                <div class="col-sm-10">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" wire:target='thumbnail'
                            wire:loading.attr='disabled'>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ubah-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalUbah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Ubah Foto Galeri</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model.defer="keterangan"
                                class="form-control @error('keterangan') is-invalid @enderror" required
                                placeholder="Keterangan Foto">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Thumbnail (Optional)</label>
                                <div class="col-sm-10">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary" wire:targer='new_thumbnail'
                            wire:loading.attr='disabled'>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- End of line --}}
</div>
