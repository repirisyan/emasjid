<div wire:init='loadPosts'>
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="card">
        <div class="card-header">
            <div class="form-row float-right">
                <div class="col">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-fw fa-filter"></i></div>
                        </div>
                        <select class="form-control" wire:model.lazy='filter_hewan'>
                            <option value="">-- Pilih jenis hewan --</option>
                            @foreach ($master_hewan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table text-center" style="white-space: nowrap" wire:init="loadPosts">
                    <thead>
                        <th>Jenis</th>
                        <th>Tipe Hewan</th>
                        <th>Antrian Sembelih</th>
                        <th>Berat Timbangan</th>
                        <th>Jumlah Shohibul</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @if (empty($data_qurban))
                            <tr>
                                <td colspan="7" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data_qurban as $item)
                                <tr>
                                    <td class="align-middle">{{ $item->master_hewan->nama }}</td>
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
                                            Selesai <i class="fa fa-fw fa-lg fa-check text-success"></i>
                                        @elseif($item->status == 0)
                                            Menunggu Shohibul <i class="fa fa-spinner fa-spin"></i>
                                        @elseif($item->status == 1)
                                            Disembelih&nbsp;<i class="fa fa-fw fa-check text-success"></i>
                                        @else
                                            Menunggu Antrian
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                type="button" id="dropdownMenuButton1" data-toggle="dropdown"
                                                aria-expanded="false">
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
                                                            wire:click="set_data_antrian({{ $item->id }},{{ $item->master_hewan->id }})"
                                                            class="dropdown-item text-primary">
                                                            <i class="fa fa-fw fa-ticket-alt"></i> Buat Antrian
                                                        </button>
                                                    @endif
                                                @elseif($item->status == 1)
                                                    <button data-toggle="modal" data-target="#modalTambah"
                                                        wire:click="$set('qurban_id','{{ $item->id }}')"
                                                        class="dropdown-item text-primary">
                                                        <i class="fa fa-fw fa-balance-scale"></i> Berat Timbangan
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        Tidak ada data
                                    </td>
                                </tr>
                            @endforelse
                        @endif
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
                    <h5 class="modal-title" id="staticBackdropLabel">Modal Berat Timbangan Daging Qurban</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='store'>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="number" wire:model.defer="berat_timbangan" required min="0"
                                    class="form-control @error('berat_timabangan') is-invalid @enderror"
                                    placeholder="Berat Timbangan">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Kg</span>
                                </div>
                                @error('berat_timbangan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="resetFields()"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
                <form wire:submit.prevent='set_antrian()'>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" wire:model.defer="antrian"
                                    class="form-control @error('antrian') is-invalid @enderror"
                                    placeholder="Antrian Ke">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Th</span>
                                </div>
                                @error('antrian')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="resetFields()"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
