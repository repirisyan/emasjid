<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class HomeImamMuadzin extends Component
{
    use WithPagination;

    public $readyToLoad, $filter, $paginateLimit;

    public function mount()
    {
        $this->filter = 'imam';
        $this->paginateLimit = 6;
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function updated()
    {
        $this->paginateLimit = 6;
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.home-imam-muadzin', [
            'data' => $this->readyToLoad ? User::where($this->filter, true)->simplePaginate($this->paginateLimit) : [],
        ]);
    }
}
