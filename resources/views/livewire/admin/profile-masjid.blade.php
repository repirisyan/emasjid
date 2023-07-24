<div>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="card" x-data="{ visi_misi: false }">
        <div class="card-header">
            <h5 class="card-title">Visi & Misi</h5><a href="#" @click="visi_misi = ! visi_misi" class="float-right"><i
                    class="fa fa-fw fa-eye"></i></a>
        </div>
        <div class="card-body" x-show="visi_misi" x-transition>
            <form wire:submit.prevent='update_visi'>
                <div class="mb-3">
                    <div x-data x-ref="quillEditor" x-init="quill = new Quill($refs.quillEditor, { theme: 'snow' });" style="height: 400px">
                        {!! $data->visi_misi !!}
                    </div>
                </div>
                <button type="submit" wire:click='$set("visi_misi",quill.root.innerHTML)'
                    class="btn btn-sm btn-primary float-right">Simpan</button>
            </form>
        </div>
    </div>

    <div class="card" x-data="{ sejarah: false }">
        <div class="card-header">
            <h5 class="card-title">Sejarah</h5><a href="#" @click="sejarah = ! sejarah" class="float-right"><i
                    class="fa fa-fw fa-eye"></i></a>
        </div>
        <div class="card-body" x-show="sejarah" x-transition>
            <form wire:submit.prevent='update_sejarah'>
                <div class="mb-3">
                    <div x-data x-ref="quillEditorSejarah" x-init="quillSejarah = new Quill($refs.quillEditorSejarah, { theme: 'snow' });" style="height: 400px">
                        {!! $data->sejarah !!}
                    </div>
                </div>
                <button type="submit" wire:click='$set("sejarah",quillSejarah.root.innerHTML)'
                    class="btn btn-sm btn-primary float-right">Simpan</button>
            </form>
        </div>
    </div>

    <div class="card" x-data="{ logo: false }">
        <div class="card-header">
            <h5 class="card-title">Logo & Favicon</h5><a href="#" @click="logo = ! logo" class="float-right"><i
                    class="fa fa-fw fa-eye"></i></a>
        </div>
        <div class="card-body" x-show="logo" x-transition>
            <form wire:submit.prevent='update_logo' enctype="multipart/form-data">
                <div class="row text-center">
                    <div class="col">
                        <img src="{{ asset('storage/logo/mosque.webp') }}" alt="Logo Masjid"
                            style="max-width: 100px;max-height:100px" loading='lazy'>
                        <div class="my-3">
                            <div x-data="{ isUploading: false, progress: 0 }" x-on:livewire-upload-start="isUploading = true"
                                x-on:livewire-upload-finish="isUploading = false"
                                x-on:livewire-upload-error="isUploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <!-- File Input -->
                                <input type="file" wire:model="logo" class="@error('logo') is-invalid @enderror">
                                <!-- Progress Bar -->
                                <div x-show="isUploading">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>
                            </div>
                            <small>Format : png,webp</small>
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col">
                        <img src="{{ asset('storage/favicons/favicon.ico') }}" alt="Favicon Masjid" loading='lazy'>
                        <div class="my-3">
                            <div x-data="{ isUploadingFavicon: false, progress: 0 }" x-on:livewire-upload-start="isUploadingFavicon = true"
                                x-on:livewire-upload-finish="isUploadingFavicon = false"
                                x-on:livewire-upload-error="isUploadingFavicon = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                <!-- File Input -->
                                <input type="file" wire:model="favicon"
                                    class="@error('favicon') is-invalid @enderror">
                                <!-- Progress Bar -->
                                <div x-show="isUploadingFavicon">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>
                            </div>
                            <small>Format : ico</small>
                            @error('favicon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" wire:loading.attr='disabled' wire:target='logo'
                    class="btn btn-sm btn-primary float-right">Simpan</button>
            </form>
        </div>
    </div>

    <div class="card" x-data="{ struktur: false }">
        <div class="card-header">
            <h5 class="card-title">Struktur Organisasi</h5><a href="#" @click="struktur = ! struktur"
                class="float-right"><i class="fa fa-fw fa-eye"></i></a>
        </div>
        <div class="card-body" x-show="struktur" x-transition>
            <form wire:submit.prevent='update_organisasi' enctype="multipart/form-data">
                <div class="text-center">
                    <img src="{{ asset('storage/struktur_organisasi/struktur_organisasi.webp') }}"
                        alt="Struktur Organisasi" loading='lazy'>
                    <div class="my-3">
                        <div x-data="{ isUploadingOrganisasi: false, progress: 0 }" x-on:livewire-upload-start="isUploadingOrganisasi = true"
                            x-on:livewire-upload-finish="isUploadingOrganisasi = false"
                            x-on:livewire-upload-error="isUploadingOrganisasi = false"
                            x-on:livewire-upload-progress="progress = $event.detail.progress">
                            <!-- File Input -->
                            <input type="file" wire:model="organisasi_thumbnail"
                                class="@error('organisasi_thumbnail') is-invalid @enderror">
                            <!-- Progress Bar -->
                            <div x-show="isUploadingOrganisasi">
                                <progress max="100" x-bind:value="progress"></progress>
                            </div>
                        </div>
                        <small>Format : png,webp</small>
                        @error('organisasi_thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <button type="submit" wire:loading.attr='disabled' wire:target='organisasi_thumbnail'
                    class="btn btn-sm btn-primary float-right">Simpan</button>
            </form>
        </div>
    </div>
</div>
