<?php

namespace App\Http\Livewire\Ustad;

use App\Models\Berita;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Image;

class KajianOnline extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';

    public $judul, $deskripsi, $thumbnail, $new_thumbnail, $search, $temp_id, $visible, $readyToLoad, $filter_status;
    public $tambah, $ubah;


    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    public function mount()
    {
        $this->readyToLoad = false;
        $this->tambah = false;
        $this->ubah = false;
    }


    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.ustad.kajian-online', [
            'data' => $this->readyToLoad ? Berita::when($this->search != null, function ($query) {
                return $query->where('judul', 'like', '%' . $this->search . '%');
            })->where('kategori', '2')->when($this->filter_status != null, function ($query) {
                return $query->where('status', $this->filter_status);
            })->where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->simplePaginate(5) : [],
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
        $data = Berita::where('id', $id)->first();
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
            $extension = $this->thumbnail->extension();
            $filename = now() . '.' . $extension;
            Berita::create([
                'judul' => $this->judul,
                'berita' => $this->deskripsi,
                'user_id' => auth()->user()->id,
                'status' => $this->visible,
                'kategori' => 2,
                'thumbnail' => $filename,
            ]);
            $originalPath = public_path() . '/storage/kajian_online/';
            $thumbnailImage = Image::make($this->thumbnail);
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
                Storage::delete('public/kajian_online/' . $this->thumbnail);
                $extension = $this->new_thumbnail->extension();
                $filename = now() . '.' . $extension;
                $originalPath = public_path() . '/storage/kajian_online/';
                $thumbnailImage = Image::make($this->new_thumbnail);
                $thumbnailImage->resize(800, 533);
                $thumbnailImage->save($originalPath . $filename);
                $this->thumbnail = $filename;
            }
            Berita::find($this->temp_id)->update([
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
            Storage::delete('public/kajian_online/' . $this->thumbnail);
            Berita::destroy($this->temp_id);
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
