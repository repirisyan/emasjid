<div>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah"><i
                    class="fa fa-fw fa-plus"></i> Tambah</button>
            <div class="form-inline float-right">
                <input class="form-control" wire:model.lazy="search" type="search" placeholder="Cari Nama..."
                    aria-label="Search">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive-sm">
                <table class="table" style="white-space: nowrap">
                    <thead>
                        <tr>
                            <th scope="col">Nama</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody wire:init="loadPosts">
                        @foreach ($data_user as $item)
                            <tr style="white-space: nowrap">
                                <td class="align-middle"><i class="fa fa-fw fa-user"></i>&nbsp;{{ $item->name }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button"
                                            id="dropdownMenu2" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fa fa-fw fa-ellipsis-h"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                            <button class="dropdown-item" type="button"
                                                wire:click="detailUser('{{ $item->id }}')" data-toggle="modal"
                                                data-target="#modalDetail">
                                                <i class="fa fa-fw fa-info"></i>Detail
                                            </button>
                                            <button class="dropdown-item" type="button"
                                                wire:click="detailUser('{{ $item->id }}')" data-toggle="modal"
                                                data-target="#modalTambah">
                                                <i class="fa fa-fw fa-edit"></i>Ubah
                                            </button>
                                            <button class="dropdown-item" type="button" data-toggle="modal"
                                                data-target="#modalUbah"
                                                wire:click="$set('new_id','{{ $item->id }}')"><i
                                                    class="fa fa-fw fa-user"></i>Hak
                                                Akses</button>
                                            <button class="dropdown-item text-danger" type="button"
                                                wire:click="triggerConfirm('{{ $item->id }}')"><i
                                                    class="fa fa-fw fa-trash"></i>Hapus</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($readyToLoad == true)
                <div>
                    {{ $data_user->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modalUbah" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Hak Akses</h5>
                    <button wire:click="resetFields()" type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-fw fa-universal-access"></i></div>
                        </div>
                        <select wire:model.defer="status" class="form-control @error('status') is-invalid @enderror">
                            <option>Pilih hak akses</option>
                            <option value="3">Pengurus</option>
                            <option value="4">Ustadz</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="update()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalTambah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Data User</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Name field --}}
                            <div class="input-group mb-3">
                                <input type="text" wire:model.defer="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="{{ __('adminlte::adminlte.full_name') }}" autofocus>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir field --}}
                            <div class="input-group mb-3">
                                <input type="date" wire:model.defer="TanggalLahir"
                                    class="form-control @error('TanggalLahir') is-invalid @enderror">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fas fa-calendar {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('TanggalLahir') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Tempat Lahir field --}}
                            <div class="input-group mb-3">
                                <input type="text" wire:model.defer="TempatLahir"
                                    class="form-control @error('TempatLahir') is-invalid @enderror"
                                    placeholder="Tempat Lahir" autofocus>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fas fa-globe {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('TempatLahir') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin field --}}
                            <div class="input-group mb-3">
                                <select wire:model.defer="JenisKelamin"
                                    class="form-control @error('JenisKelamin') is-invalid @enderror">
                                    <option>Pilih Jenis Kelamin</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fas fa-venus-mars {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('JenisKelamin') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email field --}}
                            <div class="input-group mb-3">
                                <input type="email" wire:model.defer="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email Optional">

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('email') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- Kontak field --}}
                            <div class="input-group mb-3">
                                <input type="text" maxlength="12" wire:model.defer="kontak"
                                    class="form-control @error('kontak') is-invalid @enderror" placeholder="Kontak">

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('kontak') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Alamat field --}}
                            <div class="input-group mb-3">
                                <input type="text" wire:model.defer="alamat"
                                    class="form-control @error('alamat') is-invalid @enderror" placeholder="Alamat">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fas fa-location-arrow {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>
                                @error('alamat') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Jenis Hak Akses --}}
                            <div class="input-group mb-3">
                                <select wire:model.defer="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                    <option>Pilih hak akses</option>
                                    <option value="2">Jemaah</option>
                                    <option value="3">Pengurus</option>
                                    <option value="4">Ustadz</option>
                                </select>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('JenisKelamin') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Range Gaji --}}
                            <div class="input-group mb-3">
                                <select wire:model.defer="range_gaji"
                                    class="form-control @error('range_gaji') is-invalid @enderror">
                                    <option>Pilih Range Gaji</option>
                                    <option value="<=500.000">
                                        <=500.000 </option>
                                    <option value="1500.000=>500.000">1500.000=>500.000</option>
                                    <option value="2500.000=>1500.000">2500.000=>1500.000</option>
                                    <option value="3500.000=>2500.000">3500.000=>2500.000</option>
                                    <option value="4500.000=>3500.000">4500.000=>3500.000</option>
                                    <option value="5500.000=>4500.000">5500.000=>4500.000</option>
                                    <option value=">=6000.0000">>=6000.0000</option>
                                </select>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span
                                            class="fas fa-money-bill {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                    </div>
                                </div>

                                @error('range_gaji') <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="resetFields()" class="btn btn-secondary"
                        data-dismiss="modal">Tutup</button>
                    <button type="button" wire:click="store()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
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
