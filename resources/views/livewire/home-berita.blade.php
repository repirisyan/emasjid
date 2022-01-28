<div wire:init="loadPosts">
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="row">
        @foreach ($data as $item)
            <div class="col-md-4 mt-5 d-flex align-items-stretch">
                <div class="card shadow rounded">
                    <img src="{{ asset('storage/berita/' . $item->thumbnail) }}" class="card-img-top" alt="..."
                        height="200px">
                    <div class="card-body">
                        <a href="{{ url('/home/berita/detail/' . $item->id) }}" style="color: black">
                            <h5 class="text-uppercase">{{ $item->judul }}</h5>
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
    @if ($readyToLoad == true)
        <div class="d-flex justify-content-center">
            {{ $data->render('pagination::bootstrap-4') }}
        </div>
    @endif
</div>
