<?php

namespace App\Http\Livewire\Admin;

use App\Models\ProfileMasjid as ModelsProfileMasjid;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Image;

class ProfileMasjid extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $visi_misi, $sejarah, $organisasi_thumbnail, $logo, $favicon;

    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    public function render()
    {
        return view('livewire.admin.profile-masjid', [
            'data' => ModelsProfileMasjid::where('id', 1)->first()
        ]);
    }

    public function update_visi()
    {
        $this->validate([
            'visi_misi' => 'required'
        ]);
        try {
            ModelsProfileMasjid::find(1)->update([
                'visi_misi' => $this->visi_misi
            ]);
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->reset('visi_misi');
    }

    public function update_sejarah()
    {
        $this->validate([
            'sejarah' => 'required'
        ]);
        try {
            ModelsProfileMasjid::find(1)->update([
                'sejarah' => $this->sejarah
            ]);
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->reset('sejarah');
    }

    public function update_organisasi()
    {
        $this->validate([
            'organisasi_thumbnail' => 'nullable|mimes:png'
        ]);
        try {
            if ($this->organisasi_thumbnail != null) {
                Storage::delete('public/struktur_organisasi/struktur_organisasi.png');
                $this->organisasi_thumbnail->storeAs('struktur_organisasi', 'struktur_organisasi.png');
            }
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->reset('organisasi_thumbnail');
        $this->emit('refreshComponent');
    }

    public function update_logo()
    {
        $this->validate([
            'logo' => 'nullable|mimes:png',
            'favicon' => 'nullable|mimes:ico'
        ]);

        try {
            if ($this->logo != null) {
                Storage::delete('public/logo/mosque.png');
                $filename = 'mosque.png';
                $originalPath = public_path() . '/storage/logo/';
                $thumbnailImage = Image::make($this->logo);
                $thumbnailImage->resize(100, 100);
                $thumbnailImage->save($originalPath . $filename);
            }
            if ($this->favicon != null) {
                Storage::delete('public/favicons/favicon.ico');
                $filename = 'favicon.ico';
                $originalPath = public_path() . '/storage/favicons/';
                $thumbnailImage = Image::make($this->favicon);
                $thumbnailImage->resize(100, 100);
                $thumbnailImage->save($originalPath . $filename);
            }
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->reset('logo', 'favicon');
        $this->emit('refreshComponent');
    }
}
