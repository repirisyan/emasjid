<?php

namespace App\Http\Livewire;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Event extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $readyToLoad;

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
        return view('livewire.event', [
            'data' => Event::simplePaginate(15),
        ]);
    }
}
