<div wire:init="loadPosts">
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{-- Data Hewan --}}
    <div class="row">
        @forelse ($data_monitoring as $item)
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-paw"></i>&nbsp;Penyembelihan {{ $item->nama }} {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>{{ $item->jumlah_hewan }} / {{ $item->jumlah_sembelih }}
                                <small>Ekor</small></b>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-balance-scale-right"></i>&nbsp;Berat Timbangan {{ $item->nama }}
                        {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>{{ $item->timbangan }} <small>Kg</small></b></h3>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-paw"></i>&nbsp;Penyembelihan Sapi {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 / 0
                                <small>Ekor</small></b>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-balance-scale-right"></i>&nbsp;Berat Timbangan Sapi
                        {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 <small>Kg</small></b></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-paw"></i>&nbsp;Penyembelihan Kambing {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 / 0
                                <small>Ekor</small></b>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-balance-scale-right"></i>&nbsp;Berat Timbangan Kambing
                        {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 <small>Kg</small></b></h3>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    {{-- Data Shohibuk --}}
    <div class="row">
        @forelse ($data_shobul as $item2)
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-users"></i>&nbsp;Shohibul Qurban {{ $item2->nama }} {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>{{ $item2->jumlah_shobul }} <small>Orang</small></b></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-drumstick-bite"></i>&nbsp;Permintaan Daging {{ $item2->nama }}
                        {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>{{ $item2->jumlah_permintaan }} /
                                {{ $item2->progress_permintaan }} <small>Bungkus</small></b></h3>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-users"></i>&nbsp;Shohibul Qurban Sapi {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 <small>Orang</small></b></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-drumstick-bite"></i>&nbsp;Permintaan Daging Sapi
                        {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 /
                                0<small>Bungkus</small></b></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-users"></i>&nbsp;Shohibul Qurban Kambing {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 <small>Orang</small></b></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-drumstick-bite"></i>&nbsp;Permintaan Daging Kambing
                        {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 /
                                0 <small>Bungkus</small></b></h3>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    {{-- Data Produksi & Distribusi --}}
    <div class="row">
        @forelse ($data_produksi as $item3)
            <div class="col-md-4 text-center">
                <div class="card shadow">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-box"></i>&nbsp;Pembungkusan Daging
                        {{ $item3->master_hewan->nama }} {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>{{ $item3->jumlah }} / {{ $item3->jumlahProduksi }}
                                <small>Bungkus</small>
                            </b></h3>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-4 text-center">
                <div class="card shadow">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-box"></i>&nbsp;Pembungkusan Daging
                        Sapi {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 / 0
                                <small>Bungkus</small>
                            </b></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <div class="card shadow">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-box"></i>&nbsp;Pembungkusan Daging
                        Kambing {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 / 0
                                <small>Bungkus</small>
                            </b></h3>
                    </div>
                </div>
            </div>
        @endforelse
        @forelse ($data_distribusi as $item4)
            <div class="col-md-4 text-center">
                <div class="card shadow">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-truck"></i>&nbsp;Distribusi Daging Qurban {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>{{ $item4->jumlah }} / {{ $item4->progressDistribusi }}
                                <small>Bungkus</small></b>
                        </h3>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-md-4 text-center">
                <div class="card shadow">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-truck"></i>&nbsp;Distribusi Daging Qurban {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>0 / 0
                                <small>Bungkus</small></b>
                        </h3>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
    {{-- End of File --}}
</div>
