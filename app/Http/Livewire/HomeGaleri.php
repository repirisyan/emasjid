<?php

namespace App\Http\Livewire;

use App\Models\Galeri;
use Livewire\Component;
use Livewire\WithPagination;

class HomeGaleri extends Component
{
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

    public function resetFields()
    {
        $this->resetExcept('readyToLoad');
    }

    public function render()
    {
        return view('livewire.home-galeri', [
            'data' => $this->readyToLoad ? Galeri::where('kategori', 1)->orderBy('created_at', 'asc')->simplePaginate(8) : [],
        ]);
    }
}
