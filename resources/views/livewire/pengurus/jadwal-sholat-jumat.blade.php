<div wire:init="loadPosts">
    {{-- The Master doesn't talk, he acts. --}}
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah">Tambah Data <i
                    class="fa fa-fw fa-plus"></i></button>
        </div>
        <div class="card-body">
            <div class="table table-responsive-sm">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Imam</th>
                            <th>Khotib</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (empty($data))
                            <tr>
                                <td colspan="4" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data as $item)
                                @php
                                    $date = date_create($item->tanggal);
                                @endphp
                                <tr>
                                    <td>{{ date_format($date, 'd M Y') }}</td>
                                    <td>{{ $item->imam->name }}</td>
                                    <td>{{ $item->khotib->name }}</td>
                                    <td>
                                        <button wire:loading.attr="disabled" type="button" data-target="#modalUbah"
                                            data-toggle="modal" class="btn btn-sm btn-warning"
                                            wire:click="edit('{{ $item->id }}')"><i
                                                class="fa fa-fw fa-edit"></i>&nbsp;Ubah</button>
                                        <button wire:loading.attr="disabled" type="button" data-target="#modalHapus"
                                            class="btn btn-sm btn-danger"
                                            wire:click="triggerConfirm('{{ $item->id }}')"><i
                                                class="fa fa-fw fa-trash"></i> Hapus</button>
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
                <div>
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tambah-->
    <div wire:ignore.self class="modal fade" id="modalTambah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Sholat Jumat</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='store'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="date" wire:model.defer="tanggal_kegiatan" required
                                class="form-control @error('tanggal_kegiatan') is-invalid @enderror"
                                placeholder="Tanggal">
                            @error('tanggal_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select wire:model.defer="imam_id" required
                                class="form-control @error('imam_id') is-invalid @enderror">
                                <option>Pilih Imam</option>
                                @foreach ($imam as $item)
                                    <option value={{ $item->id }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('imam_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select wire:model.defer="khotib_id" required
                                class="form-control @error('khotib_id') is-invalid @enderror">
                                <option>Pilih Khotib</option>
                                @foreach ($khotib as $item)
                                    <option value={{ $item->id }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('khotib_id')
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

    <!-- Modal Ubah-->
    <div wire:ignore.self class="modal fade" id="modalUbah" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Sholat Jumat</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update'>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="date" wire:model.defer="tanggal_kegiatan" required
                                class="form-control @error('tanggal_kegiatan') is-invalid @enderror"
                                placeholder="Tanggal">
                            @error('tanggal_kegiatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select wire:model.defer="imam_id" required
                                class="form-control @error('imam_id') is-invalid @enderror">
                                @foreach ($imam as $item)
                                    <option value={{ $item->id }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('imam_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <select wire:model.defer="khotib_id" required
                                class="form-control @error('khotib_id') is-invalid @enderror">
                                @foreach ($khotib as $item)
                                    <option value={{ $item->id }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('khotib_id')
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
</div>
