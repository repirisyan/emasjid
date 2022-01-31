<?php

namespace App\Http\Livewire;

use App\Models\Mustahik as ModelsMustahik;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Mustahik extends Component
{
    use LivewireAlert;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad, $search, $nama, $alamat, $desa, $kecamatan, $blok, $gender, $pekerjaan, $new_id;
    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    public $rules = [
        'nama' => 'required',
        'alamat' => 'required',
        'desa' => 'required',
        'kecamatan' => 'required',
        'blok' => 'required',
        'gender' => 'required',
        'pekerjaan' => 'required'
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
        return view('livewire.mustahik', [
            'data' => $this->readyToLoad ? ModelsMustahik::where('nama_lengkap', 'like', '%' . $this->search . '%')->simplePaginate(15) : [],
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
            ModelsMustahik::create([
                'nama_lengkap' => $this->nama,
                'alamat' => $this->alamat,
                'desa' => $this->desa,
                'kecamatan' => $this->kecamatan,
                'blok' => $this->blok,
                'gender' => $this->gender,
                'pekerjaan' => $this->pekerjaan
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

    public function edit($id)
    {
        $data = ModelsMustahik::find($id)->first();
        $this->new_id = $id;
        $this->nama = $data->nama_lengkap;
        $this->alamat = $data->alamat;
        $this->desa = $data->desa;
        $this->kecamatan = $data->kecamatan;
        $this->blok = $data->blok;
        $this->gender = $data->gender;
        $this->pekerjaan = $data->pekerjaan;
    }

    public function update()
    {
        $this->validate();
        try {
            ModelsMustahik::find($this->new_id)->update([
                'nama_lengkap' => $this->nama,
                'alamat' => $this->alamat,
                'desa' => $this->desa,
                'kecamatan' => $this->kecamatan,
                'blok' => $this->blok,
                'gender' => $this->gender,
                'pekerjaan' => $this->pekerjaan
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

    public function triggerConfirm($id)
    {
        $this->confirm('Apakah anda ingin data mustahik ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);
        $this->new_id = $id;
    }

    public function confirmed()
    {
        try {
            ModelsMustahik::destroy($this->new_id);
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
