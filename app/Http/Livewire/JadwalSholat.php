<?php

namespace App\Http\Livewire;

use App\Models\Kegiatan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class JadwalSholat extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $user_id, $tanggal_kegiatan, $new_id, $readyToLoad;
    protected $rules = [
        'user_id' => ['required'],
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
            'data_sholat' => $this->readyToLoad ? Kegiatan::with('user')->where('jenis_kegiatan', 1)->simplePaginate(10) : [],
            'data_ustadz' => $this->readyToLoad ? User::where('role', '4')->where('JenisKelamin', 'Laki-laki')->select('id', 'name')->get() : [],
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
            Kegiatan::create([
                'user_id' => $this->user_id,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'jenis_kegiatan' => '1',
                'nama_kegiatan' => 'Sholat Jumat',
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

    public function edit($id, $tanggal, $name)
    {
        $this->new_id = $id;
        $this->tanggal_kegiatan = $tanggal;
        $this->user_id = $name;
    }

    public function update()
    {
        $this->validate();
        try {
            Kegiatan::find($this->new_id)->update([
                'user_id' => $this->user_id,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
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
            Kegiatan::destroy($this->new_id);
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
