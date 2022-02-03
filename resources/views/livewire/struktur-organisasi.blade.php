<div>
    {{-- The Master doesn't talk, he acts. --}}
    <img src="{{ asset('storage/struktur_organisasi/struktur_organisasi.png') }}" alt="" srcset=""
        class="mb-5">
    <input class="d-block" wire:model.lazy="gambar" type="file">
    <small class="text-muted">Max File Size : 1024KB | Type : PNG</small>
    @error('gambar') <div class="invalid-feedback">{{ $message }}
    </div>@enderror
    <br>
    <button wire:loading.attr="disabled" wire:click="triggerConfirm()" class="mt-2 mb-5 btn btn-sm btn-primary"><i
            class="fa fa-fw fa-upload"></i>&nbsp;Upload</button>
</div>
