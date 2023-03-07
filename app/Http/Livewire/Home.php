<?php

namespace App\Http\Livewire;

use App\Models\Berita;
use App\Models\Event;
use App\Models\Galeri;
use App\Models\Kegiatan;
use App\Models\Saldo;
use App\Models\SholatJumat;
use Livewire\Component;

class Home extends Component
{

    public function render()
    {
        return view('livewire.home', [
            'beritas' => Berita::with('user')->where('status', true)->where('kategori', '1')->orderBy('created_at', 'desc')->limit(15)->get(),
            'kajians' => Berita::with('user')->where('status', true)->where('kategori', '2')->orderBy('created_at', 'desc')->limit(15)->get(),
            'galeris' => Galeri::where('kategori', '1')->limit(20)->orderBy('updated_at', 'desc')->get(),
            'events' => Event::where('status', 1)->orderBy('tanggal_event', 'desc')->get(),
            'data_sholat' => SholatJumat::with(['imam', 'khotib'])->whereDate('tanggal', '>=', date('Y-m-d'))->orderBy('tanggal', 'asc')->limit(5)->get(),
            'data_kajian' => Kegiatan::with('user')->where('jenis_kegiatan', '2')->whereDate('tanggal_kegiatan', '>=', date('Y-m-d'))->orderBy('tanggal_kegiatan', 'asc')->get(),
            'saldo' => Saldo::value('jumlah_saldo'),
        ]);
    }
}
