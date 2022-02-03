<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class HomeUstadz extends Component
{
    use WithPagination;

    public $readyToLoad,$paginateLimit;

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
        return view('livewire.home-ustadz', [
            'data' => $this->readyToLoad ? User::where('role', 4)->simplePaginate($this->paginateLimit) : [],
        ]);
    }
}
