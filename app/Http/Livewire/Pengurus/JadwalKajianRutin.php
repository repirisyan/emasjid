<?php

namespace App\Http\Livewire\Pengurus;

use App\Models\Kegiatan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class JadwalKajianRutin extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $user_id, $tanggal_kegiatan, $nama_kegiatan, $temp_id, $readyToLoad;

    protected $rules = [
        'nama_kegiatan' => 'required',
        'user_id' => 'required',
        'tanggal_kegiatan' => 'required',
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
        return view('livewire.pengurus.jadwal-kajian-rutin', [
            'data' => $this->readyToLoad ? Kegiatan::with('user')->where('jenis_kegiatan', '2')->orderBy('tanggal_kegiatan', 'desc')->simplePaginate(10) : [],
            'data_ustadz' => $this->readyToLoad ? User::where('role', '4')->select('id', 'name', 'JenisKelamin')->get() : [],
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
                'jenis_kegiatan' => '2',
                'nama_kegiatan' => $this->nama_kegiatan,
                'created_at' => now(),
            ]);

            $this->alert(
                'success',
                "Data berhasil disimpan"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                "Terjadi kesalahan saat menyimpan data"
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }

    public function edit($id)
    {
        $kegiatan = Kegiatan::where('id', $id)->first();
        $this->nama_kegiatan = $kegiatan->nama_kegiatan;
        $this->temp_id = $id;
        $this->tanggal_kegiatan = $kegiatan->tanggal_kegiatan;
        $this->user_id = $kegiatan->user_id;
    }

    public function update()
    {
        $this->validate();
        try {
            Kegiatan::find($this->temp_id)->update([
                'nama_kegiatan' => $this->nama_kegiatan,
                'user_id' => $this->user_id,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'updated_at' => now(),
            ]);

            $this->alert(
                'success',
                "Data berhasil diubah"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                "Terjadi kesalahaan saat mengubah data"
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Hapus data ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->temp_id = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            Kegiatan::destroy($this->temp_id);
            $this->alert(
                'success',
                'Data berhasil dihapus'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                "Terjadi kesalahaan saat menghapus data"
            );
        }
        $this->resetFields();
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetExcept('readyToLoad');
    }
}
