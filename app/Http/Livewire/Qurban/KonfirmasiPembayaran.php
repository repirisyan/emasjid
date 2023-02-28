<?php

namespace App\Http\Livewire\Qurban;

use App\Models\MasterHewan;
use App\Models\Qurban;
use App\Models\ShobulQurban;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class KonfirmasiPembayaran extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $hewan_id, $shobul_id, $readyToLoad, $master_hewan_id, $filter_hewan;

    public $nama, $alamat, $nama_hewan, $tipe, $permintaan_daging, $atasNama, $harga, $kode_pembayaran, $metode_pembayaran, $kontak;

    protected $listeners = [
        'confirmed',
        'cancelled',
        'confirmedTolak',
        'resetData',
        'cancelReset'
    ];

    public function mount()
    {
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.qurban.konfirmasi-pembayaran', [
            'data_pembayaran' => $this->readyToLoad ? ShobulQurban::with(['user', 'hewan', 'master_hewan'])->whereHas('hewan', function ($query) {
                $query->whereYear('created_at', date('Y'));
            })->when($this->filter_hewan != null, function ($query) {
                return $query->where('master_hewan_id', $this->filter_hewan);
            })->where('status', 0)->orderBy('created_at', 'asc')->simplePaginate(20) : [],
            'master_hewan' => $this->readyToLoad ?  MasterHewan::all() : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('filter_hewan', 'readyToLoad');
    }

    public function detail($id)
    {
        $data = ShobulQurban::with(['user', 'hewan', 'master_hewan'])->where('id', $id)->first();
        $this->nama = $data->user->name;
        $this->alamat = $data->user->alamat;
        $this->nama_hewan = $data->master_hewan->nama;
        $this->tipe = $data->hewan->tipe;
        $this->permintaan_daging = $data->permintaan_daging;
        $this->harga = $data->hewan->harga;
        $this->kode_pembayaran = $data->kode_pembayaran;
        $this->metode_pembayaran = $data->metode_pembayaran;
        $this->atasNama = $data->atasNama;
        $this->kontak = $data->user->kontak;
    }

    public function edit($id)
    {
        $data = ShobulQurban::with(['master_hewan'])->where('id', $id)->first();
        $this->permintaan_daging = $data->permintaan_daging;
        $this->atasNama = $data->atasNama;
        $this->shobul_id = $id;
        $this->master_hewan_id = $data->master_hewan->id;
    }

    public function update()
    {
        $this->validate([
            'permintaan_daging' => ['required', 'numeric', $this->master_hewan_id == 1 ? 'max:10' : 'max:5'],
            'atasNama' => ['required'],
            'updated_at' => now(),
        ]);
        try {
            ShobulQurban::find($this->shobul_id)->update(
                [
                    'permintaan_daging' => $this->permintaan_daging,
                    'atasNama' => $this->atasNama
                ]
            );
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function triggerConfirm($hewan_id, $shobul_id, $master_hewan_id)
    {
        $this->confirm('Konfirmasi Pembayaran?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->hewan_id = $hewan_id;
        $this->shobul_id = $shobul_id;
        $this->master_hewan_id = $master_hewan_id;
    }

    public function triggerReset()
    {
        $this->confirm('Lakukan Reset Data ' . date('Y') . ' ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'resetData',
            'onDismissed' => 'cancelReset'
        ]);
    }

    public function triggerTolak($shobul_id)
    {
        $this->confirm('Tolak Pembayaran ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmedTolak',
            'onDismissed' => 'cancelled'
        ]);

        $this->shobul_id = $shobul_id;
    }


    public function confirmedTolak()
    {
        try {
            ShobulQurban::find($this->shobul_id)->update(
                [
                    'status' => 2, 'updated_at' => now(),
                ]
            );
            $this->alert(
                'success',
                'Pembayaran berhasil ditolak'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat konfirmasi pemabayaran'
            );
        }
        $this->resetFields();
    }

    public function confirmed()
    {
        $id_qurban = Qurban::where('hewan_id', $this->hewan_id)
            ->where('master_hewan_id', $this->master_hewan_id)
            ->where('jumlah_shobul', '<', ($this->master_hewan_id == 1 ? 7 : 1))
            ->sharedLock()
            ->value('id');
        try {
            if ($id_qurban != null) {
                DB::transaction(function () use ($id_qurban) {
                    Qurban::find($id_qurban)->increment('jumlah_shobul');
                    ShobulQurban::find($this->shobul_id)->update(['qurban_id' => $id_qurban, 'status' => 1, 'updated_at' => now(),]);
                });
                $jumlah_shobul = Qurban::where('id', $id_qurban)->sharedLock()->value('jumlah_shobul');
                if ($jumlah_shobul == 7) {
                    Qurban::find($id_qurban)->update([
                        'status' => 4,
                        'updated_at' => now(),
                    ]);
                }
            } else {
                $id_qurban = date('Ymdhis');
                DB::transaction(function () use ($id_qurban) {
                    Qurban::create([
                        'id' => $id_qurban,
                        'hewan_id' => $this->hewan_id,
                        'master_hewan_id' => $this->master_hewan_id,
                        'jumlah' => 1,
                        'jumlah_disembelih' => 0,
                        'jumlah_shobul' => 1,
                        'status' => $this->master_hewan_id == 1 ? 0 : 4,
                        'berat_timbangan' => 0,
                    ]);
                    ShobulQurban::find($this->shobul_id)->update(
                        [
                            'qurban_id' => $id_qurban,
                            'status' => 1,
                            'updated_at' => now(),
                        ]
                    );
                });
            }
            $this->alert(
                'success',
                'Pembayaran diterima'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat konfirmasi pembayaran'
            );
        }
        $this->resetFields();
    }

    public function cancelled()
    {
        $this->resetFields();
    }

    public function resetData()
    {
        try {
            ShobulQurban::whereYear('created_at', date('Y'))->update([
                'qurban_id' => null,
                'status' => 0,
            ]);
            Qurban::whereYear('created_at', date('Y'))->delete();
            $this->alert(
                'success',
                'Reset Data berhasil'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi Kesalahan saat melakukan reset data'
            );
        }
    }

    public function cancelReset()
    {
        // Example code inside cancelled callback
        $this->alert('info', 'Fitur ini hanya untuk kebutuhan development');
    }
}
