<div wire:poll.300000ms wire:init="loadPosts">
    {{-- Care about people's approval and you will be their prisoner. --}}
    {{-- @auth
        @if (auth()->user()->role == 1)
            <a href="#" wire:click="$refresh()" class="float-right mb-2">Refresh <i class="fa fa-fw fa-redo"></i></a>
        @endif
    @endauth --}}
    <div class="row">
        @foreach ($data_monitoring as $item)
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-paw"></i>&nbsp;Penyembelihan {{ $item->nama }} {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>{{ $item->jumlah_hewan }} / {{ $item->jumlah_sembelih }}</b>
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
                        <h3 class="text-center"><b>{{ $item->timbangan }}</b></h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        @foreach ($data_shobul as $item2)
            <div class="col-md-3">
                <div class="card shadow text-center">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-users"></i>&nbsp;Shohibul Qurban {{ $item2->nama }} {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>{{ $item2->jumlah_shobul }}</b></h3>
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
                                {{ $item2->progress_permintaan }}</b></h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row">
        @foreach ($data_produksi as $item3)
            <div class="col-md-4 text-center">
                <div class="card shadow">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-box"></i>&nbsp;Pembungkusan Daging
                        {{ $item3->master_hewan->nama }} {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>{{ $item3->jumlah }} / {{ $item3->jumlahProduksi }}
                            </b></h3>
                    </div>
                </div>
            </div>
        @endforeach
        @foreach ($data_distribusi as $item4)
            <div class="col-md-4 text-center">
                <div class="card shadow">
                    <div class="card-header bg-teal">
                        <i class="fa fa-fw fa-truck"></i>&nbsp;Distribusi Daging Qurban {{ date('Y') }}
                    </div>
                    <div class="card-body bg-light">
                        <h3 class="text-center"><b>{{ $item4->jumlah }} / {{ $item4->progressDistribusi }}</b>
                        </h3>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    {{-- End of File --}}
</div>
