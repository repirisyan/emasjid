<?php

namespace App\Http\Livewire;

use App\Models\Keuangan;
use App\Models\Saldo;
use Livewire\Component;

class Dashboard extends Component
{
    public $readyToLoad, $pemasukkan, $pengeluaran;

    public function mount()
    {
        $this->readyToLoad = false;

        $this->pemasukkan = json_encode(Keuangan::where('kategori', '1')->whereYear('tanggal', date('Y'))->where('status', '1')->selectRAW('month(tanggal) months, monthname(tanggal) month, SUM(nilai) as saldo')->groupBy('month', 'months')->orderBy('months', 'asc')->get(), JSON_PRETTY_PRINT);
        $this->pengeluaran = json_encode(Keuangan::where('kategori', '2')->whereYear('tanggal', date('Y'))->where('status', '1')->selectRAW('month(tanggal) months, monthname(tanggal) month, SUM(nilai) as total_pengeluaran')->groupBy('month', 'months')->orderBy('months', 'asc')->get(), JSON_PRETTY_PRINT);
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
