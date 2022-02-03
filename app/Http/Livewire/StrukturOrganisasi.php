<?php

namespace App\Http\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class StrukturOrganisasi extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    public $gambar;

    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    public function render()
    {
        return view('livewire.struktur-organisasi');
    }

    public function triggerConfirm()
    {
        $this->confirm('Upload Gambar ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Upload',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);
    }

    public function confirmed()
    {
        try {
            $this->validate([
                'gambar' => 'max:1024|mimes:png'
            ]);
            $this->gambar->storeAs('public/struktur_organisasi/', 'struktur_organisasi.png');
            $this->reset();
            return redirect()->to('admin/settings/masjid/struktur-organisasi');
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat upload file'
            );
            $this->reset();
        }
    }

    public function cancelled()
    {
        $this->reset();
    }
}
