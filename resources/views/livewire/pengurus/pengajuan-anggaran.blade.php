<div wire:init="loadPosts">
    {{-- Stop trying to control. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah"><i
                    class="fa fa-fw fa-plus"></i> Tambah</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <tr>
                            <th>Keterangan</th>
                            <th>Nilai</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($data))
                            <tr>
                                <td colspan="5" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $item->keterangan }}</td>
                                    <td>Rp. {{ number_format($item->nilai, '0', ',', '.') }}</td>
                                    <td>{{ $item->tanggal }}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            <small class="text-teal">
                                                Diterima&nbsp;<i class="fa fa-fw fa-check"></i>
                                            </small>
                                        @elseif($item->status == 2)
                                            <small class="text-info">
                                                Menunggu Konfirmasi&nbsp;<i class="fa fa-fw fa-spinner fa-spin"></i>
                                            </small>
                                        @elseif($item->status == 3)
                                            <small class="text-danger">
                                                Ditolak&nbsp;<i class="fa fa-fw fa-times"></i>
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->status == 2)
                                            <button class="btn btn-sm btn-warning" data-toggle="modal"
                                                data-target="#modalUbah" wire:click="edit('{{ $item->id }}')"><i
                                                    class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                            <button wire:loading.attr="disabled" class="btn btn-sm btn-danger"
                                                wire:click="triggerConfirm({{ $item->id }})"><i
                                                    class="fa fa-fw fa-trash"></i>&nbsp;Hapus</button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Tidak ada data
                                    </td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
            @if ($readyToLoad == true)
                <div>
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalTambah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Tambah Pengajuan Anggaran</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='store'>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-fw fa-calendar"></i></span>
                                <input type="date" wire:model.defer="tanggal" aria-describedby="basic-addon1"
                                    required class="form-control @error('tanggal') is-invalid @enderror"
                                    placeholder="tanggal">
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="keterangan" required
                                class="form-control @error('keterangan') is-invalid @enderror" placeholder="keterangan">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input min="0" type="number" wire:model.defer="nilai" required
                                    aria-describedby="basic-addon1"
                                    class="form-control @error('nilai') is-invalid @enderror" placeholder="100000">
                                @error('nilai')
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
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalUbah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Ubah Pengajuan Anggaran</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update'>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i
                                        class="fa fa-fw fa-calendar"></i></span>
                                <input type="date" wire:model.defer="tanggal" aria-describedby="basic-addon1"
                                    required class="form-control @error('tanggal') is-invalid @enderror"
                                    placeholder="tanggal">
                                @error('tanggal')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" wire:model.defer="keterangan" required
                                class="form-control @error('keterangan') is-invalid @enderror"
                                placeholder="keterangan">
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                <input min="0" type="number" wire:model.defer="nilai" required
                                    aria-describedby="basic-addon1"
                                    class="form-control @error('nilai') is-invalid @enderror" placeholder="100000">
                                @error('nilai')
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
</div>
