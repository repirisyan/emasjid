<?php

namespace App\Http\Livewire;

use App\Models\Saldo;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'saldo' => Saldo::value('jumlah_saldo'),
        ]);
    }
}
