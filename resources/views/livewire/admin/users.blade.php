<div>
    <div class="card">
        <div class="card-header">
            <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambah"><i
                    class="fa fa-fw fa-plus"></i> Tambah</button>
            <div class="form-row float-right">
                <div class="col-3">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text"><i class="fa fa-fw fa-filter"></i></div>
                        </div>
                        <select class="form-control" wire:model.lazy='filter_role'>
                            <option value="">-- Pilih Hak Akses --</option>
                            <option value="2">Jamaah</option>
                            <option value="3">Pengurus</option>
                            <option value="4">Ustad</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control" wire:model.lazy='filter_jabatan'>
                            <option value="">-- Pilih Jabatan --</option>
                            <option value="1">Distribusi Qurban</option>
                            <option value="2">Produksi Qurban</option>
                            <option value="3">Bendahara</option>
                            <option value="4">Ketua DKM</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <select class="form-control" wire:model.lazy='filter_status'>
                            <option value="">-- Pilih Status --</option>
                            <option value="1">Imam</option>
                            <option value="2">Muadzin</option>
                            <option value="3">Khotib</option>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="input-group mb-2">
                        <input class="form-control" wire:model.lazy="search" type="search"
                            placeholder="Cari nama user..." aria-label="Search">
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
                        <tr>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Hak akses</th>
                            <th>Jabatan</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody wire:init="loadPosts">
                        @if (empty($data_user))
                            <tr>
                                <td colspan="6" class="text-center">
                                    <i class="fa fa-spinner fa-spin"></i>
                                </td>
                            </tr>
                        @else
                            @forelse ($data_user as $item)
                                <tr>
                                    <td class="align-middle"><i class="fa fa-fw fa-user"></i>&nbsp;{{ $item->name }}
                                    </td>
                                    <td class="align-middle">
                                        <i class="fa fa-fw fa-phone"></i>&nbsp;{{ $item->kontak }}
                                    </td>
                                    <td>
                                        {{ $item->role == '2' ? 'Jamaah' : ($item->role == '3' ? 'Pengurus' : 'Ustaz') }}
                                    </td>
                                    <td>
                                        {{ $item->id_jabatan == '1' ? 'Distribusi Qurban' : ($item->id_jabatan == '2' ? 'Produksi Qurban' : ($item->id_jabatan == '3' ? 'Bendahara' : ($item->id_jabatan == '4' ? 'Ketua DKM' : 'Tidak ada jabatan'))) }}
                                    </td>
                                    <td>
                                        {{ $item->imam == true ? 'Imam, ' : '' }}{{ $item->muadzin == true ? 'Muadzin, ' : '' }}{{ $item->khotib == true ? 'Khotib' : '' }}
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-info" type="button"
                                                wire:click="detailUser('{{ $item->id }}')" data-toggle="modal"
                                                data-target="#modalDetail">
                                                <i class="fa fa-fw fa-info"></i>Detail
                                            </button>
                                            <button class="btn btn-sm btn-warning" type="button"
                                                wire:click="detailUser('{{ $item->id }}')" data-toggle="modal"
                                                data-target="#modalUbah">
                                                <i class="fa fa-fw fa-edit"></i>Ubah
                                            </button>
                                            <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                                type="button" id="dropdownMenu2" data-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa fa-fw fa-ellipsis-h"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                                @if ($item->JenisKelamin == 'Laki-laki')
                                                    <button class="dropdown-item" wire:loading.attr="disabled"
                                                        type="button"
                                                        wire:click="triggerStatus({{ $item->id }},'1','{{ $item->imam }}')"><i
                                                            class="fa fa-fw fa-{{ $item->imam == true ? 'times-circle' : 'check' }} text-{{ $item->imam == true ? 'danger' : 'success' }}"></i>Imam</button>
                                                    <button class="dropdown-item" wire:loading.attr="disabled"
                                                        type="button"
                                                        wire:click="triggerStatus({{ $item->id }},'2','{{ $item->muadzin }}')"><i
                                                            class="fa fa-fw fa-{{ $item->muadzin == true ? 'times-circle' : 'check' }} text-{{ $item->muadzin == true ? 'danger' : 'success' }}"></i>Muadzin</button>
                                                    <button class="dropdown-item" wire:loading.attr="disabled"
                                                        type="button"
                                                        wire:click="triggerStatus({{ $item->id }},'3','{{ $item->khotib }}')"><i
                                                            class="fa fa-fw fa-{{ $item->khotib == true ? 'times-circle' : 'check' }} text-{{ $item->khotib == true ? 'danger' : 'success' }}"></i>Khotib</button>
                                                @endif
                                                @if ($item->id_jabatan != null)
                                                    <button type="button" class="dropdown-item text-danger"
                                                        wire:click="triggerDeactiveJabatan({{ $item->id }})"><i
                                                            class="fa fa-fw fa-times-circle"></i>&nbsp;Jabatan</button>
                                                @else
                                                    <button type="button" data-toggle="modal"
                                                        data-target="#modalTambahJabatan"
                                                        wire:click="$set('new_id','{{ $item->id }}')"
                                                        class="dropdown-item text-primary"><i
                                                            class="fa fa-fw fa-plus"></i>&nbsp;
                                                        Jabatan</button>
                                                @endif
                                            </div>
                                            <button class="btn btn-sm btn-danger" type="button"
                                                wire:click="triggerConfirm('{{ $item->id }}')"><i
                                                    class="fa fa-fw fa-trash"></i>Hapus</button>
                                        </div>
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
                <div>
                    {{ $data_user->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Ubah-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalUbah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Ubah Data User</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='update'>
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
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('TanggalLahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('TempatLahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('JenisKelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- Kontak field --}}
                                <div class="input-group mb-3">
                                    <input type="text" maxlength="12" wire:model.defer="kontak"
                                        class="form-control @error('kontak') is-invalid @enderror"
                                        placeholder="Kontak">

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('kontak')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Alamat field --}}
                                <div class="input-group mb-3">
                                    <input type="text" wire:model.defer="alamat"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Alamat">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-location-arrow {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('JenisKelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Range Gaji --}}
                                <div class="input-group mb-3">
                                    <select wire:model.defer="range_gaji"
                                        class="form-control @error('range_gaji') is-invalid @enderror">
                                        <option>Pilih Range Penghasilan</option>
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

                                    @error('range_gaji')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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

    <!-- Modal Tambah-->
    <div wire:ignore.self.prevent class="modal fade" data-backdrop="static" data-keyboard="false" id="modalTambah"
        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal Tambah Data User</h5>
                    <button type="button" wire:click="resetFields()" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='store'>
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
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('TanggalLahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('TempatLahir')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('JenisKelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- Kontak field --}}
                                <div class="input-group mb-3">
                                    <input type="text" maxlength="12" wire:model.defer="kontak"
                                        class="form-control @error('kontak') is-invalid @enderror"
                                        placeholder="Kontak">

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-phone {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('kontak')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Alamat field --}}
                                <div class="input-group mb-3">
                                    <input type="text" wire:model.defer="alamat"
                                        class="form-control @error('alamat') is-invalid @enderror"
                                        placeholder="Alamat">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-location-arrow {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>
                                    @error('alamat')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('JenisKelamin')
                                        <div class="invalid-feedback">{{ $message }}</div>
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

                                    @error('range_gaji')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
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

    <!-- Modal Tambah Jabatan-->
    <div wire:ignore.self class="modal fade" id="modalTambahJabatan" data-backdrop="static" data-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Tambah Jabatan User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form wire:submit.prevent='updateJabatan'>
                    <div class="modal-body">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i class="fa fa-fw fa-universal-access"></i></div>
                            </div>
                            <select wire:model.defer="jabatan"
                                class="form-control @error('jabatan') is-invalid @enderror">
                                <option>Pilih jabatan</option>
                                <option value=4>DKM</option>
                                <option value=1>Distribusi Qurban</option>
                                <option value=2>Produksi Qurban</option>
                                <option value=3>Bendahara</option>
                            </select>
                            @error('jabatan')
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

</div>
