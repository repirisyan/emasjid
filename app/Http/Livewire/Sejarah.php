<?php

namespace App\Http\Livewire;

use App\Models\ProfileMasjid;
use Livewire\Component;

class Sejarah extends Component
{
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
        return view('livewire.sejarah', [
            'data' => $this->readyToLoad ? ProfileMasjid::select('sejarah')->first() : [],
        ]);
    }
}
