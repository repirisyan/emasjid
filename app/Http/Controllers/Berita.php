<?php

namespace App\Http\Controllers;

use App\Models\Berita as ModelsBerita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class Berita extends Controller
{
    public function edit($id)
    {
        $data = ModelsBerita::where('id', $id)->get();
        return view('admin.berita_edit', compact('data'));
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
                Storage::delete('public/berita/' . $request->thumbnail_old);
                $extension = $request->thumbnail->extension();
                $filename = now() . '.' . $extension;
                $request->thumbnail->storeAs('public', $filename);
                ModelsBerita::find($id)->update([
                    'judul' => $request->judul,
                    'berita' => $request->deskripsi,
                    'thumbnail' => $filename,
                    'updated_at' => now()
                ]);
            } else {
                ModelsBerita::find($id)->update([
                    'judul' => $request->judul,
                    'berita' => $request->deskripsi,
                    'updated_at' => now()
                ]);
            }
            Alert::toast('Data Berita Berhasil Diubah', 'success');
            return redirect('pengurus/berita');
        } catch (\Exception $e) {
            Alert::toast('Terjadi kesalahan saat mengubah data', 'error');
            return redirect()->route('berita_edit', $id);
        }
    }
}
