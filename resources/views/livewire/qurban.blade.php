<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="card">
        <div class="card-header">
            <div class="dropdown float-right">
                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-fw fa-hippo"></i> {{ $id_master_hewan == 1 ? 'Sapi' : 'Kambing' }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    @foreach ($master_hewan as $item)
                        <a class="dropdown-item" href="#"
                            wire:click="$set('id_master_hewan','{{ $item->id }}')">{{ $item->nama }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-center" style="white-space: nowrap" wire:init="loadPosts">
                    <thead>
                        <th>Tipe Hewan</th>
                        <th>Antrian Sembelih</th>
                        <th>Berat Timbangan</th>
                        <th>Jumlah Shohibul</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($data_qurban as $item)
                            <tr>
                                <td class="align-middle">{{ $item->hewan->tipe }}</td>
                                <td class="align-middle">
                                    @if ($item->antrian == null)
                                        <small class="text-muted">Tidak tersedia</small>
                                    @else
                                        {{ $item->antrian }}
                                    @endif

                                </td>
                                <td class="align-middle">{{ $item->berat_timbangan }} Kg</td>
                                <td class="align-middle">{{ $item->jumlah_shobul }}</td>
                                <td class="align-middle">
                                    @if ($item->status == 2)
                                        <i class="fa fa-fw fa-lg fa-check text-teal"></i>
                                    @elseif($item->status == 0)
                                        <span class="text-info">
                                            <i class="fa fa-fw fa-info"></i>&nbsp;Menunggu Shohibul
                                        </span>
                                    @elseif($item->status == 1)
                                        <span class="text-teal">
                                            Disembelih&nbsp;<i class="fa fa-fw fa-check"></i>
                                        </span>
                                    @else
                                        <i class="fa fa-fw fa-spinner fa-spin"></i>
                                    @endif
                                </td>
                                <td class="align-middle">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-fw fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <button class="dropdown-item"
                                                wire:click="detailShobul('{{ $item->id }}')" data-toggle="modal"
                                                data-target="#modalDetail"><i class="fa fa-fw fa-info"></i>
                                                Shohibul</button>
                                            @if ($item->status == 4)
                                                @if ($item->antrian != null)
                                                    <button wire:click="triggerConfirm('{{ $item->id }}')"
                                                        class="dropdown-item text-success">
                                                        <i class="fa fa-fw fa-check"></i> Sembelih
                                                    </button>
                                                @else
                                                    <button data-toggle="modal" data-target="#modalAntrian"
                                                        wire:click="$set('id_qurban','{{ $item->id }}')"
                                                        class="dropdown-item text-primary">
                                                        <i class="fa fa-fw fa-ticket-alt"></i> Buat Antrian
                                                    </button>
                                                @endif
                                            @elseif($item->status == 1)
                                                <button data-toggle="modal" data-target="#modalTambah"
                                                    wire:click="$set('id_qurban','{{ $item->id }}')"
                                                    class="dropdown-item text-primary">
                                                    <i class="fa fa-fw fa-balance-scale"></i> Berat Timbangan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Timbangan-->
    <div wire:ignore.self class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal Konfirmasi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="number" wire:model.defer="berat_timbangan"
                                class="form-control @error('berat_timabangan') is-invalid @enderror"
                                placeholder="Berat Timbangan">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">Kg</span>
                            </div>
                            @error('berat_timbangan') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="resetFields()"
                        data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="store()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Antrian-->
    <div wire:ignore.self class="modal fade" id="modalAntrian" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal Buat Antrian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <input type="text" wire:model.defer="antrian"
                                class="form-control @error('antrian') is-invalid @enderror" placeholder="Antrian Ke">
                            <div class="input-group-append">
                                <span class="input-group-text" id="basic-addon2">Th</span>
                            </div>
                            @error('antrian') <div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="resetFields()"
                        data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="buatAntrian()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail-->
    <div wire:ignore.self class="modal fade" id="modalDetail" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Detail Shohibul Qurban</h5>
                    <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- {{ str_replace(['"','[',']'],'',$detail_shobul) }} --}}
                    <table class="table table-borderless">
                        @if ($detail_shobul != null)
                            @foreach ($detail_shobul as $item)
                                <tr>
                                    <td> <i class="fa fa-fw fa-user"></i> {{ $item->atasNama }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </table>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="resetFields()"
                        data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End OF File --}}
</div>
