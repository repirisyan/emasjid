<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Berita as LivewireBerita;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class KajianOnline extends Component
{
    use WithPagination;
    use LivewireAlert;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $judul, $deskripsi, $thumbnail, $iteration, $new_id, $status, $search, $readyToLoad;

    public $rules = [
        'judul' => ['required'],
        'deskripsi' => ['required'],
        'thumbnail' => 'image|max:512',
    ];

    protected $listeners = [
        'confirmed',
        'cancelled',
        'publish',
    ];

    public function mount()
    {
        $this->search = '';
        $this->readyToLoad = false;
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
        return view('livewire.kajian-online', [
            'data' => $this->readyToLoad ? Berita::where('user_id', auth()->user()->id)->where('judul', 'like', '%' . $this->search . '%')->orderBy('created_at', 'desc')->simplePaginate(5) : [],
        ]);
    }
    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad');
    }

    public function edit($id)
    {
        $data = Berita::where('id', $id)->first();
        $this->judul = $data->judul;
        $this->deskripsi = $data->berita;
        $this->thumbnail = $data->thumbnail;
        $this->dispatchBrowserEvent('textBox');
        $this->emit('textBox');
    }

    public function save($status)
    {
        $this->validate();
        try {
            $extension = $this->thumbnail->extension();
            $filename = now() . '.' . $extension;
            $this->thumbnail->storeAs('public/kajian_online', $filename);
            Berita::create([
                'judul' => $this->judul,
                'berita' => $this->deskripsi,
                'user_id' => auth()->user()->id,
                'status' => $status,
                'kategori' => 2,
                'thumbnail' => $filename,
            ]);
            $this->flash('success', 'Data Berhasil Disimpan', [], 'pengurus/berita');
        } catch (\Exception $e) {
            $this->flash('error', 'Terjadi kesalahan saat menyimpan data', [], 'pengurus/berita');
        }
    }

    public function triggerConfirm($id, $thumbnail)
    {
        $this->confirm('Hapus kajian online ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
        $this->thumbnail = $thumbnail;
    }

    public function triggerStatus($id, $status)
    {
        $this->confirm('Lakukan perubahan status ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Tidak',
            'onConfirmed' => 'publish',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
        $this->status = $status;
    }
    public function publish()
    {
        try {
            Berita::find($this->new_id)->update([
                'status' => $this->status,
            ]);
            $this->alert(
                'success',
                'Status berhasil diubah'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->resetExcept('readyToLoad');
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            Storage::delete('public/kajian_online/' . $this->thumbnail);
            Berita::destroy($this->new_id);
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
        $this->resetExcept('readyToLoad');
    }

    public function cancelled()
    {
        $this->resetExcept('readyToLoad');
    }
}
