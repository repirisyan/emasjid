<?php

namespace App\Http\Livewire\Landing;

use App\Models\Berita;
use Livewire\Component;

class KajianOnline extends Component
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
        return view('livewire.landing.kajian-online', [
            'data' => $this->readyToLoad ? Berita::with('user')->where('status', 1)->where('kategori', 2)->orderBy('created_at', 'desc')->paginate($this->paginateLimit) : [],
        ]);
    }
}
