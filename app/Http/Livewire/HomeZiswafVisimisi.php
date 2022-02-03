<?php

namespace App\Http\Livewire;

use App\Models\ZiswafVisi;
use Livewire\Component;

class HomeZiswafVisimisi extends Component
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
        return view('livewire.home-ziswaf-visimisi', [
            'data' => $this->readyToLoad ? ZiswafVisi::select('visi_misi')->first() : []
        ]);
    }
}
