<?php

namespace App\Http\Controllers;

use App\Models\DetailSaldo;
use App\Models\Keuangan;
use PDF;

class KeuanganController extends Controller
{
    public function preview($bulan, $tahun)
    {
        $pemasukan = Keuangan::where('kategori', 1)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
        $pengeluaran = Keuangan::where('kategori', 2)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
        $detail_saldo = DetailSaldo::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->first();
        $pdf = PDF::loadView('admin.laporan.print_keuangan', ['pemasukan' => $pemasukan, 'pengeluaran' => $pengeluaran, 'detail_saldo' => $detail_saldo]);
        return $pdf->stream();
    }
}
