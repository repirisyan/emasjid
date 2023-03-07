<?php

namespace App\Http\Livewire\Qurban;

use App\Models\Distribusi;
use App\Models\Produksi;
use App\Models\Qurban;
use App\Models\ShobulQurban;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Monitoring extends Component
{
    public $readyToLoad = false;

    protected $listeners = ['echo:refresh,RefreshComponent' => '$refresh'];

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function render()
    {
        return view('livewire.qurban.monitoring', [
            'data_monitoring' => $this->readyToLoad ? Qurban::join('master_hewans', 'qurbans.master_hewan_id', '=', 'master_hewans.id')
                ->select('master_hewans.nama', Qurban::raw('sum(jumlah) as jumlah_hewan, sum(jumlah_disembelih) as jumlah_sembelih, sum(berat_timbangan) as timbangan'))
                ->where('qurbans.status', '!=', 0)
                ->whereYear('qurbans.created_at', date('Y'))
                ->groupBy('master_hewans.id', 'master_hewans.nama')
                ->get() : [],
            'data_shobul' => $this->readyToLoad ? ShobulQurban::join('master_hewans', 'shobul_qurbans.master_hewan_id', '=', 'master_hewans.id')
                ->select('master_hewans.nama', ShobulQurban::raw('count(master_hewans.id) as jumlah_shobul, sum(permintaan_daging) as jumlah_permintaan, sum(permintaan_daging_confirm) as progress_permintaan'))
                ->where('shobul_qurbans.status', '=', 1)
                ->orWhere('shobul_qurbans.status', '=', 3)
                ->whereYear('shobul_qurbans.created_at', date('Y'))
                ->groupBy('master_hewans.id', 'master_hewans.nama')
                ->get() : [],
            'data_produksi' => $this->readyToLoad ? Produksi::with('master_hewan')->whereYear('created_at', date('Y'))->get() : [],
            'data_distribusi' => $this->readyToLoad ? Distribusi::whereYear('created_at', date('Y'))
                ->select(Distribusi::raw('sum(jumlah) as jumlah, sum(progressDistribusi) as progressDistribusi'), DB::raw('YEAR(created_at) year'))
                ->groupBy('year')
                ->get() : [],
        ]);
    }
}
