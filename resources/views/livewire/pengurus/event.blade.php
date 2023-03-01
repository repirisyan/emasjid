<div wire:init="loadPosts" x-data="{ open: false }">
    {{-- In work, do what you enjoy. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" @click="open = false" data-toggle="modal" data-target="#modalTambah"><i
                    class="fa fa-fw fa-plus"></i>&nbsp;Tambah</button>
            <div class="form-row float-right">
                <div class="col">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-fw fa-filter"></i></div>
                        </div>
                        <select class="form-control" wire:model.lazy='filter_status'>
                            <option value="">-- Pilih status --</option>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak aktif</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-sm" style="white-space: nowrap">
                <thead>
                    <th>Nama Event</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Thumbnail</th>
                    <th></th>
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
                                <td class="align-middle">{{ $item->nama_event }}</td>
                                <td class="align-middle">{{ $item->tanggal_event }}</td>
                                <td class="align-middle">
                                    <small>{{ $item->status ? 'Aktif' : 'Tidak aktif' }}&nbsp;<i
                                            class="fa fa-fw fa-{{ $item->status ? 'check' : 'times' }} text-{{ $item->status ? 'success' : 'danger' }}"></i></small>
                                </td>
                                <td class="align-middle">
                                    @if ($item->thumbnail != null)
                                        <img src="{{ asset('storage/event/' . $item->thumbnail) }}"
                                            style="width: 100px;height: 100px;">
                                    @else
                                        <small>Tidak ada thumbnail</small>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <button wire:loading.attr="disabled" type="button" @click="open = true"
                                        class="btn btn-sm btn-info"
                                        wire:click="contributor('{{ $item->id }}','{{ $item->nama_event }}')"><i
                                            class="fa fa-fw fa-eye"></i>&nbsp;Peserta</button>
                                    <button wire:loading.attr="disabled" type="button" data-toggle="modal"
                                        data-target="#modalUbah" class="btn btn-sm btn-warning"
                                        wire:click="edit('{{ $item->id }}')"><i
                                            class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                    <button wire:loading.attr="disabled" class="btn btn-sm btn-danger"
                                        wire:click="triggerConfirm('{{ $item->id }}')"><i
                                            class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
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
            @if ($readyToLoad == true)
                <div>
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>

    <div class="card" x-show="open" x-transition>
        <div class="card-header">
            <span class="font-weight-bold"><button class="btn btn-sm btn-primary" data-toggle="modal"
                    data-target="#modalDaftar"><i
                        class="fa fa-fw fa-plus"></i>&nbsp;Daftar</button>&nbsp{{ $nama_event }}</span>
            <button @click="open = false" type="button" class="close" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <tr>
                            <th>Nama Lengkap</th>
                            <th>Tanggal Lahir</th>
                            <th>Tempat Lahir</th>
                            <th>Jenis Kelamin</th>
                            <th>No Handphone</th>
                            <th>Alamat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($contributor as $item)
                            <tr>
                                <td>{{ $item->nama_lengkap }}</td>
                                <td>{{ $item->tanggal_lahir }}</td>
                                <td>{{ $item->tempat_lahir }}</td>
                                <td><i
                                        class="fa fa-fw fa-{{ $item->jenis_kelamin == 'Laki-laki' ? 'mars' : 'venus' }}"></i>{{ $item->jenis_kelamin }}
                                </td>
                                <td>
                                    {{ $item->no_hp }}
                                </td>
                                <td>{{ $item->alamat }}</td>
                                <td>
                                    <button wire:loading.attr="disabled" type="button" data-toggle="modal"
                                        data-target="#modalDaftarUpdate" class="btn btn-sm btn-warning"
                                        wire:click="edit_peserta('{{ $item->id }}')"><i
                                            class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                    <button wire:loading.attr="disabled" class="btn btn-sm btn-danger"
                                        wire:click="triggerDeletePeserta('{{ $item->id }}')"><i
                                            class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah-->
    <div wire:ignore.self class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Event</h5>
                    <button type="button" class="close" wire:click="resetFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='store' enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model.defer="nama"
                                class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Event">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="date" wire:model.defer="tanggal"
                                class="form-control @error('tannggal') is-invalid @enderror" placeholder="Tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label>Foto</label>
                                <div>
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
                                    <small>(Optional) Format : png, jpg, jepg</small>
                                    @error('thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control @error('status') is-invalid @enderror" required
                                wire:model.defer="status">
                                <option value="">-- Pilih status --</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" wire:loading.attr='disabled' wire:target='thumbnail'
                            class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Lihat-->
    <div wire:ignore.self class="modal fade" id="modalPeserta" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Data Peserta Event</h5>
                    <button type="button" class="close" wire:click="resetFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (isset($contributor))
                        <table>
                            @foreach ($contributor as $item)
                            @endforeach
                        </table>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Daftar --}}
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalDaftar"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Daftar Peserta</h5>
                    <button type="button" wire:click="resetDaftar()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='daftar'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model.defer="nama_lengkap" required
                                class="form-control @error('nama_lengkap') is-invalid @enderror" required
                                placeholder="Nama Lengkap">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="date" wire:model.defer="tanggal_lahir" required
                                class="form-control @error('tanggal_lahir') is-invalid @enderror" required
                                placeholder="Tanggal Lahir">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="tempat_lahir" required
                                class="form-control @error('tempat_lahir') is-invalid @enderror" required
                                placeholder="Tempat Lahir">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select wire:model.defer="jenis_kelamin" required
                                class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                <option>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" maxlength="12" wire:model.defer="no_hp" required
                                class="form-control @error('no_hp') is-invalid @enderror" required
                                placeholder="No HP">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="alamat" required
                                class="form-control @error('alamat') is-invalid @enderror" required
                                placeholder="Alamat">
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetDaftar()" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Daftar Update --}}
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false"
        id="modalDaftarUpdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Ubah Peserta</h5>
                    <button type="button" wire:click="resetDaftar()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update_peserta'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model.defer="nama_lengkap" required
                                class="form-control @error('nama_lengkap') is-invalid @enderror" required
                                placeholder="Nama Lengkap">
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="date" wire:model.defer="tanggal_lahir" required
                                class="form-control @error('tanggal_lahir') is-invalid @enderror" required
                                placeholder="Tanggal Lahir">
                            @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="tempat_lahir" required
                                class="form-control @error('tempat_lahir') is-invalid @enderror" required
                                placeholder="Tempat Lahir">
                            @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select wire:model.defer="jenis_kelamin" required
                                class="form-control @error('jenis_kelamin') is-invalid @enderror">
                                <option>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" maxlength="12" wire:model.defer="no_hp" required
                                class="form-control @error('no_hp') is-invalid @enderror" required
                                placeholder="No HP">
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="alamat" required
                                class="form-control @error('alamat') is-invalid @enderror" required
                                placeholder="Alamat">
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetDaftar()" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ubah-->
    <div wire:ignore.self class="modal fade" id="modalUbah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Event</h5>
                    <button type="button" class="close" wire:click="resetFields()" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update' enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model.defer="nama"
                                class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Event">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="date" wire:model.defer="tanggal"
                                class="form-control @error('tannggal') is-invalid @enderror" placeholder="Tanggal">
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                                <label>Foto</label>
                                <div>
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
                                    <small>(Optional)Format : png, jpg, jepg</small>
                                    @error('new_thumbnail')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <select class="form-control @error('status') is-invalid @enderror" required
                                wire:model.defer="status">
                                <option value="">-- Pilih status --</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" wire:loading.attr='disabled' wire:target='new_thumbnail'
                            class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End of line --}}
</div>
