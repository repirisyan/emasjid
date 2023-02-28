<?php

namespace App\Http\Livewire\Qurban;

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

    public function updatingDate()
    {
        $this->resetPage();
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.qurban.laporan-distribusi', [
            'data' => $this->readyToLoad ? Distribusi::whereYear('created_at', $this->date)->simplePaginate(20) : [],
        ]);
    }
}
