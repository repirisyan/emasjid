<?php

namespace App\Http\Controllers;

use App\Models\Berita;

class HomeBerita extends Controller
{
    public function detail($id)
    {
        $berita_terbaru = Berita::where('status','1')->orderBy('created_at','desc')->limit(5)->get();
        $data = Berita::where('status', '1')->where('id', $id)->get();
        return view('home_berita_detail', compact('data','berita_terbaru'));
    }
}
