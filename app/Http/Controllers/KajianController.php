<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class KajianController extends Controller
{
    public function edit($id)
    {
        $data = Berita::where('id', $id)->get();
        return view('admin.kajian_edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'thumbnail_old' => 'required',
        ]);
        try {
            if ($request->hasFile('thumbnail')) {
                Storage::delete('public/kajian_online/' . $request->thumbnail_old);
                $extension = $request->thumbnail->extension();
                $filename = now() . '.' . $extension;
                $request->thumbnail->storeAs('public', $filename);
                Berita::find($id)->update([
                    'judul' => $request->judul,
                    'berita' => $request->deskripsi,
                    'thumbnail' => $filename,
                    'updated_at' => now()
                ]);
            } else {
                Berita::find($id)->update([
                    'judul' => $request->judul,
                    'berita' => $request->deskripsi,
                    'updated_at' => now()
                ]);
            }
            Alert::toast('Data Kajian Berhasil Diubah', 'success');
            return redirect('kajian/online');
        } catch (\Exception $e) {
            Alert::toast('Terjadi kesalahan saat mengubah data', 'error');
            return redirect()->route('kajian_edit', $id);
        }
    }
}
