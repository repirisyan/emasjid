<div>
    <div class="card">
        <div class="card-header">
            <div class="form-inline float-right">
                <input class="form-control" wire:model.lazy="search" type="search" placeholder="Cari Nama..."
                    aria-label="Search">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody wire:init="loadPosts">
                        @foreach ($data as $item)
                            <tr style="white-space: nowrap">
                                <td class="align-middle"><i class="fa fa-fw fa-user"></i>&nbsp;{{ $item->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-fw fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            <button class="dropdown-item"
                                                wire:click="detailUser('{{ $item->id }}')" data-toggle="modal"
                                                data-target="#modalDetail"><i class="fa fa-fw fa-info"></i>Detail
                                            </button>
                                            <button class="dropdown-item text-danger" wire:loading.attr="disabled"
                                                type="button" wire:click="triggerConfirm({{ $item->id }})"><i
                                                    class="fa fa-fw fa-times-circle"></i>Nonaktifkan</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($this->readyToLoad == true)
                <div>
                    {{ $data->links() }}
                </div>
            @endif
        </div>
    </div>
    <!-- Modal Detail-->
    <div wire:ignore.self class="modal fade" id="modalDetail" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><i class="fa fa-fw fa-user"></i>
                        {{ $name }}</h5>
                    <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tr>
                                <th class="text-muted">Tanggal Lahir</th>
                                <td><i class="fa fa-fw fa-calendar"></i> {{ $TanggalLahir }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Tempat Lahir</th>
                                <td><i class="fa fa-fw fa-globe"></i> {{ $TempatLahir }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Jenis Kelamin</th>
                                <td><i
                                        class="fa fa-fw {{ $JenisKelamin == 'Perempuan' ? 'fa-venus' : 'fa-mars' }}"></i>
                                    {{ $JenisKelamin }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Alamat</th>
                                <td><i class="fa fa-fw fa-location-arrow"></i> {{ $alamat }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Kontak</th>
                                <td><i class="fa fa-fw fa-phone"></i> {{ $kontak }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">E-mail</th>
                                <td><i class="fa fa-fw fa-envelope"></i> {{ $email }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Range Gaji</th>
                                <td><i class="fa fa-fw fa-money-bill"></i> {{ $range_gaji }}</td>
                            </tr>
                            <tr>
                                <th class="text-muted">Dibuat</th>
                                <td><i class="fa fa-fw fa-clock"></i> {{ $created_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
</div>
