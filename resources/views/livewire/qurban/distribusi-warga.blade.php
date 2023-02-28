<div wire:init='loadPosts'>
    {{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah <i
                    class="fa fa-fw fa-plus"></i></button>
            <div class="form-row float-right">
                <div class="col">
                    <div class="input-group mb-2">
                        <input type="number" class="form-control" min="1990" max="{{ date('Y') }}"
                            wire:model.lazy='print_date'>
                        <div class="input-group-prepend">
                            <a href="{{ route('print.distribusi', $print_date) }}" target="_blank"
                                class="btn btn-success">Print <i class="fa fa-fw fa-print"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-fw fa-filter"></i></div>
                        </div>
                        <select class="form-control" wire:model.lazy='filter_status'>
                            <option value="">-- Pilih Status --</option>
                            <option value="1">Terpenuhi</option>
                            <option value="0">Belum terpenuhi</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <th>Nama</th>
                        <th class="text-center">Jumlah</th>
                        <th>Status</th>
                        <th></th>
                    </thead>
                    <tbody>
                        @if (empty($data_distribusi))
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data_distribusi as $item)
                                <tr>
                                    <td class="align-middle">{{ $item->nama }}</td>
                                    <td class="align-middle text-center">
                                        {{ $item->jumlah }}/{{ $item->progressDistribusi }}</td>
                                    <td class="align-middle">
                                        @if ($item->status != 0)
                                            <small>Distribusi Terpenuhi <i
                                                    class="fa fa-fw fa-check text-success"></i></small>
                                        @else
                                            <small>Distribusi Belum Terpenuhi</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 0)
                                            <button data-toggle="modal" type="button" data-target="#modalProgress"
                                                wire:click="setProgress('{{ $item->id }}','{{ $item->jumlah }}','{{ $item->progressDistribusi }}')"
                                                class="btn btn-sm btn-primary"><i
                                                    class="fa fa-fw fa-plus"></i>&nbsp;Input
                                                Progress</button>
                                            <button class="btn btn-sm btn-warning" type="button"
                                                wire:click="setData('{{ $item->id }}')" data-toggle="modal"
                                                data-target="#modalUbah"><i
                                                    class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                            <button wire:loading.attr="disabled" type="button"
                                                wire:click="triggerConfirm('{{ $item->id }}')"
                                                class="btn btn-sm btn-danger"><i
                                                    class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
                                            <button wire:loading.attr="disabled" type="button"
                                                {{ $item->jumlah != $item->progressDistribusi ? 'hidden' : null }}
                                                wire:click="verified('{{ $item->id }}')"
                                                class="btn btn-sm btn-success"><i
                                                    class="fa fa-fw fa-check"></i>&nbsp;Terpenuhi</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Tidak ada data
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
            @if ($readyToLoad == true)
                <div class="float-right">
                    {{ $data_distribusi->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah-->
    <div wire:ignore.self class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Data Distribusi</h5>
                    <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='store'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model.defer="nama" placeholder="Nama" required
                                class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="number" placeholder="Jumlah" required
                                    class="form-control @error('jumlah') is-invalid @enderror"
                                    wire:model.defer="jumlah">
                                <span class="input-group-text" id="basic-addon1">Bungkus</span>
                                @error('jumlah')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Ubah-->
    <div wire:ignore.self class="modal fade" id="modalUbah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Ubah Data Distribusi</h5>
                    <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" wire:model.defer="nama" required
                                class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="number" min="0" required
                                class="form-control @error('jumlah') is-invalid @enderror" wire:model.defer="jumlah">
                            @error('jumlah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                            data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Input progress-->
    <div wire:ignore.self class="modal fade" id="modalProgress" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Progress Distribusi</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='progressDistribusi'>
                    <div class="modal-body">
                        <div class="for-group">
                            <input type="number" placeholder="Jumlah Progress" required
                                class="form-control @error('progress') is-invalid @enderror"
                                wire:model.defer="progress">
                            @error('progress')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
    {{-- End of File --}}
</div>
