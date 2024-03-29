<div>
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="row">
        <div class="col-md-8">
            <h5 class="mt-4"><i class="fa fa-fw fa-calendar"></i>&nbsp;EVENT <small>(<a aria-label="link daftar event"
                        href="https://wa.me/{{ env('APP_WHATSAPP') }}?text=Nama%20Event%20:%0ANama%20Lengkap%20:%0ATanggal%20Lahir%20:%0ATempat%20Lahir%20:%0AJenis%20Kelamin%20:%0ANo%20HP%20:%0AAlamat%20:">Daftar</a>)</small>
            </h5>
            <div class="owl-carousel owl-theme">
                @forelse ($events as $item)
                    @php
                        $tanggal = date_create($item->tanggal_event);
                    @endphp
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <div class="item">
                                @if ($item->thumbnail != null)
                                    <img data-src="{{ asset('storage/event/' . $item->thumbnail) }}" class="owl-lazy">
                                @endif
                                <h5 class="mt-2">
                                    {{ date_format($tanggal, 'd M Y') }}
                                </h5>
                                <p class="card-text mt-2">
                                    {{ $item->nama_event }}
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>Tidak ada data</p>
                @endforelse
            </div>
            <hr>
            <h5 class="text-uppercase mt-4"><i class="fa fa-fw fa-calendar"></i>&nbsp;Jadwal Kajian Rutin</h5>
            <hr>
            @if ($data_kajian->count() == '0')
                <p>Tidak ada data</p>
            @else
                <div id="carouselExampleControls" class="carousel slide w-auto" data-ride="carousel">
                    <div class="carousel-inner">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($data_kajian as $item)
                            @php
                                $date = date_create($item->tanggal_kegiatan);
                            @endphp
                            <div class="carousel-item {{ $no == 1 ? 'active' : null }}">
                                <div class="card shadow text-center">
                                    <div class="card-body">
                                        <img src="{{ asset('storage/profile/' . $item->user->picture) }}"
                                            class="img-circle elevation-2 mb-2"
                                            style="max-width: 100px;max-height: 100px;"
                                            alt="Profile {{ $item->user->name }}">
                                        <h5>{{ $item->user->JenisKelamin == 'Laki-laki' ? 'Ustaz' : 'Ustazah' }}&nbsp;{{ $item->user->name }}
                                        </h5>
                                        <p class="card-text">{{ $item->nama_kegiatan }}</p>
                                        <h5 class="text-center"><b><i class="fa fa-fw fa-calendar"></i>
                                                {{ date_format($date, 'd M Y') }}</b></h5>
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
                        <span class="carousel-control-prev-icon bg-black" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselExampleControls"
                        data-slide="next">
                        <span class="carousel-control-next-icon bg-black" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
            @endif
            <hr>
            <h5 class="text-uppercase mt-4"><i class="fa fa-fw fa-image"></i>&nbsp;Galeri</h5>
            @if ($galeris->count() == '0')
                <p>Tidak ada data</p>
            @else
                <div class="owl-carousel owl-theme">
                    @foreach ($galeris as $item)
                        <div class="item" style="width: 300px">
                            <img data-src="{{ asset('storage/galeri/' . $item->picture) }}" class="owl-lazy"
                                alt="{{ $item->keterangan }}">
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($galeris->hasMorePages())
                <div class="text-center mt-3">
                    <a href="{{ route('landing.galeri') }}" aria-label="Lihat semua galeri"
                        class="btn btn-outline-primary btn-sm" target="_blank">Lainnya</a>
                </div>
            @endif
            <hr>
            <h5 class="text-uppercase"><i class="fa fa-fw fa-newspaper"></i>&nbsp;Berita Terbaru</h5>
            @if ($beritas->count() == '0')
                <p>Tidak ada data</p>
            @else
                <div class="owl-carousel owl-theme">
                    @foreach ($beritas as $item)
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="item">
                                    <img data-src="{{ asset('storage/berita/' . $item->thumbnail) }}"
                                        alt="Thumbnail {{ $item->judul }}" class="owl-lazy" loading='lazy'>
                                    <p class="float-left">
                                        <i class="fa fa-fw fa-calendar"></i>
                                        {{ $item->created_at->format('d M Y') }}
                                    </p>
                                    <p class="float-right">
                                        <i class="fa fa-fw fa-user"></i>
                                        {{ $item->user->name }}
                                    </p>
                                    <p class="mt-5">
                                        <a aria-label="Detail Berita {{ $item->judul }}"
                                            href="{{ route('landing.detail', $item->id) }}">{{ $item->judul }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($beritas->hasMorePages())
                <div class="text-center">
                    <a href="{{ route('landing.berita') }}" aria-label="Lihat Semua Berita"
                        class="btn btn-outline-primary btn-sm" target="_blank">Lainnya</a>
                </div>
            @endif
            <hr>
            <h5 class="text-uppercase"><i class="fa fa-fw fa-newspaper"></i>&nbsp;Kajian</h5>
            @if ($kajians->count() == '0')
                <p>Tidak ada data</p>
            @else
                <div class="owl-carousel owl-theme">
                    @foreach ($kajians as $item)
                        <div class="card shadow">
                            <div class="card-body">
                                <div class="item">
                                    <img data-src="{{ asset('storage/kajian_online/' . $item->thumbnail) }}"
                                        alt="Thumbnail {{ $item->judul }}" class="owl-lazy" loading='lazy'>
                                    <p class="float-left">
                                        <i class="fa fa-fw fa-calendar"></i>
                                        {{ $item->created_at->format('d M Y') }}
                                    </p>
                                    <p class="float-right">
                                        <i class="fa fa-fw fa-user"></i>
                                        {{ $item->user->name }}
                                    </p>
                                    <p class="mt-5">
                                        <a aria-label="Lihat Detail Kajian {{ $item->judul }}"
                                            href="{{ route('landing.detail', $item->id) }}">{{ $item->judul }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @if ($kajians->hasMorePages())
                <div class="text-center">
                    <a href="{{ route('landing.kajian_online') }}" aria-label="Lihat Semua Kajian"
                        class="btn btn-outline-primary btn-sm" target="_blank">Lainnya</a>
                </div>
            @endif
        </div>
        <div class="col-md-4 mt-5 mt-md-0">
            <h5 class="text-uppercase"><i class="fa fa-fw fa-money-bill"></i>&nbsp;kas Operasional masjid</h5>
            <p style="font-size: 22px">
                <b>Rp. {{ number_format($saldo, '0', ',', '.') }}</b>
            </p>
            <a href="{{ route('landing.keuangan') }}" class="btn btn-sm btn-outline-primary" target="_blank">Lihat
                Laporan <i class="fa fa-fw fa-file"></i></a>
            <hr>
            <h5 class="text-uppercase"><i class="fa fa-fw fa-calendar"></i>&nbsp;Jadwal Sholat Jumat</h5>
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
                        @forelse ($data_sholat as $item)
                            @php
                                $date = date_create($item->tanggal);
                            @endphp
                            <tr>
                                <td>{{ $item->imam->name }}</td>
                                <td>{{ $item->khotib->name }}</td>
                                <td>{{ date_format($date, 'd M') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">
                                    Tidak ada data
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <hr>
            <h5 class="text-uppercase"><i class="fab fa-youtube"></i>&nbsp;Video</h5>
            <iframe loading="lazy" src="https://www.youtube.com/embed/{{ env('APP_YOUTUBE_VID') }}" frameborder="0"
                allow="autoplay; encrypted-media" allowfullscreen title="Youtube Channel"></iframe>
            <a href="{{ env('APP_YT_CHANNEL') }}" aria-label="Link Channel Youtube" target="_blank"
                class="btn btn-sm btn-outline-primary"><i class="fab fa-youtube"></i>&nbsp;Subscribe</a>
            <hr>
            <h5 class="text-uppercase"><i class="fa fa-fw fa-map-marked"></i>&nbsp;Lokasi</h5>
            <div class="mapouter">
                <div class="gmap_canvas"><iframe id="gmap_canvas" loading="lazy" title="Google Maps"
                        src="https://maps.google.com/maps?q={{ env('APP_GMAPS_COOR') }}&t=&z=13&ie=UTF8&iwloc=&output=embed"
                        frameborder="0" scrolling="no" marginheight="0" allowfullscreen
                        marginwidth="0"></iframe><br>
                </div>
            </div>
            <hr>
            <h5 class="text-uppercase"><i class="fa fa-fw fa-user"></i> Hubungi Kami</h5>
            <table class="table-borderless">
                <tr>
                    <td><i class="fa fa-fw fa-envelope"></i> E-mail</td>
                    <td>:</td>
                    <td><a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}"
                            aria-label="Kirim Email ke {{ env('MAIL_FROM_ADDRESS') }}">{{ env('MAIL_FROM_ADDRESS') }}</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <hr>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><a href="https://wa.me/{{ env('APP_WHATSAPP') }}"
                            aria-label="Kirim pesan whatsapp" target="_blank"><img alt="Chat on WhatsApp"
                                src="{{ asset('assets/ChatOnWhatsAppButton/WhatsAppButtonGreenLarge.svg') }}" /></a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
