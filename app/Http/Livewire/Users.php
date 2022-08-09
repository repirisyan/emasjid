<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Users extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';

    public $readyToLoad, $created_at, $search, $name, $status, $TempatLahir, $range_gaji, $TanggalLahir, $alamat, $kontak, $email, $new_id, $JenisKelamin, $role;

    public function mount()
    {
        $this->search = '';
        $this->readyToLoad = false;
    }

    protected $listeners = [
        'confirmed',
        'cancelled',
        'confirmedImam',
        'confirmedMuadzin',
        'confirmedKhotib',
    ];


    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.users', [
            'data_user' => $this->readyToLoad ? User::where('role', 2)->where('name', 'like', '%' . $this->search . '%')->simplePaginate(10) : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad');
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function store()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'TanggalLahir' => ['required'],
            'TempatLahir' => ['required', 'max:255'],
            'JenisKelamin' => ['required'],
            'kontak' => ['required', 'digits_between:1,20', 'unique:users'],
            'alamat' => ['required', 'max:255'],
            'status' => 'required',
            'range_gaji' => 'required',
        ]);
        try {
            User::create([
                'name' => $this->name,
                'TanggalLahir' => $this->TanggalLahir,
                'TempatLahir' => $this->TempatLahir,
                'alamat' => $this->alamat,
                'kontak' => $this->kontak,
                'email' => $this->email,
                'JenisKelamin' => $this->JenisKelamin,
                'range_gaji' => $this->range_gaji,
                'role' => $this->status,
                'password' => Hash::make('12345'),
                'picture' => 'default_picture.png'
            ]);
            $this->alert(
                'success',
                "Data berhasil disimpan"
            );
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

    public function updateUser()
    {
        try {
            User::find($this->new_id)->update([
                'name' => $this->name,
                'TanggalLahir' => $this->TanggalLahir,
                'TempatLahir' => $this->TempatLahir,
                'alamat' => $this->alamat,
                'kontak' => $this->kontak,
                'email' => $this->email,
                'JenisKelamin' => $this->JenisKelamin,
                'range_gaji' => $this->range_gaji,
                'role' => $this->status,
            ]);
            $this->alert(
                'success',
                "Data user berhasil diubah"
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->dispatchBrowserEvent('userUbah');
        $this->emit('userUbah');
        $this->resetFields();
    }

    public function detailUser($id)
    {
        $user = User::where('id', $id)->first();
        $this->new_id = $user->id;
        $this->name = $user->name;
        $this->TempatLahir = $user->TempatLahir;
        $this->TanggalLahir = $user->TanggalLahir;
        $this->alamat = $user->alamat;
        $this->kontak = $user->kontak;
        $this->email = $user->email;
        $this->status = $user->role;
        $this->range_gaji = $user->range_gaji;
        $this->JenisKelamin = $user->JenisKelamin;
        $this->created_at = $user->created_at;
    }

    public function update()
    {
        $this->validate([
            'status' => ['required'],
        ]);
        try {
            User::find($this->new_id)->update([
                'role' => $this->status,
            ]);
            $this->alert(
                'success',
                "Data berhasil diubah"
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

    public function triggerConfirm($id)
    {
        $this->confirm('Hapus User ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmed',
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

    //Nonaktifkan Jabatan
    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            User::destroy($this->new_id);
            $this->alert(
                'success',
                'Data berhasil dihapus'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah status'
            );
        }
        $this->resetFields();
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
        $this->resetFields();
    }
}