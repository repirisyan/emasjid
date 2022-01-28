<?php

namespace App\Http\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProfileMasjid extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $logo, $favicon;

    protected $listeners = [
        'logo',
        'cancelled',
        'favicon',
    ];

    public function render()
    {
        return view('livewire.profile-masjid');
    }

    public function triggerConfirm()
    {
        $this->confirm('Upload Logo ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Upload',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'logo',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);
    }

    public function triggerFav()
    {
        $this->confirm('Upload Favicon ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Upload',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'favicon',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);
    }

    public function logo()
    {
        try {
            $this->validate([
                'logo' => 'max:128|mimes:png|dimensions:min_width=50,min_height=50|dimensions:max_width=512,max_height=512'
            ]);
            $this->logo->storeAs('public/logo/', 'mosque.png');
            $this->reset();
            return redirect()->to('admin/settings/masjid');
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat upload file'
            );
            $this->reset();
        }
    }

    public function favicon()
    {
        try {
            $this->validate([
                'favicon' => 'max:25|mimes:ico|dimensions:min_width=30,min_height=30|dimensions:max_width=180,max_height=180'
            ]);
            $this->favicon->storeAs('public/favicons/', 'favicon.ico');
            $this->reset();
            return redirect()->to('admin/settings/masjid');
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat upload file'
            );
            $this->reset();
        }
    }

    public function cancelled()
    {
        $this->reset();
    }
}
