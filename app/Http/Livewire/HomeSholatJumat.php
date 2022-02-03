<?php

namespace App\Http\Livewire;

use App\Models\SholatJumat;
use Livewire\Component;
use Livewire\WithPagination;

class HomeSholatJumat extends Component
{
    use WithPagination;

    public $readyToLoad;
    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->reayToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.home-sholat-jumat', [
            'data' => $this->readyToLoad ? SholatJumat::with(['imam', 'khotib'])->simplePaginate(10) : [],
        ]);
    }
}
