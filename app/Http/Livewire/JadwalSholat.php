<?php

namespace App\Http\Livewire;

use App\Models\SholatJumat;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class JadwalSholat extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $imam_id, $khotib_id, $tanggal_kegiatan, $new_id, $readyToLoad;
    protected $rules = [
        'imam_id' => ['required'],
        'khotib_id' => ['required'],
        'tanggal_kegiatan' => ['required'],
    ];
    protected $listeners = [
        'confirmed',
        'cancelled'
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
        return view('livewire.jadwal-sholat', [
            'data_sholat' => $this->readyToLoad ? SholatJumat::with(['imam', 'khotib'])->simplePaginate(10) : [],
            'imam' => $this->readyToLoad ? User::where('imam', true)->select('id', 'name')->get() : [],
            'khotib' => $this->readyToLoad ? User::where('khotib', true)->select('id', 'name')->get() : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad');
    }

    public function store()
    {
        $this->validate();
        try {
            SholatJumat::create([
                'imam_id' => $this->imam_id,
                'khotib_id' => $this->khotib_id,
                'tanggal' => $this->tanggal_kegiatan,
            ]);
            $this->alert(
                'success',
                "Data Berhasil Disimpan"
            );
        } catch (\Throwable $e) {
            $this->alert(
                'error',
                "Data Gagal Disimpan"
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Hapus jadwal sholat ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled',
        ]);

        $this->new_id = $id;
    }

    public function edit($id, $tanggal, $imam, $khotib)
    {
        $this->new_id = $id;
        $this->tanggal_kegiatan = $tanggal;
        $this->imam_id = $imam;
        $this->khotib_id = $khotib;
    }

    public function update()
    {
        $this->validate();
        try {
            SholatJumat::find($this->new_id)->update([
                'imam_id' => $this->imam_id,
                'khotib_id' => $this->khotib_id,
                'tanggal' => $this->tanggal_kegiatan,
                'updated_at' => now(),
            ]);

            $this->alert(
                'success',
                "Data Berhasil Diubah"
            );
        } catch (\Exception $e) {
            dd($e);
            $this->alert(
                'error',
                "Data Gagal Disimpan"
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            SholatJumat::destroy($this->new_id);
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
        $this->resetExcept('readyToLoad');
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetExcept('readyToLoad');
    }
}
