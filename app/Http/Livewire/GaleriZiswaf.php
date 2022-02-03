<?php

namespace App\Http\Livewire;

use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class GaleriZiswaf extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    public $readyToLoad, $new_id, $thumbnail, $keterangan, $old_file, $picture;
    protected $paginationTheme = 'bootstrap';
    public $rules = [
        'keterangan' => ['required'],
        'thumbnail' => 'image|max:512',
    ];

    protected $listeners = [
        'confirmed',
        'cancelled',
        'publish',
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
        return view('livewire.galeri-ziswaf', [
            'data' => $this->readyToLoad ? Galeri::where('kategori', 2)->orderBy('created_at', 'asc')->simplePaginate(8) : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad');
    }

    public function store()
    {
        $this->validate();
        try {
            $extension = $this->thumbnail->extension();
            $filename = 'ziswaf' . now() . '.' . $extension;
            $this->thumbnail->storeAs('public/galeri', $filename);
            Galeri::create([
                'keterangan' => $this->keterangan,
                'kategori' => 2,
                'picture' => $filename
            ]);
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
        $data = Galeri::where('id', $id)->first();
        $this->new_id = $id;
        $this->keterangan = $data->keterangan;
        $this->old_file = $data->picture;
    }

    public function update()
    {
        try {
            if ($this->thumbnail != null) {
                Storage::delete('public/galeri/' . $this->old_file);
                $extension = $this->thumbnail->extension();
                $filename = 'ziswaf' . now() . '.' . $extension;
                $this->thumbnail->storeAs('public/galeri', $filename);
            } else {
                $filename = $this->old_file;
            }
            Galeri::find($this->new_id)->update([
                'keterangan' => $this->keterangan,
                'picture' => $filename,
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
        $this->confirm('Apakah anda ingin menghapus foto ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
        $this->thumbnail = $thumbnail;
    }

    public function confirmed()
    {
        try {
            Storage::delete('public/galeri/' . $this->thumbnail);
            Galeri::destroy($this->new_id);
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
