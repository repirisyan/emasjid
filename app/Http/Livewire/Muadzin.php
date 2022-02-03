<?php

namespace App\Http\Livewire;

use App\Models\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Muadzin extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $readyToLoad, $new_id, $search, $name, $created_at, $range_gaji, $TempatLahir, $TanggalLahir, $alamat, $kontak, $email, $JenisKelamin;
    protected $listeners = [
        'confirmed',
        'cancelled',
    ];
    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->search = '';
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function resetFields()
    {
        $this->resetExcept('readyToLoad');
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.muadzin', [
            'data' => $this->readyToLoad ? User::where('muadzin', true)->where('name', 'like', '%' . $this->search . '%')->simplePaginate(10) : [],
        ]);
    }

    public function detailUser($id)
    {
        $user = User::where('id', $id)->first();
        $this->TempatLahir = $user->TempatLahir;
        $this->TanggalLahir = $user->TanggalLahir;
        $this->alamat = $user->alamat;
        $this->kontak = $user->kontak;
        $this->range_gaji = $user->range_gaji;
        $this->email = $user->email;
        $this->JenisKelamin = $user->JenisKelamin;
        $this->name = $user->name;
        $this->created_at = $user->created_at;
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Nonaktifkan Muadzin ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmed',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            User::find($this->new_id)->update([
                'muadzin' => false,
            ]);
            $this->alert(
                'success',
                'Status berhasil dinonaktifkan'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'success',
                'Terjadi kesalahan saat mengubah status'
            );
        }
        $this->resetExcept('readyToLoad');
    }

    public function cancelled()
    {
        $this->resetExcept('readyToLoad');
    }
}
