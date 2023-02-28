<?php

namespace App\Http\Livewire\Pengurus;

use App\Models\Galeri as ModelsGaleri;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Image;

class Galeri extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $readyToLoad, $temp_id, $thumbnail, $keterangan, $new_thumbnail;
    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    public function mount()
    {
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.pengurus.galeri', [
            'data' => $this->readyToLoad ? ModelsGaleri::where('kategori', 1)->orderBy('created_at', 'asc')->simplePaginate(20) : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad');
    }

    public function store()
    {
        $this->validate([
            'keterangan' => 'required',
            'thumbnail' => 'image|required',
        ]);
        try {
            $extension = $this->thumbnail->extension();
            $filename = now() . '.' . $extension;
            ModelsGaleri::create([
                'keterangan' => $this->keterangan,
                'kategori' => 1,
                'picture' => $filename
            ]);
            $originalPath = public_path() . '/storage/galeri/';
            $thumbnailImage = Image::make($this->thumbnail);
            $thumbnailImage->resize(800, 533);
            $thumbnailImage->save($originalPath . $filename);
            $this->alert(
                'success',
                'Data berhasil ditambahkan'
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

    public function edit($id)
    {
        $data = ModelsGaleri::where('id', $id)->first();
        $this->temp_id = $id;
        $this->keterangan = $data->keterangan;
        $this->thumbnail = $data->picture;
    }

    public function update()
    {
        try {
            if ($this->new_thumbnail != null) {
                Storage::delete('public/galeri/' . $this->thumbnail);
                $extension = $this->new_thumbnail->extension();
                $filename = now() . '.' . $extension;
                $originalPath = public_path() . '/storage/galeri/';
                $thumbnailImage = Image::make($this->new_thumbnail);
                $thumbnailImage->resize(800, 533);
                $thumbnailImage->save($originalPath . $filename);
                $this->thumbnail = $filename;
            }
            ModelsGaleri::find($this->temp_id)->update([
                'keterangan' => $this->keterangan,
                'picture' => $this->thumbnail,
                'updated_at' => now(),
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

    public function triggerConfirm($id, $thumbnail)
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
        $this->thumbnail = $thumbnail;
    }

    public function confirmed()
    {
        try {
            Storage::delete('public/galeri/' . $this->thumbnail);
            ModelsGaleri::destroy($this->temp_id);
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

    public function cancelled()
    {
        $this->resetFields();
    }
}
