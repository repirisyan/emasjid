<?php

namespace App\Http\Livewire\Pengurus;

use App\Models\Mustahik as ModelsMustahik;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Mustahik extends Component
{
    use LivewireAlert;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $readyToLoad, $search, $nama, $alamat, $desa, $kecamatan, $blok, $gender, $pekerjaan, $temp_id;

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
        return view('livewire.pengurus.mustahik', [
            'data' => $this->readyToLoad ? ModelsMustahik::when($this->search != null, function ($query) {
                return $query->where('nama_lengkap', 'like', '%' . $this->search . '%');
            })->simplePaginate(30) : [],
        ]);
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'search');
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
                'Data berhasil disimpan'
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

        $data = ModelsMustahik::where('id', $id)->first();
        $this->temp_id = $id;
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
            ModelsMustahik::find($this->temp_id)->update([
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
        try {
            ModelsMustahik::destroy($this->temp_id);
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
