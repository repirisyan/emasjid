<?php

namespace App\Http\Livewire\Qurban;

use App\Models\MasterHewan;
use App\Models\Qurban as ModelsQurban;
use App\Models\ShobulQurban;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Penyembelihan extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    public $readyToLoad, $filter_hewan, $berat_timbangan, $qurban_id, $detail_shobul, $antrian, $master_hewan_id;

    protected $listeners = [
        'confirmed',
        'cancelled'
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
        return view('livewire.qurban.penyembelihan', [
            'data_qurban' => $this->readyToLoad ? ModelsQurban::with(['master_hewan', 'shobul_qurban', 'hewan'])->when($this->filter_hewan != null, function ($query) {
                return $query->where('master_hewan_id', $this->filter_hewan);
            })->whereHas('hewan', function ($query) {
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
        $this->resetExcept('filter_hewan', 'readyToLoad');
    }

    public function set_data_antrian($qurban_id, $master_hewan_id)
    {
        $this->qurban_id = $qurban_id;
        $this->master_hewan_id = $master_hewan_id;
    }

    public function set_antrian()
    {
        //Need more advance validation
        $this->validate([
            'antrian' => 'required',
        ]);
        if (ModelsQurban::where('master_hewan_id', $this->master_hewan_id)->where('antrian', $this->antrian)->whereYear('created_at', date('Y'))->exists()) {
            return $this->alert(
                'warning',
                'Harap periksa kembali nomor antrian'
            );
        };
        try {
            ModelsQurban::find($this->qurban_id)->update([
                'antrian' => $this->antrian,
                'updated_at' => now(),
            ]);
            $this->alert(
                'success',
                'Antrian berhasil dibuat'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->dispatchBrowserEvent('antrian');
        $this->emit('antrian');
        $this->resetFields();
    }

    //Update berat timbangan daging qurban
    public function store()
    {
        $this->validate([
            'berat_timbangan' => ['required', 'numeric', 'min:1'],
        ]);
        try {
            ModelsQurban::find($this->qurban_id)->update(['berat_timbangan' => $this->berat_timbangan, 'status' => 2, 'updated_at' => now()]);
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
        $this->confirm('Hewan qurban sudah disembelih ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Sudah',
            'cancelButtonText' =>  'Belum',
            'onConfirmed' => 'confirmed',
            // 'onConfirmed' => ['confirmed', $id], you can pass argument with array
            'onDismissed' => 'cancelled'
        ]);

        $this->qurban_id = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            ModelsQurban::find($this->qurban_id)->update(
                [
                    'status' => 1,
                    'jumlah_disembelih' => 1,
                    'updated_at' => now(),
                ]
            );
            $this->alert(
                'success',
                'Status hewan telah disembelih'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah status'
            );
        }
        $this->resetFields();
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetFields();
    }
}
