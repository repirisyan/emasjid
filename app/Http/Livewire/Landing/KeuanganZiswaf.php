<?php

namespace App\Http\Livewire\Landing;

use App\Models\KeuanganZiswaf as ModelsKeuanganZiswaf;
use Livewire\Component;
use Livewire\WithPagination;

class KeuanganZiswaf extends Component
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
        return view('livewire.landing.keuangan-ziswaf', [
            'data' => $this->readyToLoad ? ModelsKeuanganZiswaf::whereBetween('tanggal', [$this->dari, $this->sampai])->simplePaginate(15) : []
        ]);
    }
}
