<?php

namespace App\Http\Livewire;

use App\Models\Kegiatan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class JadwalKajian extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';
    public $user_id, $tanggal_kegiatan, $nama_kegiatan, $new_id, $readyToLoad;

    protected $rules = [
        'nama_kegiatan' => ['required'],
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
        return view('livewire.jadwal-kajian', [
            'data_kajian' => $this->readyToLoad ? Kegiatan::with('user')->where('jenis_kegiatan', '2')->simplePaginate(10) : [],
            'data_ustadz' => $this->readyToLoad ? User::where('role', '4')->select('id', 'name')->get() : [],
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
                "Data Berhasil Disimpan"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                "Data Gagal Disimpan"
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
        $this->new_id = $id;
        $this->tanggal_kegiatan = $kegiatan->tanggal_kegiatan;
        $this->user_id = $kegiatan->user_id;
    }

    public function update()
    {
        $this->validate();
        try {
            Kegiatan::find($this->new_id)->update([
                'nama_kegiatan' => $this->nama_kegiatan,
                'user_id' => $this->user_id,
                'tanggal_kegiatan' => $this->tanggal_kegiatan,
                'updated_at' => now(),
            ]);

            $this->alert(
                'success',
                "Data Berhasil Diubah"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                "Data Gagal Disimpan"
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Apa anda yakin akan menghapus data ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        Kegiatan::destroy($this->new_id);
        $this->resetExcept('readyToLoad');
        $this->alert(
            'success',
            'Data berhasil dihapus'
        );
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetExcept('readyToLoad');
    }
}
