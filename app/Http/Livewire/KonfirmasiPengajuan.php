<?php

namespace App\Http\Livewire;

use App\Models\Keuangan;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class KonfirmasiPengajuan extends Component
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
        return view('livewire.konfirmasi-pengajuan', [
            'data' => Keuangan::where('kategori', 2)->where('status', 2)->simplePaginate(10),
        ]);
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Terima pengajuan anggaran ini ?', [
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
        $this->confirm('Tolak pengajuan anggaran ini ?', [
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
                'Pengajuan Anggaran berhasil dikonfirmasi'
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
                'Pengajuan Anggaran berhasil ditolak'
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
