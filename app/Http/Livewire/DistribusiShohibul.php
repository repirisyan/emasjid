<?php

namespace App\Http\Livewire;

use App\Models\ShobulQurban;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DistribusiShohibul extends Component
{
    use WithPagination;
    use LivewireAlert;
    protected $paginationTheme = 'bootstrap';
    public $new_id, $permintaan, $id_shobul, $id_master_hewan, $atasNama, $readyToLoad, $search;
    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        $this->search = '';
        $this->readyToLoad = false;
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.distribusi-shohibul', [
            'data_shohibul' => $this->readyToLoad ? ShobulQurban::with('hewan', 'qurban', 'user', 'master_hewan')->where('status', 1)->where('atasNama', 'like', '%' . $this->search . '%')->orderBy('created_at', 'asc')->simplePaginate(7) : [],
        ]);
    }

    public function update()
    {
        $this->validate([
            'permintaan' => ['required', 'numeric', $this->id_master_hewan == 1 ? 'max:10' : 'max:5'],
            'atasNama' => ['required'],
        ]);
        try {
            ShobulQurban::find($this->id_shobul)->update([
                'permintaan_daging' => $this->permintaan,
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

    public function setUpdate($id, $id_master_hewan, $permintaan, $atasNama)
    {
        $this->permintaan = $permintaan;
        $this->atasNama = $atasNama;
        $this->id_shobul = $id;
        $this->id_master_hewan = $id_master_hewan;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad');
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

        $this->new_id = $id;
        $this->permintaan = $permintaan;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            ShobulQurban::find($this->new_id)->update(['status' => 3, 'permintaan_daging_confirm' => $this->permintaan]);
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
        $this->resetExcept('readyToLoad');
    }

    public function cancelled()
    {
        // Example code inside cancelled callback
        $this->resetExcept('readyToLoad');
    }
}
