<div wire:init="loadPosts">
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="row">
        @foreach ($data as $item)
            <div class="col-md-4 mt-5 d-flex align-items-stretch">
                <div class="card shadow rounded">
                    <img src="{{ asset('storage/kajian_online/' . $item->thumbnail) }}" class="card-img-top" alt="..."
                        height="200px">
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
        @endforeach
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
