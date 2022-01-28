<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class Pengurus extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $new_id, $jabatan, $name, $created_at, $range_gaji, $TempatLahir, $TanggalLahir, $alamat, $kontak, $email, $JenisKelamin;
    public $readyToLoad = false;
    public $search = '';

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.pengurus', [
            'data_pengurus' => $this->readyToLoad ? User::where('role', 3)->where('name', 'like', '%' . $this->search . '%')->simplePaginate(10) : [],
        ]);
    }

    protected $listeners = [
        'confirmed',
        'cancelled',
        'confirmedP',
    ];

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad');
    }
    public function detailUser($id)
    {
        $user = User::where('id', $id)->first();
        $this->name = $user->name;
        $this->TempatLahir = $user->TempatLahir;
        $this->TanggalLahir = $user->TanggalLahir;
        $this->alamat = $user->alamat;
        $this->range_gaji = $user->range_gaji;
        $this->kontak = $user->kontak;
        $this->email = $user->email;
        $this->JenisKelamin = $user->JenisKelamin;
        $this->created_at = $user->created_at;
    }

    public function update()
    {
        $this->validate([
            'jabatan' => 'required',
        ]);
        try {
            User::find($this->new_id)->update([
                'id_jabatan' => $this->jabatan,
                'updated_at' => now(),
            ]);

            $this->alert(
                'success',
                'Berhasil menambahkan jabatan',
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }
    public function triggerConfirmPengurus($id)
    {
        $this->confirm('Nonaktifkan Pengurus dan Jabatan ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmedP',
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Nonaktifkan Jabatan ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
    }

    //Nonaktifkan Jabatan
    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            User::find($this->new_id)->update([
                'id_jabatan' => 0,
                'updated_at' => now(),
            ]);
            $this->alert(
                'success',
                'Jabatan berhasil dinonaktifkan'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah status'
            );
        }
        $this->resetExcept('readyToLoad');
    }

    //Nonaktifkan Kepengurusan
    public function confirmedP()
    {
        try {
            User::find($this->new_id)->update([
                'id_jabatan' => 0,
                'role' => 2,
                'updated_at' => now()
            ]);
            $this->alert(
                'success',
                'Data pengurus berhasil dinonaktifkan'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
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
