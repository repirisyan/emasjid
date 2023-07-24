<?php

namespace App\Http\Livewire\Pengurus;

use App\Models\Event as ModelsEvent;
use App\Models\EventContributor;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;
use Image;
use Livewire\WithFileUploads;

class Event extends Component
{
    use LivewireAlert;
    use WithPagination;
    use WithFileUploads;

    public $readyToLoad, $nama, $tanggal, $temp_id, $status, $filter_status, $contributor = [], $nama_event, $thumbnail, $new_thumbnail;

    public $nama_lengkap, $tanggal_lahir, $tempat_lahir, $jenis_kelamin, $no_hp, $alamat, $event_id, $temp_peserta_id;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'confirmed',
        'cancelled',
        'confirmDelete',
        'cancelDelete',
        'refreshComponent' => '$refresh',
        'status',
    ];

    public function mount()
    {
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'filter_status');
    }

    public function resetDaftar()
    {
        $this->resetValidation();
        $this->reset('nama_lengkap', 'tanggal_lahir', 'tempat_lahir', 'jenis_kelamin', 'no_hp', 'alamat', 'temp_peserta_id');
    }

    public function render()
    {
        return view('livewire.pengurus.event', [
            'data' => $this->readyToLoad ? ModelsEvent::when($this->filter_status != null, function ($query) {
                return $query->where('status', $this->filter_status);
            })->simplePaginate(25) : [],
        ]);
    }

    public function edit($id)
    {
        $data = ModelsEvent::where('id', $id)->first();
        $this->nama = $data->nama_event;
        $this->tanggal = $data->tanggal_event;
        $this->status = $data->status;
        $this->thumbnail = $data->thumbnail;
        $this->temp_id = $id;
    }

    public function contributor($id, $nama)
    {
        $this->event_id = $id;
        $this->contributor = EventContributor::where('event_id', $id)->get();
        $this->nama_event = $nama;
    }

    public function store()
    {
        $this->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
            'thumbnail' => 'image|nullable'
        ]);
        try {
            if ($this->thumbnail != null) {
                Storage::delete('public/event/' . $this->thumbnail);
                $filename = now() . '.webp';
                $originalPath = public_path() . '/storage/event/';
                $thumbnailImage = Image::make($this->thumbnail);
                $thumbnailImage = $thumbnailImage->encode('webp', 85);
                $thumbnailImage->resize(800, 533);
                $thumbnailImage->save($originalPath . $filename);
                $this->thumbnail = $filename;
            }

            ModelsEvent::create([
                'nama_event' => $this->nama,
                'tanggal_event' => $this->tanggal,
                'status' => $this->status,
                'thumbnail' => $this->thumbnail
            ]);
            $this->alert(
                'success',
                'Data berhasil ditambahkan'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menambahkan data'
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required',
            'tanggal' => 'required|date',
            'status' => 'required',
            'thumbnail' => 'image|nullable'
        ]);
        try {
            if ($this->new_thumbnail != null) {
                if ($this->thumbnail != null) {
                    Storage::delete('public/event/' . $this->thumbnail);
                }
                $filename = now() . '.webp';
                $originalPath = public_path() . '/storage/event/';
                $thumbnailImage = Image::make($this->new_thumbnail);
                $thumbnailImage = $thumbnailImage->encode('webp', 85);
                $thumbnailImage->resize(800, 533);
                $thumbnailImage->save($originalPath . $filename);
                $this->thumbnail = $filename;
            }

            ModelsEvent::find($this->temp_id)->update([
                'nama_event' => $this->nama,
                'tanggal_event' => $this->tanggal,
                'status' => $this->status,
                'thumbnail' => $this->thumbnail,
                'updated_at' => now()
            ]);
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
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function edit_peserta($id)
    {
        $this->temp_peserta_id = $id;
        $data = EventContributor::where('id', $id)->first();
        $this->nama_lengkap = $data->nama_lengkap;
        $this->tanggal_lahir = $data->tanggal_lahir;
        $this->tempat_lahir = $data->tempat_lahir;
        $this->jenis_kelamin = $data->jenis_kelamin;
        $this->no_hp = $data->no_hp;
        $this->alamat = $data->alamat;
    }

    public function update_peserta()
    {
        $this->validate([
            'nama_lengkap' => 'required',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required|numeric',
            'alamat' => 'required',
        ]);
        try {
            EventContributor::find($this->temp_peserta_id)->update([
                'nama_lengkap' => $this->nama_lengkap,
                'tanggal_lahir' => $this->tanggal_lahir,
                'tempat_lahir' => $this->tempat_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
            ]);
            $this->alert(
                'success',
                'Data peserta berhasil diubah'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->dispatchBrowserEvent('userDaftarUpdate');
        $this->emit('userDaftarUpdate');
        $this->emit('refreshComponent');
        $this->resetDaftar();
    }

    public function daftar()
    {
        $this->validate([
            'nama_lengkap' => 'required',
            'tanggal_lahir' => 'required|date',
            'tempat_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'no_hp' => 'required|numeric',
            'alamat' => 'required',
        ]);
        try {
            EventContributor::create([
                'nama_lengkap' => $this->nama_lengkap,
                'tanggal_lahir' => $this->tanggal_lahir,
                'tempat_lahir' => $this->tempat_lahir,
                'jenis_kelamin' => $this->jenis_kelamin,
                'no_hp' => $this->no_hp,
                'alamat' => $this->alamat,
                'event_id' => $this->event_id
            ]);
            $this->alert(
                'success',
                'Data peserta berhasil ditambahkan'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->contributor = EventContributor::where('event_id', $this->event_id)->get();
        $this->dispatchBrowserEvent('userDaftar');
        $this->emit('userDaftar');
        $this->resetDaftar();
        $this->emit('refreshComponent');
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Hapus data ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);
        $this->temp_id = $id;
    }

    public function triggerDeletePeserta($id)
    {
        $this->confirm('Hapus data ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmDelete',
            'onDismissed' => 'cancelDelete'
        ]);
        $this->temp_peserta_id = $id;
    }

    public function confirmed()
    {
        try {
            ModelsEvent::destroy($this->temp_id);
            $this->alert(
                'success',
                'Data berhasil dihapus'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menghapus data'
            );
        }
        $this->resetFields();
    }

    public function confirmDelete()
    {
        try {
            EventContributor::destroy($this->temp_peserta_id);
            $this->alert(
                'success',
                'Data perserta berhasil dihapus'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menghapus data'
            );
        }
        $this->reset('temp_peserta_id');
        $this->emit('refreshComponent');
    }

    public function cancelDelete()
    {
        $this->reset('temp_peserta_id');
    }

    public function cancelled()
    {
        $this->resetFields();
    }
}
