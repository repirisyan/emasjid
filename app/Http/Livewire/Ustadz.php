<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Ustadz extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $new_id, $jabatan, $name, $created_at, $range_gaji, $TempatLahir, $TanggalLahir, $alamat, $kontak, $email, $JenisKelamin;
    public $readyToLoad = false;
    public $search = '';

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.ustadz', [
            'data_ustadz' => $this->readyToLoad ? User::where('role', '=', 4)->where('name', 'like', '%' . $this->search . '%')->simplePaginate(10) : [],
        ]);
    }
    protected $listeners = [
        'confirmed',
        'cancelled',
        'confirmedImam',
        'confirmedMuadzin',
        'confirmedKhotib',
    ];

    public function resetFields()
    {
        $this->resetExcept('readyToLoad');
    }

    public function updated()
    {
        $this->resetPage();
    }


    public function triggerConfirm($id)
    {
        $this->confirm('Nonaktifkan Jabatan ?', [
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

    public function triggerImam($id)
    {
        $this->confirm('Jadikan Imam ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmedImam',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
    }

    public function triggerMuadzin($id)
    {
        $this->confirm('Jadikan Muadzin ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmedMuadzin',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
    }

    public function triggerKhotib($id)
    {
        $this->confirm('Jadikan Khotib ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmedKhotib',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
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

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            User::find($this->new_id)->update([
                'role' => 2,
            ]);
            $this->alert(
                'success',
                'Jabatan berhasil dinonaktifkan'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'success',
                'Terjadi kesalahan saat mengubah status'
            );
        }
        $this->resetExcept('readyToLoad');
    }

    public function confirmedImam()
    {
        // Example code inside confirmed callback
        try {
            User::find($this->new_id)->update([
                'imam' => true,
            ]);
            $this->alert(
                'success',
                'Data imam berhasil ditambahkan'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'success',
                'Terjadi kesalahan saat mengubah status'
            );
        }
        $this->resetExcept('readyToLoad');
    }

    public function confirmedMuadzin()
    {
        // Example code inside confirmed callback
        try {
            User::find($this->new_id)->update([
                'muadzin' => true,
            ]);
            $this->alert(
                'success',
                'Data muadzin berhasil ditambahkan'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'success',
                'Terjadi kesalahan saat mengubah status'
            );
        }
        $this->resetExcept('readyToLoad');
    }

    public function confirmedKhotib()
    {
        // Example code inside confirmed callback
        try {
            User::find($this->new_id)->update([
                'khotib' => true,
            ]);
            $this->alert(
                'success',
                'Data khotib berhasil ditambahkan'
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
