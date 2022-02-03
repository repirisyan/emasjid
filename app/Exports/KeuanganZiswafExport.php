<?php

namespace App\Exports;

use App\Models\KeuanganZiswaf;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class KeuanganZiswafExport implements FromView
{
    use Exportable;

    protected $dari;
    protected $sampai;
    public function __construct($dari, $sampai)
    {
        $this->dari = $dari;
        $this->sampai = $sampai;
    }

    public function view(): View
    {
        return view('admin.keuangan.keuangan_ziswaf_export', [
            'data' => KeuanganZiswaf::whereBetween('tanggal', [$this->dari, $this->sampai])->get()
        ]);
    }
}
