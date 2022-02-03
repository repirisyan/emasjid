<div wire:init="loadPosts" class="mt-5">
    {{-- Be like water. --}}
    @isset($data->visi_misi)
        {!! $data->visi_misi !!}
    @endisset
</div>
