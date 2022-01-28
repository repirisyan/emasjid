<?php

namespace App\Http\Controllers;

use App\Models\ShobulQurban;
use \PDF;

class ShobulController extends Controller
{
    public $tahun;
    public function print($date, $hewan)
    {
        $this->tahun = $date;
        $data = ShobulQurban::with('user', 'hewan', 'master_hewan', 'qurban')->whereHas('hewan', function ($query) {
            $query->whereYear('created_at', $this->tahun);
        })->whereHas('qurban', function ($query) {
            $query->groupBy('antrian');
        })->where('master_hewan_id', $hewan)->whereNotIn('status', [0, 2])->sharedLock()->get();
        $pdf = PDF::loadView('admin.laporan.print_mudhohi', ['data' => $data, 'id_master_hewan' => $hewan])->setPaper('a4');
        return $pdf->stream();
    }

    public function download($date, $hewan)
    {
        $this->tahun = $date;
        $data = ShobulQurban::with('user', 'hewan', 'master_hewan', 'qurban')->whereHas('hewan', function ($query, $date) {
            $query->whereYear('created_at', $this->tahun);
        })->whereHas('qurban', function ($query) {
            $query->groupBy('antrian');
        })->where('master_hewan_id', $hewan)->whereNotIn('status', [0, 2])->sharedLock()->get();
        $pdf = PDF::loadView('admin.laporan.print_mudhohi', ['data' => $data, 'id_master_hewan' => $hewan])->setPaper('a4');
        return $pdf->download($date . '-laporan-mudhohi.pdf');
    }
}
