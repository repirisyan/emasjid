<?php

use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\KeuanganController;
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
Route::get('home/berita/detail/{id}', [App\Http\Controllers\HomeBerita::class, 'detail']);

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

Route::middleware(['auth', 'is_user'])->group(function () {
    Route::get('/qurban/pendaftaran', function () {
        return view('pendaftaran_qurban');
    });
});

Route::middleware(['is_pengurus', 'auth'])->group(function () {
    Route::get('pengurus/event', function () {
        return view('admin.event');
    });
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
    Route::get('admin/settings/masjid', function () {
        return view('admin.profile_masjid');
    });
    Route::get('/users/pengurus', function () {
        return view('admin.pengurus');
    });
    Route::get('/users/ustadz', function () {
        return view('admin.ustadz');
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
