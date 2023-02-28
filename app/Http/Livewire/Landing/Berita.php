<?php

namespace App\Http\Livewire\Landing;

use App\Models\Berita as ModelsBerita;
use Livewire\Component;

class Berita extends Component
{
    public $readyToLoad, $paginateLimit;

    public function mount()
    {
        $this->readyToLoad = false;
        $this->paginateLimit = 6;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.landing.berita', [
            'data' => $this->readyToLoad ? ModelsBerita::with('user')->where('status', 1)->where('kategori', 1)->orderBy('created_at', 'desc')->paginate($this->paginateLimit) : [],
        ]);
    }
}
