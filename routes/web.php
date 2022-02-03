<?php

use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\MustahikConctroller;
use App\Http\Controllers\ShobulController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/symlink', function () {
//     Artisan::call('storage:link');
// });

Route::get('/', function () {
    return view('welcome');
});
Route::get('home/qurban/monitoring', function () {
    return view('monitor_qurban_home');
})->name('home.monitoring_qurban');

Route::get('home/berita', function () {
    return view('home_berita');
});

Route::get('home/galeri', function () {
    return view('home_galeri');
});

Route::get('home/galeri/ziswaf', function () {
    return view('home_galeri_ziswaf');
});

Route::get('home/event', function () {
    return view('home_event');
});

Route::get('home/keuangan', function () {
    return view('home_keuangan');
});

Route::get('home/keuangan/ziswaf', function () {
    return view('home_keuangan_ziswaf');
});

Route::get('home/kontak', function () {
    return view('home_kontak');
});

Route::get('home/ustadz', function () {
    return view('home_ustadz');
});

Route::get('home/imam-muadzin', function () {
    return view('home_imam_muadzin');
});

Route::get('home/sholat-jumat', function () {
    return view('home_sholat_jumat');
});

Route::get('home/profile/visimisi', function () {
    return view('home_visimisi');
});

Route::get('home/ziswaf/visimisi', function () {
    return view('home_ziswaf_visimisi');
});

Route::get('home/profile/organisasi', function () {
    return view('home_organisasi');
});

Route::get('home/profile/sejarah', function () {
    return view('home_sejarah');
});

Route::get('home/kajian-rutin', function () {
    return view('home_kajian_rutin');
});

Route::get('home/kajian-online', function () {
    return view('home_kajian_online');
});

Route::get('home/berita/detail/{id}', [App\Http\Controllers\HomeBerita::class, 'detail']);
Route::get('home/kajian/detail/{id}', [App\Http\Controllers\HomeKajian::class, 'detail']);

Route::get('ziswaf/keuangan/{dari}/{sampai}/export', [App\Http\Controllers\ZiswafVisiMisi::class, 'export']);

Auth::routes(['register' => false]);

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('qurban/monitoring', function () {
        return view('monitor_qurban');
    });
    Route::get('admin/settings', function () {
        return view('profile');
    });
});

Route::middleware(['auth', 'kajian'])->group(function () {
    Route::get('kajian/online', function () {
        return view('admin.kajian_online');
    });
    Route::get('kajian/online/{id}/edit', [App\Http\Controllers\KajianController::class, 'edit'])->name('kajian_edit');
    Route::patch('kajian/online/{id}/update', [App\Http\Controllers\KajianController::class, 'update']);
});

Route::middleware(['auth', 'is_user'])->group(function () {
    Route::get('/qurban/pendaftaran', function () {
        return view('pendaftaran_qurban');
    });
});

Route::middleware(['is_pengurus', 'auth'])->group(function () {
    Route::get('ziswaf/galeri', function () {
        return view('admin.ziswaf_galeri');
    });
    Route::get('pengurus/event', function () {
        return view('admin.event');
    });
    Route::get('pengurus/kontak', function () {
        return view('admin.kontak');
    });
    Route::get('pengurus/mustahik', function () {
        return view('admin.mustahik');
    });
    Route::get('mustahik/export/', [MustahikConctroller::class, 'export']);
    Route::get('pengurus/galeri', function () {
        return view('admin.galeri');
    });
    Route::get('pengurus/berita', function () {
        return view('admin.berita');
    });
    Route::get('/pengurus/kegiatan/jumat', function () {
        return view('admin.jadwal_sholat');
    });
    Route::get('/pengurus/kegiatan/kajian', function () {
        return view('admin.kelola_kajian');
    });
    Route::get('/qurban/laporan/mudhohi', function () {
        return view('admin.laporan.mudhohi');
    });
    Route::get('/qurban/laporan/distribusi', function () {
        return view('admin.laporan.distribusi');
    });
    Route::get('keuangan/pengajuan', function () {
        return view('admin.keuangan.pengajuan_anggaran');
    });
    Route::get('/qurban/distribusi/laporan/{date}/print', [DistribusiController::class, 'print'])->name('print.distribusi');
    Route::get('/qurban/distribusi/laporan/{date}/download', [DistribusiController::class, 'download'])->name('download.distribusi');
    Route::get('/qurban/shobul/laporan/{date}/print/{hewan}', [ShobulController::class, 'print'])->name('print.shobul');
    Route::get('/qurban/shobul/laporan/{date}/download/{hewan}', [ShobulController::class, 'download'])->name('download.shobul');
    Route::get('pengurus/berita/{id}/edit', [App\Http\Controllers\Berita::class, 'edit'])->name('berita_edit');
    Route::patch('pengurus/berita/{id}/update', [App\Http\Controllers\Berita::class, 'update']);
});

Route::middleware(['is_admin', 'auth'])->group(function () {
    Route::get('/users', function () {
        return view('admin.kelola_akun');
    });
    Route::get('admin/settings/masjid/logo', function () {
        return view('admin.profile_masjid');
    });

    Route::get('admin/settings/masjid/struktur-organisasi', function () {
        return view('admin.profile_struktur_organisasi');
    });
    Route::get('admin/settings/masjid/visimisi', [App\Http\Controllers\MasjidVisiController::class, 'index'])->name('masjid.visi_misi');
    Route::get('admin/settings/masjid/sejarah', [App\Http\Controllers\MasjidVisiController::class, 'sejarah']);
    Route::post('admin/settings/masjid/visimisi/update', [App\Http\Controllers\MasjidVisiController::class, 'update']);
    Route::post('admin/settings/masjid/sejarah/update', [App\Http\Controllers\MasjidVisiController::class, 'update_sejarah']);
    Route::get('ziswaf/visimisi', [App\Http\Controllers\ZiswafVisiMisi::class, 'index'])->name('ziswaf.visi_misi');
    Route::post('ziswaf/visimisi/update', [App\Http\Controllers\ZiswafVisiMisi::class, 'update']);
    Route::get('/users/pengurus', function () {
        return view('admin.pengurus');
    });
    Route::get('/users/ustadz', function () {
        return view('admin.ustadz');
    });
    Route::get('/users/imam', function () {
        return view('admin.imam');
    });
    Route::get('/users/khotib', function () {
        return view('admin.khotib');
    });
    Route::get('/users/muadzin', function () {
        return view('admin.muadzin');
    });
});

Route::middleware(['auth', 'is_ketua'])->group(function () {
    Route::get('keuangan/pengajuan/konfirmasi', function () {
        return view('admin.keuangan.konfirmasi_pengajuan');
    });
});

Route::middleware(['is_bendahara', 'auth'])->group(function () {
    Route::get('/pengurus/hewan_qurban', function () {
        return view('admin.hewan_qurban');
    });
    Route::get('/ziswaf/keuangan', function () {
        return view('admin.keuangan.ziswaf_keuangan');
    });
    Route::get('/pengurus/qurban/pembayaran', function () {
        return view('admin.pembayaran');
    });
    Route::get('/qurban/mudhohi/laporan/sapi', function () {
        return view('admin.laporan.mudhohi_sapi');
    });

    Route::get('keuangan/laporan/{bulan}/{tahun}/preview', [KeuanganController::class, 'preview']);
});

Route::get('keuangan/laporan', function () {
    return view('admin.keuangan.laporan_keuangan');
})->middleware('laporan_keuangan');

Route::middleware(['is_distribusi', 'auth'])->group(function () {
    Route::get('/qurban/distribusi', function () {
        return view('admin.distribusi');
    });
    Route::get('/qurban/permintaan', function () {
        return view('admin.distribusi_shohibul');
    });
});

Route::middleware(['is_produksi', 'auth'])->group(function () {

    Route::get('/pengurus/produksi/penyembelihan', function () {
        return view('admin.penyembelihan');
    });
    Route::get('/pengurus/produksi/pembungkusan', function () {
        return view('admin.pembungkusan');
    });
});
