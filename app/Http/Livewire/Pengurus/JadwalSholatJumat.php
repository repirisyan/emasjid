<?php

namespace App\Http\Livewire\Pengurus;

use App\Models\SholatJumat;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class JadwalSholatJumat extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $imam_id, $khotib_id, $tanggal_kegiatan, $temp_id, $readyToLoad;

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
        return view('livewire.pengurus.jadwal-sholat-jumat', [
            'data' => $this->readyToLoad ? SholatJumat::with(['imam', 'khotib'])->orderBy('tanggal', 'desc')->simplePaginate(10) : [],
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
                "Data berhasil disimpan"
            );
        } catch (\Throwable $e) {
            $this->alert(
                'error',
                "Terjadi kesalahan saat menyimpan data"
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
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

        $this->temp_id = $id;
    }

    public function edit($id)
    {
        $data = SholatJumat::where('id', $id)->first();
        $this->temp_id = $id;
        $this->tanggal_kegiatan = $data->tanggal;
        $this->imam_id = $data->imam_id;
        $this->khotib_id = $data->khotib_id;
    }

    public function update()
    {
        $this->validate();
        try {
            SholatJumat::find($this->temp_id)->update([
                'imam_id' => $this->imam_id,
                'khotib_id' => $this->khotib_id,
                'tanggal' => $this->tanggal_kegiatan,
                'updated_at' => now(),
            ]);

            $this->alert(
                'success',
                "Data berhasil diubah"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                "Terjadi kesalahan saat mengubah data"
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
            SholatJumat::destroy($this->temp_id);
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
