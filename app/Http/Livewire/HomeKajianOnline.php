<?php

namespace App\Http\Livewire;

use App\Models\Berita;
use Livewire\Component;

class HomeKajianOnline extends Component
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
        return view('livewire.home-kajian-online', [
            'data' => $this->readyToLoad ? Berita::with('user')->where('status', 1)->where('kategori', 2)->paginate(8) : [],
        ]);
    }
}
