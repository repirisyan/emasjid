<div wire:init="loadPosts">
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="row">
        @if (empty($data))
            <div class="col-12">
                <p class="text-center">
                    <i class="fa fa-spinner fa-spin"></i>
                </p>
            </div>
        @else
            @forelse ($data as $item)
                <div class="col-md-4 mt-5 d-flex align-items-stretch">
                    <div class="card shadow rounded">
                        <img src="{{ asset('storage/kajian_online/' . $item->thumbnail) }}" class="card-img-top"
                            alt="Thumbnail {{ $item->judul }}" max-width="200px" loading='lazy'>
                        <div class="card-body">
                            <a href="{{ route('landing.detail', $item->id) }}">
                                <p class="text-uppercase">{{ $item->judul }}</p>
                            </a>
                            <div class="card-text d-flex justify-content-between text-muted mt-4">
                                <small>
                                    <i class="fa fa-fw fa-calendar"></i>{{ $item->created_at->format('Y-m-d') }}
                                </small>
                                <small>
                                    <i class="fa fa-fw fa-user"></i>{{ $item->user->name }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center mt-5">
                    <img src="{{ asset('assets/img/image_file_not_found.svg') }}" alt="Image Not Found" loading='lazy'
                        style="max-width: 300px">
                    <p class="text-center mt-2">
                        Tidak ada data
                    </p>
                </div>
            @endforelse
        @endif
    </div>
    @if ($readyToLoad == true && $data->hasMorePages())
        @php
            $limit = $paginateLimit + 3;
        @endphp
        <div class="d-flex justify-content-center">
            <a href="#" wire:click.prevent="$set('paginateLimit','{{ $limit }}')">Tampilkan lebih
                banyak</a>
        </div>
    @endif
</div>
