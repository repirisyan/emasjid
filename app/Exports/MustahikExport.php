<?php

namespace App\Exports;

use App\Models\Mustahik;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MustahikExport implements FromView
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        return view('admin.laporan.mustahik', [
            'data' => Mustahik::orderBy('desa', 'asc')->get()
        ]);
    }
}
