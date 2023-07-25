<?php

namespace App\Http\Livewire\Admin;

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

    public $readyToLoad, $created_at, $search, $filter_role, $filter_jabatan, $filter_status, $name, $status, $TempatLahir, $TanggalLahir, $alamat, $kontak, $email, $new_id, $JenisKelamin, $role, $jabatan;

    //Variable untuk mengatur status imam,muadzin dan khotib
    public $status_id, $temp_status;

    public function mount()
    {
        $this->search = '';
        $this->readyToLoad = false;
    }

    protected $listeners = [
        'confirmed',
        'cancelled',
        'confirmedStatus',
        'deactiveJabatan'
    ];


    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.admin.users', [
            'data_user' => $this->readyToLoad ? User::when($this->search != null, function ($query) {
                return $query->where('name', 'like', '%' . $this->search . '%');
            })->when($this->filter_role != null, function ($query) {
                return $query->orWhere('role', $this->filter_role);
            })->when($this->filter_jabatan != null, function ($query) {
                return $query->orWhere('id_jabatan', $this->filter_jabatan);
            })->when($this->filter_status != null, function ($query) {
                if ($this->filter_status == '1') {
                    return $query->orWhere('imam', true);
                } elseif ($this->filter_status == '2') {
                    return $query->orWhere('muadzin', true);
                } elseif ($this->filter_status == '3') {
                    return $query->orWhere('khotib', true);
                }
            })->where('role', '!=', '1')->simplePaginate(10) : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'search', 'filter_jabatan', 'filter_role', 'filter_status');
    }

    public function updatedSearch()
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
                'role' => $this->status,
                'password' => Hash::make('12345678'),
                'picture' => 'default_picture.webp',
                'imam' => false,
                'muadzin' => false,
                'khotib' => false,
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

    public function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'TanggalLahir' => ['required'],
            'TempatLahir' => ['required', 'max:255'],
            'JenisKelamin' => ['required'],
            'kontak' => ['required', 'digits_between:1,20'],
            'alamat' => ['required', 'max:255'],
            'status' => 'required',
        ]);
        try {
            User::find($this->new_id)->update([
                'name' => $this->name,
                'TanggalLahir' => $this->TanggalLahir,
                'TempatLahir' => $this->TempatLahir,
                'alamat' => $this->alamat,
                'kontak' => $this->kontak,
                'email' => $this->email,
                'JenisKelamin' => $this->JenisKelamin,
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
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function updateJabatan()
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
        $this->dispatchBrowserEvent('userUpdateJabatan');
        $this->emit('userUpdateJabatan');
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
        $this->JenisKelamin = $user->JenisKelamin;
        $this->created_at = $user->created_at;
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

    public function triggerDeactiveJabatan($id)
    {
        $this->confirm('Nonaktifkan Jabtan ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'deactiveJabatan',
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
    }

    public function deactiveJabatan()
    {
        try {
            User::find($this->new_id)->update([
                'id_jabatan' => null,
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

    // Function ubah status imam,muadzin & khotib
    public function triggerStatus($id, $status_id, $status)
    {
        $this->confirm('Ubah Status ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmedStatus',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
        $this->status_id = $status_id;
        $this->status = $status;
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

    public function confirmedStatus()
    {
        // Example code inside confirmed callback
        try {
            if ($this->status_id == '1') {
                User::find($this->new_id)->update([
                    'imam' => (!$this->status),
                ]);
            } elseif ($this->status_id == '2') {
                User::find($this->new_id)->update([
                    'muadzin' => (!$this->status),
                ]);
            } else {
                User::find($this->new_id)->update([
                    'khotib' => (!$this->status),
                ]);
            }
            $this->alert(
                'success',
                'Status berhasil diubah'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'success',
                'Terjadi kesalahan saat mengubah status'
            );
        }
        $this->resetFields();
    }

    public function cancelled()
    {
        $this->resetFields();
    }
}
