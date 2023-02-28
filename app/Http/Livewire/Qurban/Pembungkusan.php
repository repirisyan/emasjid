<?php

namespace App\Http\Livewire\Qurban;

use App\Models\MasterHewan;
use App\Models\Produksi;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Pembungkusan extends Component
{
    use LivewireAlert;

    public $nama, $jumlah, $jumlahProduksi, $new_id;

    protected $rules = [
        'nama' => ['required'],
        'jumlah' => ['required', 'numeric'],
    ];

    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    public $readyToLoad = false;

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.qurban.pembungkusan', [
            'data_pembungkusan' => $this->readyToLoad ? Produksi::with('master_hewan')->whereYear('created_at', date('Y'))->get() : [],
            'master_hewan' => $this->readyToLoad ? MasterHewan::all() : [],
        ]);
    }

    public function update()
    {
        $this->validate([
            'jumlah' => ['required', 'numeric', 'min:0'],
        ]);
        try {
            Produksi::find($this->new_id)->update([
                'jumlah' => $this->jumlah,
                'updated_at' => now(),
            ]);
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Throwable $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function info()
    {
        $this->alert(
            'info',
            'Informasi Pembungkusan',
            [
                'timer' => 5000,
                'toast' => true,
                'position' => 'center',
                'timerProgressBar' => true,
                'text' => 'Gunakan angka negatif untuk melakukan pengurangan pada inputan progress pembungkusan',
            ],
        );
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad');
    }

    public function inputJumlah($id)
    {
        $this->validate([
            'jumlahProduksi' => ['required', 'numeric'],
        ]);
        $jumlahProduksi = Produksi::where('id', $id)->value('jumlahProduksi');
        $jumlah = Produksi::where('id', $id)->value('jumlah');
        try {
            if (($jumlahProduksi + $this->jumlahProduksi) <= $jumlah) {
                Produksi::find($id)->update(['jumlahProduksi' => DB::raw('jumlahProduksi+' . $this->jumlahProduksi), 'updated_at' => now(),]);
            } else {
                $this->alert(
                    'error',
                    'Inputan melebihi batas'
                );
            }
        } catch (\Throwable $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menginput data'
            );
        }
        $this->resetFields();
    }

    public function store()
    {
        $this->validate();
        try {
            $cek = Produksi::whereYear('created_at', date('Y'))->where('master_hewan_id', $this->nama)->count();
            if ($cek == 0) {
                Produksi::create([
                    'master_hewan_id' => $this->nama,
                    'jumlah' => $this->jumlah,
                    'jumlahProduksi' => 0,
                ]);
                $this->alert(
                    'success',
                    'Data pembungkusan berhasil disimpan',
                );
            } else {
                $this->alert(
                    'error',
                    'Data telah diinputkan'
                );
            }
        } catch (\Throwable $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Hapus data pembungkusan daging ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        Produksi::destroy($this->new_id);
        $this->alert(
            'success',
            'Data Pembungkusan Daging berhasil dihapus'
        );
        $this->resetExcept('readyToLoad');
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetExcept('readyToLoad');
    }
}
