<div wire:init="loadPosts" class="mt-5">
    {{-- Be like water. --}}
    @isset($data->sejarah)
        {!! $data->sejarah !!}
    @endisset
</div>
