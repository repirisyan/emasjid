<?php

namespace App\Http\Controllers;

use App\Exports\MustahikExport;
use Maatwebsite\Excel\Facades\Excel;

class MustahikConctroller extends Controller
{
    public function export()
    {
        return Excel::download(new MustahikExport, 'mustahik.xlsx');
    }
}
