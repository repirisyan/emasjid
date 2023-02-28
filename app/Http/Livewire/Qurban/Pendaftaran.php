<?php

namespace App\Http\Livewire\Qurban;

use App\Models\Hewan;
use App\Models\MasterHewan;
use App\Models\ShobulQurban;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Pendaftaran extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public $nama, $alamat, $nama_hewan, $tipe, $harga, $atasNama, $kontak, $kode_pembayaran, $metode_pembayaran;
    public $readyToLoad, $filter_hewan, $filter_status, $permintaan, $number, $hewan_id, $master_hewan_id, $shobul_id, $status, $date;

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
        return view('livewire.qurban.pendaftaran', [
            'data_pendaftaran' => $this->readyToLoad ? ShobulQurban::with('user', 'master_hewan', 'hewan', 'qurban')->when($this->filter_status != null, function ($query) {
                return $query->where('status', $this->filter_status);
            })->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->simplePaginate(25) : [],
            'data_hewan' => $this->readyToLoad ? Hewan::with('master_hewan')->whereYear('created_at', date('Y'))->when($this->filter_hewan != null, function ($query) {
                return $query->where('master_hewan_id', $this->filter_hewan);
            })->orderBy('master_hewan_id', 'asc')->get() : [],
            'master_hewan' => $this->readyToLoad ? MasterHewan::all() : [],
        ]);
    }

    public function updatingFilterStatus()
    {
        $this->resetPage();
    }

    public function setData($hewan_id, $master_hewan_id, $atasNama)
    {
        $this->hewan_id = $hewan_id;
        $this->master_hewan_id = $master_hewan_id;
        $this->atasNama = $atasNama;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('status', 'readyToLoad', 'filter_status', 'filter_hewan');
    }

    public function detail($id)
    {
        $data = ShobulQurban::with(['user', 'master_hewan', 'hewan', 'qurban'])->where('id', $id)->first();
        $this->nama = $data->user->name;
        $this->alamat = $data->user->alamat;
        $this->nama_hewan = $data->master_hewan->nama;
        $this->tipe = $data->hewan->tipe;
        $this->permintaan = $data->permintaan_daging;
        $this->harga = $data->hewan->harga;
        $this->kode_pembayaran = $data->kode_pembayaran;
        $this->metode_pembayaran = $data->metode_pembayaran;
        $this->atasNama = $data->atasNama;
        $this->kontak = $data->user->kontak;
        $this->date = date_format($data->created_at, 'd M Y');
    }

    public function daftar()
    {
        $this->validate([
            'metode_pembayaran' => ['required'],
            'permintaan' => ['required', 'numeric', $this->master_hewan_id == 1 ? 'max:10' : 'max:5'],
            'atasNama' => ['required'],
        ]);
        try {
            ShobulQurban::create([
                'user_id' => auth()->user()->id,
                'hewan_id' => $this->hewan_id,
                'master_hewan_id' => $this->master_hewan_id,
                'metode_pembayaran' => $this->metode_pembayaran,
                'permintaan_daging' => $this->permintaan,
                'permintaan_daging_confirm' => 0,
                'atasNama' => $this->atasNama,
                'kode_pembayaran' => mt_rand(),
                'status' => 0
            ]);
            $this->alert(
                'success',
                'Pendaftaran Qurban Berhasil'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }

    public function edit($id)
    {
        $data = ShobulQurban::with(['master_hewan'])->where('id', $id)->first();
        $this->permintaan = $data->permintaan_daging;
        $this->atasNama = $data->atasNama;
        $this->metode_pembayaran = $data->metode_pembayaran;
        $this->shobul_id = $id;
        $this->master_hewan_id = $data->master_hewan->id;
    }

    public function update()
    {
        $this->validate([
            'metode_pembayaran' => ['required'],
            'permintaan' => ['required', 'numeric', $this->master_hewan_id == 1 ? 'max:10' : 'max:5'],
            'atasNama' => ['required'],
        ]);
        try {
            ShobulQurban::find($this->shobul_id)->update([
                'permintaan_daging' => $this->permintaan,
                'atasNama' => $this->atasNama,
                'metode_pembayaran' => $this->metode_pembayaran,
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
        $this->confirm('Hapus data ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled',
        ]);
        $this->shobul_id = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            ShobulQurban::destroy($this->shobul_id);
            $this->alert(
                'success',
                'Data berhasil dihapus'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menghapus data'
            );
        }
        $this->resetFields();
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetFields();
    }
}
