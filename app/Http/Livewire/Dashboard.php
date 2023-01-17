<?php

namespace App\Http\Livewire;

use App\Models\Saldo;
use Livewire\Component;

class Dashboard extends Component
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
        return view('livewire.dashboard', [
            'saldo' => $this->readyToLoad ? Saldo::value('jumlah_saldo') : [],
        ]);
    }
}