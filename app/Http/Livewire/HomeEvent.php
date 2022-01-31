<?php

namespace App\Http\Livewire;

use App\Models\Event;
use App\Models\EventContributor;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class HomeEvent extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad, $event_id, $nama_lengkap, $tanggal_lahir, $tempat_lahir, $jenis_kelamin, $no_hp, $alamat;
    public $rules = [
        'nama_lengkap' => 'required',
        'tanggal_lahir' => 'required|date',
        'tempat_lahir' => 'required',
        'jenis_kelamin' => 'required',
        'no_hp' => ['required', 'digits_between:3,12'],
        'alamat' => 'required',
    ];
    public function mount()
    {
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad');
    }

    public function render()
    {
        return view('livewire.home-event', [
            'data' => $this->readyToLoad ? Event::where('status', 1)->orderBy('tanggal_event', 'desc')->simplePaginate(9) : [],
        ]);
    }

    public function store()
    {
        $this->validate();
        try {
            $cek = EventContributor::where('event_id', $this->event_id)->where('nama_lengkap', $this->nama_lengkap)->count();
            if ($cek > 0) {
                $this->alert(
                    'error',
                    'Data anda sudah terdaftar'
                );
            } else {
                EventContributor::create([
                    'event_id' => $this->event_id,
                    'nama_lengkap' => $this->nama_lengkap,
                    'tanggal_lahir' => $this->tanggal_lahir,
                    'tempat_lahir' => $this->tempat_lahir,
                    'jenis_kelamin' => $this->jenis_kelamin,
                    'no_hp' => $this->no_hp,
                    'alamat' => $this->alamat,
                ]);
                $this->alert(
                    'success',
                    'Pendaftaran berhasil'
                );
            }
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }
}
