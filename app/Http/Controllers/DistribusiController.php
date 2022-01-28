<?php

namespace App\Http\Controllers;

use App\Models\Distribusi;
use PDF;

class DistribusiController extends Controller
{
    public function print($date)
    {
        $data = Distribusi::with('user')->whereYear('created_at', $date)->sharedLock()->get();
        $pdf = PDF::loadView('admin.laporan.print_distribusi', ['data' => $data]);
        return $pdf->stream();
    }

    public function download($date)
    {
        $data = Distribusi::with('user')->whereYear('created_at', $date)->sharedLock()->get();
        $pdf = PDF::loadView('admin.laporan.print_distribusi', ['data' => $data]);
        return $pdf->download($date.'-laporan-distribusi.pdf');
    }
}
