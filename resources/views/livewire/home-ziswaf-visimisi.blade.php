<div wire:init="loadPosts" class="mt-5">
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    @isset($data->visi_misi)
        {!! $data->visi_misi !!}
    @endisset
</div>
