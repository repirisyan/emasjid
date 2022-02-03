<?php

namespace App\Http\Livewire;

use App\Models\Berita;
use Livewire\Component;

class HomeBerita extends Component
{
    public $readyToLoad = false;

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.home-berita', [
            'data' => $this->readyToLoad ? Berita::with('user')->where('status', 1)->where('kategori', 1)->paginate(8) : [],
        ]);
    }
}
