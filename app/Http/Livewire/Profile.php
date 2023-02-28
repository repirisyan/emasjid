<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithFileUploads;
use Image;

class Profile extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $name, $TempatLahir, $TanggalLahir, $alamat, $kontak, $updated_at, $email, $JenisKelamin, $role, $password, $password_confirmation, $photo, $old_pict;

    protected $listeners = [
        'confirmed',
        'refreshComponent' => '$refresh',
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
        $this->old_pict = auth()->user()->picture;
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


    public function update()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'TanggalLahir' => ['required'],
            'TempatLahir' => ['required', 'max:255'],
            'JenisKelamin' => ['required'],
            'alamat' => ['required', 'max:255'],
            'photo' => 'image|nullable'
        ]);
        try {
            if ($this->photo != null) {
                if ($this->old_pict != 'default.png') {
                    Storage::delete('public/profile/' . $this->old_pict);
                }
                $extension = $this->photo->extension();
                $filename = auth()->user()->id . '_' . now() . '.' . $extension;
                $originalPath = public_path() . '/storage/profile/';
                $thumbnailImage = Image::make($this->photo);
                $thumbnailImage->resize(100, 100);
                $thumbnailImage->save($originalPath . $filename);
                $this->photo = $filename;
            }
            User::find(auth()->user()->id)->update([
                'name' => $this->name,
                'TempatLahir' => $this->TempatLahir,
                'TanggalLahir' => $this->TanggalLahir,
                'alamat' => $this->alamat,
                'JenisKelamin' => $this->JenisKelamin,
                'picture' => $this->photo,
                'updated_at' => now(),
            ]);
            $this->old_pict = $this->photo;
            $this->alert(
                'success',
                "Profile berhasil diubah"
            );
            $this->emit('refreshComponent');
        } catch (\Exception $e) {
            $this->alert(
                'error',
                "Terjadi kesalahan saat mengubah data"
            );
        }
    }
}
