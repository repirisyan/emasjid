<?php

namespace App\Http\Livewire;

use App\Models\Distribusi as ModelsDistribusi;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Distribusi extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    public $nama, $jumlah, $new_id, $progress, $new_progress, $status, $readyToLoad;

    public $rules = [
        'nama' => ['required'],
        'jumlah' => ['required', 'numeric', 'min:0'],
    ];

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        $this->readyToLoad = false;
        $this->status = 0;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function filterSearch($status)
    {
        $this->status = $status;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.distribusi', [
            'data_distribusi' => $this->readyToLoad ? ModelsDistribusi::whereYear('created_at', '=', date('Y'))->where('status', $this->status)->where('user_id', auth()->user()->id)->simplePaginate(10) : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'status');
    }

    public function store()
    {
        $this->validate();
        try {
            ModelsDistribusi::create([
                'nama' => $this->nama,
                'user_id' => auth()->user()->id,
                'jumlah' => $this->jumlah,
                'progressDistribusi' => 0,
                'status' => 0,
            ]);
            $this->alert(
                'success',
                "Data Distribusi berhasil disimpan"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->resetFields();
        $this->emit('userStore');
    }

    public function verified($id)
    {
        try {
            $cek = ModelsDistribusi::where('id', $id)->whereColumn('jumlah', 'progressDistribusi')->update(['status' => 1, 'updated_at' => now()]);
            if ($cek == true) {
                $this->alert(
                    'success',
                    "Data Distribusi berhasil terpenuhi"
                );
            } else {
                $this->alert(
                    'error',
                    'Progress distribusi belum selesai'
                );
            }
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
    }

    public function setProgress($id, $jumlah, $progress)
    {
        $this->new_id = $id;
        $this->jumlah = $jumlah;
        $this->new_progress = $progress;
    }

    public function progressDistribusi()
    {
        $this->validate([
            'progress' => ['required', 'numeric'],
        ]);
        try {
            if (($this->jumlah) >= ($this->new_progress + $this->progress)) {
                ModelsDistribusi::where('id', $this->new_id)->increment('progressDistribusi', $this->progress);
                $this->alert(
                    'success',
                    'Data progress berhasil diinputkan'
                );
            } else {
                $this->alert(
                    'error',
                    'Inputan Anda melebihi batas'
                );
            }
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi Kesalahan saat menginputkan data'
            );
        }
        $this->dispatchBrowserEvent('userProgress');
        $this->emit('userProgress');
        $this->resetFields();
    }

    public function update()
    {
        $this->validate();
        try {
            ModelsDistribusi::find($this->new_id)->update(['jumlah' => $this->jumlah, 'nama' => $this->nama, 'updated_at' => now()]);
            $this->alert(
                'success',
                "Data Distribusi berhasil diubah"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi Kesalahan saat mengubah data'
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function setData($id, $nama, $jumlah)
    {
        $this->nama = $nama;
        $this->jumlah = $jumlah;
        $this->new_id = $id;
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Hapus data distribusi ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        ModelsDistribusi::destroy($this->new_id);
        $this->alert(
            'success',
            'Data berhasil dihapus'
        );
        $this->resetExcept('readyToLoad', 'status');
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetExcept('readyToLoad', 'status');
    }
}
