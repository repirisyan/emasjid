<?php

namespace App\Http\Livewire\Landing;

use App\Models\DetailSaldo;
use App\Models\Keuangan as ModelsKeuangan;
use Livewire\Component;
use Livewire\WithPagination;

class Keuangan extends Component
{
    use WithPagination;

    public $readyToLoad, $kategori, $bulan, $tahun, $menu_saldo;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'kategori' => 'required',
        'tanggal' => 'required|date',
        'keterangan' => 'required',
        'nilai' => 'required|numeric|min:0'
    ];

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
        //Kategori (Pemasukkan & Pengeluaran)
        $this->kategori = 1;
        $this->readyToLoad = false;
    }

    public function render()
    {
        return view('livewire.landing.keuangan', [
            'data' => $this->readyToLoad ? ModelsKeuangan::with('user')->whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->where('kategori', $this->kategori)->simplePaginate(30) : [],
            'data_saldo' => $this->readyToLoad && $this->menu_saldo ? DetailSaldo::whereYear('tanggal', $this->tahun)->simplePaginate(30) : [],
        ]);
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function detail_saldo($bulan, $tahun, $kategori)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->kategori = $kategori;
        $this->menu_saldo = false;
    }

    public function menu($menu)
    {
        $this->kategori = $menu;
        $this->bulan = date('m');
        $this->tahun = date('Y');
        $this->menu_saldo = false;
    }

    public function menu_saldo()
    {
        $this->kategori = null;
        $this->menu_saldo = true;
    }
}
