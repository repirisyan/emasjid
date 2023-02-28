<?php

namespace App\Http\Livewire\Ketua;

use App\Models\Keuangan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class KonfirmasiPengajuanAnggaran extends Component
{
    use LivewireAlert;

    public $readyToLoad, $tanggal, $keterangan, $nilai, $id_keuangan;

    protected $listeners = [
        'confirmed',
        'cancelled',
        'deny',
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
        return view('livewire.ketua.konfirmasi-pengajuan-anggaran', [
            'data' => $this->readyToLoad ? Keuangan::where('kategori', 2)->where('status', 2)->orderBy('tanggal', 'asc')->simplePaginate(30) : [],
        ]);
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Terima pengajuan anggaran ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Terima',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);
        $this->id_keuangan = $id;
    }

    public function triggerDeny($id)
    {
        $this->confirm('Tolak pengajuan anggaran ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Tolak',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'deny',
            'onDismissed' => 'cancelled'
        ]);
        $this->id_keuangan = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            Keuangan::find($this->id_keuangan)->update([
                'status' => 1,
                'updated_at' => now(),
            ]);
            $this->alert(
                'success',
                'Pengajuan diterima'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat melakukan konfirmasi'
            );
        }
        $this->resetExcept('readyToLoad');
    }

    public function deny()
    {
        try {
            Keuangan::find($this->id_keuangan)->update([
                'status' => 3,
                'updated_at' => now(),
            ]);
            $this->alert(
                'success',
                'Pengajuan ditolak'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat melakukan konfirmasi'
            );
        }
        $this->resetExcept('readyToLoad');
    }

    public function cancelled()
    {
        $this->resetExcept('readyToLoad');
    }
}
