<?php

namespace App\Http\Livewire;

use App\Models\MasterHewan;
use App\Models\Qurban;
use App\Models\ShobulQurban;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Pembayaran extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $id_hewan, $id_shobul, $id_master_hewan, $readyToLoad;
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
        $this->id_master_hewan = 1;
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.pembayaran', [
            'data_pembayaran' => $this->readyToLoad ? ShobulQurban::with('user', 'hewan', 'master_hewan')->whereHas('hewan', function ($query) {
                $query->whereYear('created_at', date('Y'));
            })->where('master_hewan_id', $this->id_master_hewan)->where('status', 0)->orderBy('created_at', 'asc')->simplePaginate(7) : [],
            'master_hewan' => $this->readyToLoad ?  MasterHewan::all() : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('id_master_hewan', 'readyToLoad');
    }

    public function detail($nama, $alamat, $nama_hewan, $tipe, $harga, $permintaan_daging, $kode_pembayaran, $metode_pembayaran, $atasNama, $kontak)
    {
        $this->nama = $nama;
        $this->alamat = $alamat;
        $this->nama_hewan = $nama_hewan;
        $this->tipe = $tipe;
        $this->permintaan_daging = $permintaan_daging;
        $this->harga = $harga;
        $this->kode_pembayaran = $kode_pembayaran;
        $this->metode_pembayaran = $metode_pembayaran;
        $this->atasNama = $atasNama;
        $this->kontak = $kontak;
    }

    public function setUpdate($id, $id_master_hewan, $atasNama, $permintaan)
    {
        $this->permintaan_daging = $permintaan;
        $this->atasNama = $atasNama;
        $this->id_shobul = $id;
        $this->id_master_hewan = $id_master_hewan;
    }

    public function update()
    {
        $this->validate([
            'permintaan_daging' => ['required', 'numeric', $this->id_master_hewan == 1 ? 'max:10' : 'max:5'],
            'atasNama' => ['required'],
            'updated_at' => now(),
        ]);
        try {
            ShobulQurban::find($this->id_shobul)->update(['permintaan_daging' => $this->permintaan_daging, 'atasNama' => $this->atasNama]);
            $this->alert(
                'success',
                'Data Pendaftaran Terlah diubah'
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

    public function triggerConfirm($id_hewan, $id_shobul, $id_master_hewan)
    {
        $this->confirm('Konfirmasi Pembayaran?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->id_hewan = $id_hewan;
        $this->id_shobul = $id_shobul;
        $this->id_master_hewan = $id_master_hewan;
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

    public function triggerTolak($id_shobul)
    {
        $this->confirm('Tolak Pembayaran ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmedTolak',
            'onDismissed' => 'cancelled'
        ]);

        $this->id_shobul = $id_shobul;
    }


    public function confirmedTolak()
    {
        try {
            ShobulQurban::find($this->id_shobul)->update(['status' => 2, 'updated_at' => now(),]);
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
        $this->resetExcept('id_master_hewan', 'readyToLoad');
    }

    public function confirmed()
    {
        $id_qurban = Qurban::where('hewan_id', $this->id_hewan)
            ->where('master_hewan_id', $this->id_master_hewan)
            ->where('jumlah_shobul', '<', ($this->id_master_hewan == 1 ? 7 : 1))
            ->sharedLock()
            ->value('id');
        try {
            if ($id_qurban != null) {
                DB::transaction(function () use ($id_qurban) {
                    Qurban::find($id_qurban)->increment('jumlah_shobul');
                    ShobulQurban::find($this->id_shobul)->update(['qurban_id' => $id_qurban, 'status' => 1, 'updated_at' => now(),]);
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
                        'hewan_id' => $this->id_hewan,
                        'master_hewan_id' => $this->id_master_hewan,
                        'jumlah' => 1,
                        'jumlah_disembelih' => 0,
                        'jumlah_shobul' => 1,
                        'status' => $this->id_master_hewan == 1 ? 0 : 4,
                        'berat_timbangan' => 0,
                    ]);
                    ShobulQurban::find($this->id_shobul)->update(['qurban_id' => $id_qurban, 'status' => 1, 'updated_at' => now(),]);
                });
            }
            $this->alert(
                'success',
                'Pembayaran telah dikonfirmasi'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat konfirmasi pembayaran'
            );
        }
        $this->resetExcept('id_master_hewan', 'readyToLoad');
    }

    public function cancelled()
    {
        $this->resetExcept('id_master_hewan', 'readyToLoad');
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
