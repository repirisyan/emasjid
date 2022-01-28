<?php

namespace App\Http\Livewire;

use App\Models\Hewan;
use App\Models\MasterHewan;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class HewanQurban extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $nama, $tipe, $harga, $tahun, $new_id,  $master_id, $readyToLoad;

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
        $this->master_id = 1;
        $this->readyToLoad = false;
    }

    public function filterSearch($master_id)
    {
        $this->master_id = $master_id;
        $this->resetPage();
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.hewan-qurban', [
            'data_hewan' => $this->readyToLoad ? Hewan::with('master_hewan')->whereYear('created_at', date('Y'))->where('master_hewan_id', $this->master_id)->simplePaginate(10) : [],
            'data_master' => $this->readyToLoad ? MasterHewan::all() : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'master_id');
    }
    public function edit($id)
    {
        $data = Hewan::where('id', $id)->first();
        $this->new_id = $id;
        $this->tipe = $data->tipe;
        $this->harga = $data->harga;
        $this->master_id = $data->master_hewan_id;
        $this->tahun = Carbon::parse($data->created_at)->format('Y');
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
                'Data Hewan Berhasil Ditambahkan'
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
            Hewan::find($this->new_id)->update([
                'master_hewan_id' => $this->master_id,
                'tipe' => $this->tipe,
                'harga' => $this->harga,
                'updated_at' => now(),
            ]);
            $this->alert(
                'success',
                "Data Hewan Berhasil Diubah"
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Gagal mengubah data hewan'
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Apa anda yakin akan menghapus data ini ?', [
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
        try {
            Hewan::destroy($this->new_id);
            $this->alert(
                'success',
                'Data hewan berhasil dihapus'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Data hewan tidak dapat dihapus'
            );
        }
        $this->resetExcept('readyToLoad', 'master_id');
    }

    public function cancelled()
    {
        $this->resetExcept('readyToLoad', 'master_id');
    }
}
