<?php

namespace App\Http\Livewire;

use App\Models\Kontak;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class HomeKontak extends Component
{
    use LivewireAlert;

    public $readyToLoad, $nama, $email, $subject, $pesan;
    public $rules = [
        'nama' => 'required',
        'email' => 'required|email',
        'subject' => 'required',
        'pasan' => 'required',
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
        return view('livewire.home-kontak');
    }

    public function send_message()
    {
        try {
            Kontak::create([
                'nama' => $this->nama,
                'email' => $this->email,
                'subject' => $this->subject,
                'pesan' => $this->pesan,
                'status' => 1
            ]);
            $this->alert(
                'success',
                'Pesan berhasil dikirim'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengirim pesan'
            );
        }
        $this->resetExcept('readyToLoad');
    }
}
