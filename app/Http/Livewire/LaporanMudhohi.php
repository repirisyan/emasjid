<?php

namespace App\Http\Livewire;

use App\Models\MasterHewan;
use App\Models\ShobulQurban;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanMudhohi extends Component
{
    use WithPagination;
    public $id_master_hewan, $readyToLoad, $date;
    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->id_master_hewan = 1;
        $this->date = date('Y');
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function filterSearch($id_master_hewan, $date)
    {
        $this->date = $date;
        $this->id_master_hewan = $id_master_hewan;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.laporan-mudhohi', [
            'data' => $this->readyToLoad ? ShobulQurban::with('user', 'hewan', 'master_hewan', 'qurban')->whereHas('hewan', function ($query) {
                $query->whereYear('created_at', $this->date);
            })->whereHas('qurban', function ($query) {
                $query->groupBy('antrian');
            })->where('master_hewan_id', $this->id_master_hewan)->whereNotIn('status', [0, 2])->simplePaginate(20) : [],
            'master_hewan' => $this->readyToLoad ?  MasterHewan::all() : [],
        ]);
    }
}
