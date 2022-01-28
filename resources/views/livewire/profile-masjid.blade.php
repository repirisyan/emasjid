<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <img class="mx-auto d-block" src="{{ asset('storage/logo/mosque.png') }}" style="width: 200px; height: 200px"
                                title="Logo Image" alt="Logo Img" srcset="">
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive-md">
                                <table class="table-borderless text-muted">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Persyaratan Logo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <small>
                                                    Min Lebar & Tinggi
                                                </small>
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <small>50 x 50 pixel</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small>
                                                    Max Lebar & TInggi
                                                </small>
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <small>512 x 512 pixel</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small>
                                                    Max Ukuran File
                                                </small>
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <small>128KB</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small>
                                                    Tipe File
                                                </small>
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <small>png</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="d-block" wire:model.lazy="logo" type="file">
                                                @error('logo') <div class="invalid-feedback">{{ $message }}
                                                </div>@enderror
                                                <button wire:loading.attr="disabled" wire:click="triggerConfirm()"
                                                    class="mt-2 btn btn-sm btn-primary"><i
                                                        class="fa fa-fw fa-upload"></i>&nbsp;Upload</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4">
                            <img class="mx-auto d-block" src="{{ asset('storage/favicons/favicon.ico') }}" style="width: 50px; height: 50px"
                                title="Favicon" alt="">
                        </div>
                        <div class="col-md-8">
                            <div class="table-responsive-md">
                                <table class="table-borderless text-muted">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Persyaratan Favicon</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <small>
                                                    Min Lebar & Tinggi
                                                </small>
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <small>32 x 32 pixel</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small>
                                                    Max Lebar & TInggi
                                                </small>
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <small>180 x 180 pixel</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small>
                                                    Max Ukuran File
                                                </small>
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <small>25KB</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <small>
                                                    Tipe File
                                                </small>
                                            </td>
                                            <td>
                                                :
                                            </td>
                                            <td>
                                                <small>ico</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input class="d-block" wire:model.lazy="favicon" type="file">
                                                @error('favicon') <div class="invalid-feedback">{{ $message }}
                                                </div>@enderror
                                                <button wire:loading.attr="disabled" wire:click="triggerFav()"
                                                    class="mt-2 btn btn-sm btn-primary"><i
                                                        class="fa fa-fw fa-upload"></i>&nbsp;Upload</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
