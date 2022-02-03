<div wire:init="loadPosts">
    <div class="row mt-5">
        @foreach ($data as $item)
            <div class="col-md-6">
                <div class="card shadow mb-3">
                    <div class="row no-gutters">
                        <div class="col-md-3">
                            <div class="container d-flex h-100">
                                <div class="row justify-content-center align-self-center mx-auto d-block">
                                    <img class="img-circle elevation-2" style="width: 100px;height: 100px"
                                        src="{{ asset('storage/profile/' . $item->user->picture) }}" alt="...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->nama_kegiatan }}</h5>
                                <p class="card-text">
                                    @php
                                        $date = date_create($item->tanggal_kegiatan);
                                    @endphp
                                    <i class="fa fa-fw fa-user"></i>&nbsp;{{ $item->user->name }} <br>
                                    <i class="fa fa-fw fa-calendar"></i>&nbsp;{{ date_format($date, 'd M Y') }} <br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}
    @if ($readyToLoad == true && $data->hasMorePages())
        @php
            $limit = $paginateLimit + 6;
        @endphp
        <div class="d-flex justify-content-center">
            <a href="#" wire:click.prevent="$set('paginateLimit','{{ $limit }}')">Tampilkan lebih banyak</a>
        </div>
    @endif
</div>
