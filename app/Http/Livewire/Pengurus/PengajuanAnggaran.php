<?php

namespace App\Http\Livewire\Pengurus;

use App\Models\Keuangan;
use Illuminate\Database\Eloquent\Builder;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PengajuanAnggaran extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $readyToLoad, $tanggal, $keterangan, $nilai, $id_keuangan;

    protected $rules = [
        'tanggal' => 'required|date',
        'keterangan' => 'required',
        'nilai' => 'required|numeric|min:0'
    ];

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        $this->readyToLoad = false;
    }

    public function render()
    {
        return view('livewire.pengurus.pengajuan-anggaran', [
            'data' => $this->readyToLoad ? Keuangan::with('user')->where('kategori', 2)->where('user_id', auth()->user()->id)->orderBy('tanggal', 'desc')->simplePaginate(20) : [],
        ]);
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
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
            Keuangan::create([
                'user_id' => auth()->user()->id,
                'kategori' => 2,
                'tanggal' => $this->tanggal,
                'keterangan' => $this->keterangan,
                'nilai' => $this->nilai,
                'status' => 2,
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
        $data = Keuangan::where('id', $id)->first();
        $this->id_keuangan = $id;
        $this->keterangan = $data->keterangan;
        $this->nilai = $data->nilai;
        $this->tanggal = $data->tanggal;
    }

    public function update()
    {
        $this->validate();
        try {
            Keuangan::where('id', $this->id_keuangan)->update([
                'keterangan' => $this->keterangan,
                'nilai' => $this->nilai,
                'tanggal' => $this->tanggal,
            ]);
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
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
        $this->id_keuangan = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            Keuangan::destroy($this->id_keuangan);
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
        $this->resetExcept('readyToLoad');
    }

    public function cancelled()
    {
        $this->resetExcept('readyToLoad');
    }
}
