<div wire:init="loadPosts">
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="card mt-5">
        <div class="card-header">
            Kontak Pesan
        </div>
        <div class="card-body">
            <div class="form-group">
                <input type="text" wire:model.defer="nama" class="form-control @error('nama') is-invalid @enderror"
                    required placeholder="Nama">
                @error('nama') <div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <input type="email" wire:model.defer="email" class="form-control @error('email') is-invalid @enderror"
                    required placeholder="E-mail">
                @error('email') <div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <input type="text" wire:model.defer="subject"
                    class="form-control @error('subject') is-invalid @enderror" required placeholder="Subject">
                @error('subject') <div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="form-group">
                <textarea wire:model.defer="pesan" rows="10" class="form-control @error('pesan') is-invalid @enderror"
                    required placeholder="Pesan....."></textarea>
                @error('pesan') <div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="card-footer">
            <button class="btn btn-primary float-right" wire:click="send_message()">Kirim</button>
        </div>
    </div>
</div>
