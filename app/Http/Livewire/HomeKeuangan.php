<?php

namespace App\Http\Livewire;

use App\Models\DetailSaldo;
use App\Models\Keuangan;
use Livewire\Component;
use Livewire\WithPagination;

class HomeKeuangan extends Component
{
    use WithPagination;
    public $readyToLoad, $kategori, $tanggal, $keterangan, $nilai, $id_keuangan, $konfirmasi, $bulan, $tahun, $menu_saldo, $tahun_preview, $bulan_preview;
    protected $paginationTheme = 'bootstrap';
    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
        $this->kategori = 1;
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'kategori', 'menu_saldo', 'bulan', 'tahun');
    }

    public function render()
    {
        return view('livewire.home-keuangan', [
            'data' => $this->readyToLoad ? Keuangan::with('user')->whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->where('kategori', $this->kategori)->simplePaginate(10) : [],
            'data_saldo' => $this->readyToLoad && $this->menu_saldo ? DetailSaldo::whereYear('tanggal', $this->tahun)->simplePaginate(10) : [],
        ]);
    }

    public function filter()
    {
        //Function kosong untuk mentrigger inputan
    }

    public function detail_saldo($bulan, $tahun, $kategori)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->kategori = $kategori;
        $this->menu_saldo = false;
    }

    public function preview()
    {
        $this->validate([
            'tahun_preview' => 'digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'bulan_preview' => 'required|digits:2'
        ]);
        redirect('keuangan/laporan/' . $this->bulan_preview . '/' . $this->tahun_preview . '/preview');
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
