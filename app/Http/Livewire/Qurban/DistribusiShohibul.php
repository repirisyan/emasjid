<?php

namespace App\Http\Livewire\Qurban;

use App\Models\MasterHewan;
use App\Models\ShobulQurban;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DistribusiShohibul extends Component
{
    use WithPagination;
    use LivewireAlert;

    protected $paginationTheme = 'bootstrap';

    public $temp_id, $permintaan_daging, $shohibul_id, $master_hewan_id, $atasNama, $readyToLoad, $search, $print_master_hewan, $print_date;

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        $this->readyToLoad = false;
        $this->print_date = date('Y');
        $this->print_master_hewan = '1';
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.qurban.distribusi-shohibul', [
            'data_shohibul' => $this->readyToLoad ? ShobulQurban::with(['hewan', 'qurban', 'user', 'master_hewan'])->when($this->search != null, function ($query) {
                return $query->where('atasNama', 'like', '%' . $this->search . '%');
            })->where('status', 1)->orderBy('created_at', 'asc')->simplePaginate(50) : [],
            'data_master' => $this->readyToLoad ? MasterHewan::all() : []
        ]);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function update()
    {
        $this->validate([
            'permintaan_daging' => ['required', 'numeric', $this->master_hewan_id == 1 ? 'max:10' : 'max:5'],
            'atasNama' => ['required'],
        ]);
        try {
            ShobulQurban::find($this->shohibul_id)->update([
                'permintaan_daging' => $this->permintaan_daging,
                'atasNama' => $this->atasNama,
                'updated_at' => now()
            ]);
            $this->alert(
                'success',
                'Data Telah diubah'
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

    public function setUpdate($id)
    {
        $data = ShobulQurban::with(['master_hewan'])->where('id', $id)->first();
        $this->permintaan_daging = $data->permintaan_daging;
        $this->atasNama = $data->atasNama;
        $this->shohibul_id = $id;
        $this->master_hewan_id = $data->master_hewan->id;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'search', 'print_master_hewan', 'print_date');
    }

    public function triggerConfirm($id, $permintaan)
    {
        $this->confirm('Konfirmasi permintaan daging ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->temp_id = $id;
        $this->permintaan_daging = $permintaan;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            ShobulQurban::find($this->temp_id)->update(['status' => 3, 'permintaan_daging_confirm' => $this->permintaan_daging]);
            $this->alert(
                'success',
                'Data permintaan shohibul berhasil dikonfirmasi'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat melakukan konfirmasi'
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
