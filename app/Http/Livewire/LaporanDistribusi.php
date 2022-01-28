<?php

namespace App\Http\Livewire;

use App\Models\Distribusi;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanDistribusi extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $readyToLoad, $date;

    public function mount()
    {
        $this->readyToLoad = false;
        $this->date = date('Y');
    }

    public function filterSearch($date)
    {
        $this->date = $date;
        $this->resetPage();
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.laporan-distribusi', [
            'data' => $this->readyToLoad ? Distribusi::whereYear('created_at', $this->date)->simplePaginate(20) : [],
        ]);
    }
}
