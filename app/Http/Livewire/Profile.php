<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $name, $TempatLahir, $TanggalLahir, $alamat, $kontak, $updated_at, $email, $JenisKelamin, $role, $password, $password_confirmation, $photo;
    protected $rules = [
        'name' => ['required', 'string', 'max:255'],
        'TanggalLahir' => ['required'],
        'TempatLahir' => ['required', 'max:255'],
        'JenisKelamin' => ['required'],
        'alamat' => ['required', 'max:255'],
    ];

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->TempatLahir = auth()->user()->TempatLahir;
        $this->TanggalLahir = auth()->user()->TanggalLahir;
        $this->alamat = auth()->user()->alamat;
        $this->kontak = auth()->user()->kontak;
        $this->email = auth()->user()->email;
        $this->JenisKelamin = auth()->user()->JenisKelamin;
        $this->updated_at = auth()->user()->updated_at;
    }
    
    public function render()
    {
        return view('livewire.profile');
    }

    public function resetFields()
    {
        $this->password = '';
        $this->password_confirmation = '';
    }

    public function update_password()
    {
        $this->validate([
            'password' => ['required', 'confirmed'],
        ]);
        try {
            User::find(auth()->user()->id)->update([
                'password' => Hash::make($this->password),
                'updated_at' => now(),
            ]);
            $this->updated_at = auth()->user()->updated_at;
            $this->alert(
                'success',
                "Password Berhasil Diubah"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                "Terjadi Kesalahan Saat Mengubah Password"
            );
        }
        $this->resetFields();
        $this->emit('updatePassword');
    }

    public function change_picture()
    {
        $this->validate([
            'photo' => 'image|max:124', // 124 Kb Max
        ]);

        try {
            if (auth()->user()->picture != 'default_picture.png') {
                Storage::delete('public/profile/' . auth()->user()->picture);
            }
            $extension = $this->photo->extension();
            $filename = auth()->user()->id . '.' . $extension;
            $this->photo->storeAs('public/profile', $filename);
            User::find(auth()->user()->id)->update([
                'picture' => $filename,
                'updated_at' => now(),
            ]);
            return redirect()->to('admin/settings');
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengunggah foto'
            );
        }
        $this->reset('photo');
    }

    public function update()
    {
        $this->validate();
        try {
            User::find(auth()->user()->id)->update([
                'name' => $this->name,
                'TempatLahir' => $this->TempatLahir,
                'TanggalLahir' => $this->TanggalLahir,
                'alamat' => $this->alamat,
                'JenisKelamin' => $this->JenisKelamin,
                'updated_at' => now(),
            ]);
            $this->updated_at = auth()->user()->updated_at;
            $this->alert(
                'success',
                "Profile Berhasil Diubah"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                "Terjadi Kesalahan Saat Mengubah Profile"
            );
        }
    }
    public function triggerConfirm()
    {
        $this->confirm('Hapus foto profile ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'confirmed',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            Storage::delete('public/profile/' . auth()->user()->picture);
            User::find(auth()->user()->id)->update([
                'picture' => 'default_picture.png',
                'updated_at' => now()
            ]);
            return redirect()->to('admin/settings');
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menghapus foto'
            );
        }
    }

    public function cancelled()
    {
    }
}
