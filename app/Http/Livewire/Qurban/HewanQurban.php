<?php

namespace App\Http\Livewire\Qurban;

use App\Models\Hewan;
use App\Models\MasterHewan;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class HewanQurban extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $nama, $tipe, $harga, $tahun, $temp_id,  $master_id, $filter_hewan, $readyToLoad;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'master_id' => ['required'],
        'tipe' => ['required'],
        'harga' => ['required', 'numeric', 'min:0'],
    ];

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        $this->readyToLoad = false;
    }

    public function updatingFilterHewan()
    {
        $this->resetPage();
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.qurban.hewan-qurban', [
            'data_hewan' => $this->readyToLoad ? Hewan::with('master_hewan')->when($this->filter_hewan != null, function ($query) {
                return $query->where('master_hewan_id', $this->filter_hewan);
            })->whereYear('created_at', date('Y'))->simplePaginate(20) : [],
            'data_master' => $this->readyToLoad ? MasterHewan::all() : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'filter_hewan');
    }
    public function edit($id)
    {
        $data = Hewan::where('id', $id)->first();
        $this->temp_id = $id;
        $this->tipe = $data->tipe;
        $this->harga = $data->harga;
        $this->master_id = $data->master_hewan_id;
        $this->tahun = date_format($data->created_at, 'Y');
    }
    public function store()
    {
        $this->validate();
        try {
            Hewan::create([
                'master_hewan_id' => $this->master_id,
                'tipe' => $this->tipe,
                'harga' => $this->harga,
            ]);
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
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }
    public function update()
    {
        $this->validate();
        try {
            Hewan::find($this->temp_id)->update([
                'master_hewan_id' => $this->master_id,
                'tipe' => $this->tipe,
                'harga' => $this->harga,
                'updated_at' => now(),
            ]);
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
        try {
            Hewan::destroy($this->temp_id);
            $this->alert(
                'success',
                'Data berhasil dihapus'
            );
        } catch (\Throwable $th) {
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
