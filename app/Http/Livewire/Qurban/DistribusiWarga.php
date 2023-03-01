<?php

namespace App\Http\Livewire\Qurban;

use App\Models\Distribusi as ModelsDistribusi;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DistribusiWarga extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    public $nama, $jumlah, $temp_id, $progress, $old_progress, $status, $readyToLoad, $filter_status, $print_date;

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
        $this->print_date = date('Y');
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
        return view('livewire.qurban.distribusi-warga', [
            'data_distribusi' => $this->readyToLoad ? ModelsDistribusi::when($this->filter_status != null, function ($query) {
                return $query->where('status', $this->filter_status);
            })->whereYear('created_at', '=', date('Y'))->where('user_id', auth()->user()->id)->orderBy('nama', 'asc')->simplePaginate(50) : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'filter_status', 'print_date');
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
            if ($cek) {
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
        $data = ModelsDistribusi::where('id', $id)->first();
        $this->temp_id = $id;
        $this->jumlah = $data->jumlah;
        $this->old_progress = $data->progressDistribusi;
    }

    public function progressDistribusi()
    {
        $this->validate([
            'progress' => ['required', 'numeric', 'max:' . $this->jumlah - $this->old_progress],
        ]);
        try {
            ModelsDistribusi::where('id', $this->temp_id)->increment('progressDistribusi', $this->progress);
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
        $this->dispatchBrowserEvent('userProgress');
        $this->emit('userProgress');
        $this->resetFields();
    }

    public function update()
    {
        $this->validate();
        try {
            ModelsDistribusi::find($this->temp_id)->update(
                [
                    'jumlah' => $this->jumlah,
                    'nama' => $this->nama,
                    'updated_at' => now()
                ]
            );
            $this->alert(
                'success',
                "Data berhasil diubah"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function setData($id)
    {
        $data = ModelsDistribusi::where('id', $id)->select('nama', 'jumlah')->first();
        $this->nama = $data->nama;
        $this->jumlah = $data->jumlah;
        $this->temp_id = $id;
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Hapus data ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->temp_id = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        ModelsDistribusi::destroy($this->temp_id);
        $this->alert(
            'success',
            'Data berhasil dihapus'
        );
        $this->resetFields();
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetFields();
    }
}
