<?php

namespace App\Http\Livewire;

use App\Models\KeuanganZiswaf;
use Livewire\Component;
use Livewire\WithPagination;

class HomeKeuanganZiswaf extends Component
{
    use WithPagination;

    public $readyToLoad, $dari, $sampai;
    public function mount()
    {
        $this->dari = date("Y-m-01");
        $this->sampai = date("Y-m-t");
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
        return view('livewire.home-keuangan-ziswaf', [
            'data' => $this->readyToLoad ? KeuanganZiswaf::whereBetween('tanggal', [$this->dari, $this->sampai])->simplePaginate(15) : []
        ]);
    }
}
