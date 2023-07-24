<?php

namespace App\Http\Livewire\Pengurus;

use App\Models\Berita as ModelsBerita;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Image;

class Berita extends Component
{
    use LivewireAlert;
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $judul, $deskripsi, $temp_id, $thumbnail, $new_thumbnail, $visible, $search, $readyToLoad, $filter_status;
    public $tambah, $ubah;

    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    public function mount()
    {
        $this->tambah = false;
        $this->ubah = false;
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.pengurus.berita', [
            'beritas' => $this->readyToLoad ? ModelsBerita::when($this->search != null, function ($query) {
                return $query->where('judul', 'like', '%' . $this->search . '%');
            })->when($this->filter_status != null, function ($query) {
                return $query->where('status', $this->filter_status);
            })->where('kategori', '1')->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->simplePaginate(10) : [],
        ]);
    }
    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'search');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $data = ModelsBerita::where('id', $id)->first();
        $this->temp_id = $id;
        $this->judul = $data->judul;
        $this->deskripsi = $data->berita;
        $this->thumbnail = $data->thumbnail;
        $this->visible = $data->status;
    }

    public function store()
    {
        $this->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'thumbnail' => 'image|required',
            'visible' => 'required'
        ]);
        try {
            $filename = uniqid() . '.webp';
            ModelsBerita::create([
                'judul' => $this->judul,
                'berita' => $this->deskripsi,
                'user_id' => auth()->user()->id,
                'status' => $this->visible,
                'kategori' => 1,
                'thumbnail' => $filename,
            ]);
            $originalPath = public_path() . '/storage/berita/';
            $thumbnailImage = Image::make($this->thumbnail);
            $thumbnailImage = $thumbnailImage->encode('webp', 85);
            $thumbnailImage->resize(800, 533);
            $thumbnailImage->save($originalPath . $filename);
            $this->alert(
                'success',
                'Data berhasil disimpan'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->resetFields();
    }

    public function update()
    {
        $this->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'new_thumbnail' => 'nullable|image',
            'visible' => 'required'
        ]);
        try {
            if ($this->new_thumbnail != null) {
                Storage::delete('public/berita/' . $this->thumbnail);
                $filename = uniqid() . '.webp';
                $originalPath = public_path() . '/storage/berita/';
                $thumbnailImage = Image::make($this->new_thumbnail);
                $thumbnailImage = $thumbnailImage->encode('webp', 85);
                $thumbnailImage->resize(800, 533);
                $thumbnailImage->save($originalPath . $filename);
                $this->thumbnail = $filename;
            }
            ModelsBerita::find($this->temp_id)->update([
                'judul' => $this->judul,
                'berita' => $this->deskripsi,
                'user_id' => auth()->user()->id,
                'status' => $this->visible,
                'kategori' => 1,
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
        $this->resetFields();
    }

    public function triggerConfirm($id, $thumbnail)
    {
        $this->confirm('Hapus berita ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);

        $this->temp_id = $id;
        $this->thumbnail = $thumbnail;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            Storage::delete('public/berita/' . $this->thumbnail);
            ModelsBerita::destroy($this->temp_id);
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
