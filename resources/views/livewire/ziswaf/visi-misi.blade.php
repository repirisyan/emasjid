<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="card-body">
        <form wire:submit.prevent='update'>
            <div class="mb-3">
                <div x-data x-ref="quillEditor" x-init="quill = new Quill($refs.quillEditor, { theme: 'snow' });" style="height: 400px">
                    {!! $data->visi_misi !!}
                </div>
            </div>
            <button type="submit" wire:loading.attr='disabled' wire:click='$set("deskripsi",quill.root.innerHTML)'
                class="btn btn-sm btn-primary float-right">Simpan</button>
        </form>
    </div>
</div>
