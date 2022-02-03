<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class HomeKajian extends Controller
{
    public function detail($id)
    {
        $berita_terbaru = Berita::where('status', '1')->where('kategori', 2)->orderBy('created_at', 'desc')->limit(5)->get();
        $data = Berita::where('status', '1')->where('id', $id)->get();
        return view('home_kajian_detail', compact('data', 'berita_terbaru'));
    }
}
