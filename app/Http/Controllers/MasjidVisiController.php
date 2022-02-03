<?php

namespace App\Http\Controllers;

use App\Models\ProfileMasjid;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MasjidVisiController extends Controller
{
    public function index()
    {
        $data = ProfileMasjid::select('visi_misi')->first();

        return view('admin.profile_masjid_visi_misi', compact('data'));
    }

    public function sejarah()
    {
        $data = ProfileMasjid::select('sejarah')->first();
        return view('admin.profile_masjid_sejarah', compact('data'));
    }

    public function update(Request $req)
    {
        try {
            ProfileMasjid::find(1)->update([
                'visi_misi' => $req->visi_misi
            ]);
            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('masjid.visi_misi');
        } catch (\Throwable $th) {
            Alert::toast('Terjadi kesalahan saat menyimpan data', 'error');
            return redirect()->route('masjid.visi_misi');
        }
    }

    public function update_sejarah(Request $req)
    {
        try {
            ProfileMasjid::find(1)->update([
                'sejarah' => $req->sejarah
            ]);
            Alert::toast('Data berhasil disimpan', 'success');
        } catch (\Throwable $th) {
            Alert::toast('Terjadi kesalahan saat menyimpan data', 'error');
        }
        return redirect('admin/settings/masjid/sejarah');
    }
}
