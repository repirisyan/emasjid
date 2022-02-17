<?php

namespace App\Http\Livewire;

use App\Models\Berita;
use App\Models\Kegiatan;
use App\Models\Saldo;
use App\Models\SholatJumat;
use Livewire\Component;

class Home extends Component
{
    public $readyToLoad = false;

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }
    public function render()
    {
        return view('livewire.home', [
            'data' => $this->readyToLoad ? Berita::orderBy('created_at', 'desc')->where('status', '1')->where('kategori', 1)->limit(5)->get() : [],
            'data_sholat' => $this->readyToLoad ? SholatJumat::with(['imam','khotib'])->whereDate('tanggal', '>=', date('Y-m-d'))->orderBy('tanggal', 'asc')->limit(5)->get() : [],
            'data_kajian' => $this->readyToLoad ? Kegiatan::with('user')->where('jenis_kegiatan', '2')->whereDate('tanggal_kegiatan', '>=', date('Y-m-d'))->orderBy('tanggal_kegiatan', 'asc')->limit(5)->get() : [],
            'saldo' => Saldo::value('jumlah_saldo'),
        ]);
    }
}
