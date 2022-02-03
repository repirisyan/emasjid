<?php

namespace App\Http\Livewire;

use App\Models\Kegiatan;
use Livewire\Component;
use Livewire\WithPagination;

class HomeKajianRutin extends Component
{
    use WithPagination;

    public $readyToLoad, $paginateLimit;

    public function mount()
    {
        $this->paginateLimit = 6;
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.home-kajian-rutin', [
            'data' => $this->readyToLoad ? Kegiatan::with('user')->where('jenis_kegiatan', 2)->simplePaginate($this->paginateLimit) : [],
        ]);
    }
}
