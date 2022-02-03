<div wire:init="loadPosts">
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    @php
        $no = 1;
        $no1 = 1;
    @endphp
    <div class="row">
        <div class="col-sm-12 d-block d-sm-none">
            <h5 class="text-uppercase"><i class="fa fa-fw fa-newspaper"></i>&nbsp;Berita Terbaru</h5>
            <hr>
            <div id="carouselExampleControls1" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($data as $item)
                        <div class="carousel-item {{ $no1 == 1 ? 'active' : null }}">
                            <div class="card shadow">
                                <div class="card-body">
                                    <img src="{{ asset('storage/berita/' . $item->thumbnail) }}"
                                        class="img-rounded card-img-top w-100" style="height: 200px">
                                    <div class="card-body">
                                        @if ($data == '[]')
                                            <p class="text-center">Tidak ada berita</p>
                                        @endif
                                        <h5 class="mt-2 text-uppercase">
                                            <a href="{{ url('/home/berita/detail/' . $item->id) }}"
                                                style="color: black">{{ $item->judul }}</a>
                                        </h5>
                                        <small class="text-center">
                                            <i class="fa fa-fw fa-calendar"></i>
                                            {{ $item->created_at->format('d M Y') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $no1++;
                        @endphp
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls1"
                    data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-target="#carouselExampleControls1"
                    data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </button>
            </div>
        </div>
        <div class="col-md-8">
            <div class="d-none d-sm-block">
                <h5 class="text-uppercase"><i class="fa fa-fw fa-newspaper"></i>&nbsp;Berita Terbaru</h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card shadow">
                            <div class="card-body">
                                @if ($data == '[]')
                                    <p>Tidak ada berita</p>
                                @endif
                                @foreach ($data as $item)
                                    @if ($loop->first)
                                        <img src="{{ asset('storage/berita/' . $item->thumbnail) }}"
                                            class="img-rounded w-100" style="max-height: 300px">
                                        <h5 class="mt-2 text-uppercase">
                                            <a href="{{ url('/home/berita/detail/' . $item->id) }}"
                                                style="color: black">{{ $item->judul }}</a>
                                        </h5>
                                        <p>
                                            <i class="fa fa-fw fa-calendar"></i>
                                            {{ $item->created_at->format('d M Y') }}
                                        </p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @foreach ($data as $item)
                            <div class="row">
                                <div class="col-md-5 mt-2">
                                    <img src="{{ asset('storage/berita/' . $item->thumbnail) }}"
                                        alt="{{ $item->thumbnail }}" class="w-100"
                                        style="max-height: 100px">
                                </div>
                                <div class="col-md-7">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <b><a href="{{ url('/home/berita/detail/' . $item->id) }}"
                                                    style="color: black">{{ $item->judul }}</a></b>
                                        </div>
                                        <div class="col-md-12">
                                            <i class="fa fa-fw fa-calendar"></i>
                                            {{ $item->created_at->format('d M Y') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
            <h5 class="text-uppercase mt-4"><i class="fa fa-fw fa-calendar"></i>&nbsp;Jadwal Kajian Rutin</h5>
            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div id="carouselExampleControls" class="carousel slide w-auto" data-ride="carousel">
                        <div class="carousel-inner">
                            @foreach ($data_kajian as $item)
                                @php
                                    $date = date_create($item->tanggal_kegiatan);
                                @endphp
                                <div class="carousel-item {{ $no == 1 ? 'active' : null }}">
                                    <div class="card shadow text-center">
                                        <div class="card-body">
                                            <img src="{{ asset('storage/profile/' . $item->user->picture) }}"
                                                class="img-circle elevation-2 mb-2" style="width: 100px;height: 100px;"
                                                alt="Profile Picture" srcset="">
                                            <h5>{{ $item->user->name }}</h5>
                                            <p class="card-text">{{ $item->nama_kegiatan }}</p>
                                            <small class="text-center"><i class="fa fa-fw fa-calendar"></i>
                                                {{ date_format($date, 'd M Y') }}</small>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $no++;
                                @endphp
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls"
                            data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-target="#carouselExampleControls"
                            data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <h5 class="text-uppercase"><i class="fa fa-fw fa-money-bill"></i>&nbsp;kas Operasional masjid</h5>
            <p>
                <b>Rp. {{ number_format($saldo, '0', ',', '.') }}</b>
            </p>
            <hr>
            <h5 class="text-uppercase"><i class="fab fa-youtube"></i>&nbsp;Youtube Channel</h5>
            <a href="https://www.youtube.com/channel/UCB90AaWC9Z3DDp_i88Hf9RA" target="_blank"
                class="btn bg-teal text-white"><i class="fab fa-youtube"></i>&nbsp;Subscribe</a>
            <hr>
            <div class="card card-outline card-teal shadow">
                <div class="card-header">
                    <h5 class="text-uppercase text-center">Jadwal Sholat Jumat</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="white-space: nowrap">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Imam</th>
                                    <th>Khotib</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data_sholat as $item)
                                    @php
                                        $date = date_create($item->tanggal);
                                    @endphp
                                    <tr>
                                        <td>{{ $item->imam->name }}</td>
                                        <td>{{ $item->khotib->name }}</td>
                                        <td>{{ date_format($date, 'd M') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
