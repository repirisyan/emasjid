<?php

namespace App\Http\Livewire;

use App\Models\Event as ModelsEvent;
use App\Models\EventContributor;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Event extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $readyToLoad, $nama, $tanggal, $new_id, $status, $contributor = [], $nama_event;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'confirmed',
        'cancelled',
        'status',
    ];

    public $rules = [
        'nama' => 'required',
        'tanggal' => 'required|date',
    ];

    public function mount()
    {
        $this->status = 1;
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'status');
    }

    public function render()
    {
        return view('livewire.event', [
            'data' => $this->readyToLoad ? ModelsEvent::where('status', $this->status)->simplePaginate(5) : [],
        ]);
    }

    public function edit($id)
    {
        $data = ModelsEvent::find($id)->first();
        $this->nama = $data->nama_event;
        $this->tanggal = $data->tanggal_event;
        $this->new_id = $id;
    }

    public function contributor($id, $nama)
    {
        $this->contributor = EventContributor::where('event_id', $id)->get();
        $this->nama_event = $nama;
    }

    public function store()
    {
        $this->validate();
        try {
            ModelsEvent::create([
                'nama_event' => $this->nama,
                'tanggal_event' => $this->tanggal,
                'status' => 1,
            ]);
            $this->alert(
                'success',
                'Data berhasil ditambahkan'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menambahkan data'
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }

    public function update()
    {
        $this->validate();
        try {
            ModelsEvent::find($this->new_id)->update([
                'nama_event' => $this->nama,
                'tanggal_event' => $this->tanggal,
                'updated_at' => now()
            ]);
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Throwable $th) {
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
        $this->confirm('Apakah anda ingin event ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);
        $this->new_id = $id;
    }

    public function triggerUpdate($id, $status)
    {
        $this->confirm('Ubah status event ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'status',
            'onDismissed' => 'cancelled'
        ]);
        $this->new_id = $id;
        $this->status = $status;
    }

    public function status()
    {
        try {
            ModelsEvent::find($this->new_id)->update([
                'status' => $this->status
            ]);
            $this->alert(
                'success',
                'Status berhasil diubah'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah status'
            );
        }
    }

    public function confirmed()
    {
        try {
            ModelsEvent::destroy($this->new_id);
            $this->alert(
                'success',
                'Data berhasil dihapus'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menghapus data'
            );
        }
        $this->resetFields();
    }

    public function cancelled()
    {
        $this->resetFields();
    }
}
