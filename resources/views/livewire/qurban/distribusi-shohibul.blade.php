<div wire:init="loadPosts">
    {{-- Stop trying to control. --}}
    <div class="card">
        <div class="card-header">
            <div class="form-row">
                <div class="col">
                    <select class="form-control" wire:model.lazy='print_master_hewan'>
                        <option value="">-- Pilih jenis hewan --</option>
                        @foreach ($data_master as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <div class="input-group mb-2">
                        <input type="number" class="form-control" min="1990" max="{{ date('Y') }}"
                            wire:model.lazy='print_date'>
                        <div class="input-group-prepend">
                            <a href="{{ route('print.shohibul', [$print_date, $print_master_hewan]) }}" target="_blank"
                                class="btn btn-success">Print <i class="fa fa-fw fa-print"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-2">
                        <input class="form-control" wire:model.lazy="search" type="search" placeholder="Cari nama..."
                            aria-label="Search">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-fw fa-search"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <th>Atas Nama</th>
                        <th>Alamat</th>
                        <th>Hewan Qurban</th>
                        <th class="text-center">Antrian</th>
                        <th class="text-center">Jumlah Permintaan</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @if (empty($data_shohibul))
                            <tr>
                                <td colspan="6" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data_shohibul as $item)
                                <tr>
                                    <td class="align-middle">{{ $item->atasNama }}</td>
                                    <td class="align-middle">{{ $item->user->alamat }}</td>
                                    <td class="align-middle">{{ $item->master_hewan->nama }}</td>
                                    <td class="align-middle text-center">
                                        <small class="text-muted">
                                            {{ $item->qurban->antrian == null ? 'Tidak tersedia' : $item->qurban->antrian }}
                                        </small>
                                    </td>
                                    <td class="align-middle text-center">{{ $item->permintaan_daging }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                                            data-target="#modalUbah" wire:click="setUpdate('{{ $item->id }}')"><i
                                                class="fa fa-fw fa-edit"></i>Ubah</button>
                                        @if ($item->qurban->status == 2)
                                            <button
                                                wire:click="triggerConfirm('{{ $item->id }}','{{ $item->permintaan_daging }}')"
                                                class="btn btn-sm btn-success"><i
                                                    class="fa fa-fw fa-check"></i>&nbsp;Terima</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">
                                        Tidak ada data
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
            @if ($readyToLoad == true)
                <div>{{ $data_shohibul->links() }}</div>
            @endif
        </div>
    </div>
    <!-- Modal Ubah-->
    <div wire:ignore.self class="modal fade" id="modalUbah" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modal Ubah</h5>
                    <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update'>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Permintaan Daging</label>
                            <div class="input-group">
                                <input type="number" min="0" wire:model.defer="permintaan_daging" required
                                    class="form-control @error('permintaan_daging') is-invalid @enderror">
                                <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2">Bungkus</span>
                                </div>
                            </div>
                            @error('permintaan_daging')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Atas Nama</label>
                            <input type="text" wire:model.defer="atasNama" required
                                class="form-control @error('atasNama') is-invalid @enderror">
                            @error('atasNama')
                                <span class="text-danger error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button wire:click="resetFields()" type="button" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End of file --}}
</div>
