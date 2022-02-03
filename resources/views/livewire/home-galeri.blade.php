<div wire:init="loadPosts">
    {{-- In work, do what you enjoy. --}}
    <div class="row mt-5">
        @foreach ($data as $item)
            <div class="col-md-4 mt-2">
                <img src="{{ asset('storage/galeri/' . $item->picture) }}" title="{{ $item->keterangan }}"
                    class="img-responsive rounded mx-auto d-block" alt="" style="width: 200px; height: 200px;">
            </div>
        @endforeach
    </div>
    @if ($readyToLoad == true)
        <div class="d-flex justify-content-center">
            {{ $data->links() }}
        </div>
    @endif
</div>
