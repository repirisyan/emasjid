<?php

namespace App\Http\Livewire;

use App\Models\MasterHewan;
use App\Models\Qurban as ModelsQurban;
use App\Models\ShobulQurban;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Qurban extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $berat_timbangan, $id_qurban, $nama_hewan, $detail_shobul, $antrian, $id_master_hewan;
    public $readyToLoad = false;
    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        $this->id_master_hewan = 1;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.qurban', [
            'data_qurban' => $this->readyToLoad ? ModelsQurban::with('master_hewan', 'shobul_qurban')->where('master_hewan_id', $this->id_master_hewan)->whereHas('hewan', function ($query) {
                $query->whereYear('created_at', date('Y'));
            })->orderBy('antrian')->get() : [],
            'master_hewan' => $this->readyToLoad ? MasterHewan::all() : [],
        ]);
    }

    public function detailShobul($id)
    {
        $data = ShobulQurban::where('qurban_id', $id)->select('atasNama')->get();
        $this->detail_shobul = $data;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('id_master_hewan', 'readyToLoad');
    }

    public function buatAntrian()
    {
        $this->validate([
            'antrian' => 'required'
        ]);
        try {
            $cek = ModelsQurban::where('master_hewan_id', $this->id_master_hewan)->where('antrian', $this->antrian)->whereYear('created_at', date('Y'))->lockForUpdate()->count();
            if ($cek > 0) {
                $this->alert(
                    'error',
                    'Antrian telah digunakan'
                );
            } else {
                ModelsQurban::find($this->id_qurban)->update([
                    'antrian' => $this->antrian,
                    'updated_at' => now(),
                ]);
                $this->alert(
                    'success',
                    'Antrian berhasil dibuat'
                );
            }
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat membuat antrian'
            );
        }
        $this->dispatchBrowserEvent('antrian');
        $this->emit('antrian');
        $this->resetFields();
    }

    public function store()
    {
        $this->validate([
            'berat_timbangan' => ['required', 'numeric', 'min:1'],
        ]);
        try {
            ModelsQurban::find($this->id_qurban)->update(['berat_timbangan' => $this->berat_timbangan, 'status' => 2, 'updated_at' => now()]);
            $this->alert(
                'success',
                'Berat timbangan daging qurban berhasil ditambahkan'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah status'
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }
    public function triggerConfirm($id)
    {
        $this->confirm('Apa hewan qurban ini sudah disembelih?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Sudah',
            'cancelButtonText' =>  'Belum',
            'onConfirmed' => 'confirmed',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);

        $this->id_qurban = $id;
    }
    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            ModelsQurban::find($this->id_qurban)->update(['status' => 1, 'jumlah_disembelih' => 1, 'updated_at' => now(),]);
            $this->alert(
                'success',
                'Status hewan disembelih'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah status'
            );
        }
        $this->resetExcept('id_master_hewan', 'readyToLoad');
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetExcept('id_master_hewan', 'readyToLoad');
    }
}
