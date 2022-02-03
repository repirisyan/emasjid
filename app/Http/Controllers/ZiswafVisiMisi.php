<?php

namespace App\Http\Controllers;

use App\Exports\KeuanganZiswafExport;
use App\Models\ZiswafVisi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ZiswafVisiMisi extends Controller
{
    public function index()
    {
        $data = ZiswafVisi::select('visi_misi')->first();

        return view('admin.ziswaf_visi_misi', compact('data'));
    }

    public function update(Request $req)
    {
        try {
            ZiswafVisi::find(1)->update([
                'visi_misi' => $req->visi_misi
            ]);
            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('ziswaf.visi_misi');
        } catch (\Throwable $th) {
            Alert::toast('Terjadi kesalahan saat menyimpan data', 'error');
            return redirect()->route('ziswaf.visi_misi');
        }
    }

    public function export($dari, $sampai)
    {
        $exporter = app()->makeWith(KeuanganZiswafExport::class, compact('dari', 'sampai'));
        return $exporter->download('Laporan_keuangan_ziswaf-' . $dari . 'sampai' . $sampai . '.xlsx');
    }
}
