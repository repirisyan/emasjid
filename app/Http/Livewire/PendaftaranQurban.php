<?php

namespace App\Http\Livewire;

use App\Models\Hewan;
use App\Models\MasterHewan;
use App\Models\ShobulQurban;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PendaftaranQurban extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public $nama, $alamat, $nama_hewan, $tipe, $harga, $atasNama, $kontak, $kode_pembayaran;
    public $pembayaran, $permintaan, $number, $id_hewan, $id_master_hewan, $id_shobul, $status, $date;

    public function mount()
    {
        $this->status = 0;
        $this->id_master_hewan = 1;
    }

    public function filterSearch($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public $readyToLoad = false;

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.pendaftaran-qurban', [
            'data_pendaftaran' => $this->readyToLoad ? ShobulQurban::with('user', 'master_hewan', 'hewan', 'qurban')->where('status', $this->status)->where('user_id', auth()->user()->id)->simplePaginate(5) : [],
            'data_hewan' => $this->readyToLoad ? Hewan::with('master_hewan')->whereYear('created_at', date('Y'))->where('master_hewan_id', $this->id_master_hewan)->get() : [],
            'master_hewan' => $this->readyToLoad ? MasterHewan::all() : [],
        ]);
    }

    public function setData($id_hewan, $id_master_hewan, $atasNama)
    {
        $this->id_hewan = $id_hewan;
        $this->id_master_hewan = $id_master_hewan;
        $this->atasNama = $atasNama;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('status', 'readyToLoad', 'id_master_hewan');
    }

    public function detail($nama, $alamat, $nama_hewan, $tipe, $harga, $permintaan_daging, $kode_pembayaran, $metode_pembayaran, $atasNama, $kontak, $date)
    {
        $this->nama = $nama;
        $this->alamat = $alamat;
        $this->nama_hewan = $nama_hewan;
        $this->tipe = $tipe;
        $this->permintaan = $permintaan_daging;
        $this->harga = $harga;
        $this->kode_pembayaran = $kode_pembayaran;
        $this->pembayaran = $metode_pembayaran;
        $this->atasNama = $atasNama;
        $this->kontak = $kontak;
        $this->date = $date;
    }

    public function daftar()
    {
        $this->validate([
            'pembayaran' => ['required'],
            'permintaan' => ['required', 'numeric', $this->id_master_hewan == 1 ? 'max:10' : 'max:5'],
            'atasNama' => ['required'],
        ]);
        $id = mt_rand();
        try {
            ShobulQurban::create([
                'user_id' => auth()->user()->id,
                'hewan_id' => $this->id_hewan,
                'master_hewan_id' => $this->id_master_hewan,
                'metode_pembayaran' => $this->pembayaran,
                'permintaan_daging' => $this->permintaan,
                'permintaan_daging_confirm' => 0,
                'atasNama' => $this->atasNama,
                'kode_pembayaran' => $id,
                'status' => 0
            ]);
            $this->alert(
                'success',
                'Pendaftaran Qurban Berhasil'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Pendaftaran Qurban Gagal'
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }

    public function setUpdate($id, $id_master_hewan, $permintaan, $pembayaran, $atasNama)
    {
        $this->permintaan = $permintaan;
        $this->atasNama = $atasNama;
        $this->pembayaran = $pembayaran;
        $this->id_shobul = $id;
        $this->id_master_hewan = $id_master_hewan;
    }

    public function update()
    {
        $this->validate([
            'pembayaran' => ['required'],
            'permintaan' => ['required', 'numeric', $this->id_master_hewan == 1 ? 'max:10' : 'max:5'],
            'atasNama' => ['required'],
        ]);
        try {
            ShobulQurban::find($this->id_shobul)->update([
                'permintaan_daging' => $this->permintaan,
                'atasNama' => $this->atasNama,
                'metode_pembayaran' => $this->pembayaran,
                'updated_at' => now(),
            ]);
            $this->alert(
                'success',
                'Data Pendaftaran Telah diubah'
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

    public function triggerConfirm($id)
    {
        $this->confirm('Apa anda yakin akan menghapus data ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled',
        ]);
        $this->id_shobul = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        ShobulQurban::destroy($this->id_shobul);
        $this->alert(
            'success',
            'Data berhasil dihapus'
        );
        $this->resetExcept('readyToLoad', 'status', 'id_master_hewan');
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetExcept('readyToLoad', 'status', 'id_master_hewan');
    }
}
