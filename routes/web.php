<?php

use App\Exports\KeuanganZiswafExport;
use App\Exports\MustahikExport;
use App\Models\Berita;
use App\Models\DetailSaldo;
use App\Models\Distribusi;
use App\Models\Galeri;
use App\Models\Keuangan;
use App\Models\ProfileMasjid;
use App\Models\ShobulQurban;
use App\Models\ZiswafVisiMisi;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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

Route::group(['prefix' => 'landing'], function () {
    Route::get('qurban/monitoring', function () {
        return view('landing.monitoring_qurban');
    })->name('landing.monitoring_qurban');

    Route::get('berita', function () {
        return view('landing.berita');
    })->name('landing.berita');

    Route::get('keuangan', function () {
        return view('landing.keuangan');
    })->name('landing.keuangan');

    Route::get('kajian-online', function () {
        return view('landing.kajian_online');
    })->name('landing.kajian_online');

    Route::get('galeri', function () {
        $data = Galeri::where('kategori', '1')->get();
        return view('landing.galeri', compact('data'));
    })->name('landing.galeri');

    Route::get('tentang-kami', function () {
        $data = ProfileMasjid::select('visi_misi', 'sejarah')->first();
        return view('landing.profile_masjid', compact('data'));
    })->name('landing.profile_masjid');

    Route::get('ziswaf', function () {
        $galeris = Galeri::where('kategori', '2')->get();
        $data = ZiswafVisiMisi::first();
        return view('landing.ziswaf', compact('galeris', 'data'));
    })->name('landing.ziswaf');
});

Route::get('detail/{id}', function ($id) {
    $data = Berita::where('status', '1')->where('id', $id)->get();
    return view('landing.detail', compact('data'));
})->name('landing.detail');

Route::get('ziswaf/keuangan/{dari}/{sampai}/export', function ($dari, $sampai) {
    $exporter = app()->makeWith(KeuanganZiswafExport::class, compact('dari', 'sampai'));
    return $exporter->download('Laporan_keuangan_ziswaf-' . $dari . 'sampai' . $sampai . '.xlsx');
})->name('keuangan_ziswaf.export');

//Public Print
Route::get('keuangan/laporan/{bulan}/{tahun}/preview', function ($bulan, $tahun) {
    $pemasukan = Keuangan::where('kategori', 1)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
    $pengeluaran = Keuangan::where('kategori', 2)->whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->get();
    $detail_saldo = DetailSaldo::whereMonth('tanggal', $bulan)->whereYear('tanggal', $tahun)->first();
    $pdf = PDF::loadView('bendahara.print_keuangan', ['pemasukan' => $pemasukan, 'pengeluaran' => $pengeluaran, 'detail_saldo' => $detail_saldo]);
    return $pdf->stream();
})->name('print.laporan_keuangan');

//Admin Panel Zone

Auth::routes(['register' => false]);

Route::middleware(['auth', 'kajian'])->group(function () {
    Route::get('kajian/online', function () {
        return view('ustad.kajian_online');
    });
});

Route::middleware(['is_bendahara', 'auth'])->group(function () {
    Route::get('/ziswaf/keuangan', function () {
        return view('ziswaf.ziswaf_keuangan');
    });
});


Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('settings', function () {
        return view('profile');
    });

    Route::get('qurban/monitoring', function () {
        return view('qurban.monitor_qurban');
    });

    Route::group(['middleware' => 'can:admin', 'prefix' => 'admin'], function () {
        Route::get('kelola-user', function () {
            return view('admin.kelola_users');
        })->name('admin.users');
        Route::get('profile-masjid', function () {
            return view('admin.profile_masjid');
        })->name('admin.profile_masjid');
    });

    Route::group(['middleware' => ['can:pengurus'], 'prefix' => 'pengurus'], function () {
        //Mustahik
        Route::get('mustahik', function () {
            return view('pengurus.mustahik');
        });
        Route::get('mustahik/export/', function () {
            return Excel::download(new MustahikExport, 'mustahik.xlsx');
        });

        //Ziswaf
        Route::get('ziswaf/galeri', function () {
            return view('pengurus.ziswaf_galeri');
        })->name('galeri.ziswaf');

        Route::get('ziswaf/visi-misi', function () {
            return view('ziswaf.visi_misi');
        })->name('ziswaf.visi_misi');

        //Informasi
        Route::get('berita', function () {
            return view('pengurus.berita');
        });

        //Kegiatan
        Route::get('event', function () {
            return view('pengurus.event');
        });
        Route::get('galeri', function () {
            return view('pengurus.galeri');
        });
        Route::get('kegiatan/jumat', function () {
            return view('pengurus.jadwal_sholat_jumat');
        });
        Route::get('kegiatan/kajian', function () {
            return view('pengurus.jadwal_kajian_rutin');
        });

        //Keuangan
        Route::get('keuangan/pengajuan', function () {
            return view('pengurus.pengajuan_anggaran');
        })->name('pengajuan_anggaran');
    });

    Route::group(['middleware' => 'can:keuangan', 'prefix' => 'keuangan'], function () {
        Route::get('laporan', function () {
            return view('bendahara.laporan_keuangan');
        });
    });

    Route::group(['middleware' => 'can:bendahara', 'prefix' => 'qurban'], function () {
        Route::get('hewan_qurban', function () {
            return view('qurban.hewan_qurban');
        })->name('qurban.hewan_qurban');
        Route::get('konfirmasi-pembayaran', function () {
            return view('qurban.konfirmasi_pembayaran');
        })->name('qurban.konfirmasi_pembayaran');
    });

    Route::group(['middleware' => 'can:ketua', 'prefix' => 'keuangan'], function () {
        Route::get('pengajuan/konfirmasi', function () {
            return view('ketua.konfirmasi_pengajuan_anggaran');
        });
    });

    Route::group(['middleware' => 'can:jemaah', 'prefix' => 'qurban'], function () {
        Route::get('pendaftaran', function () {
            return view('qurban.pendaftaran');
        })->name('qurban.pendaftaran');
    });

    Route::group(['middleware' => 'can:produksi', 'prefix' => 'qurban'], function () {
        Route::get('penyembelihan', function () {
            return view('qurban.penyembelihan');
        })->name('qurban.penyembelihan');

        Route::get('pembungkusan', function () {
            return view('qurban.pembungkusan');
        })->name('qurban.pembungkusan');
    });

    Route::group(['middleware' => 'can:distribusi', 'prefix' => 'qurban'], function () {
        Route::get('distribusi-warga', function () {
            return view('qurban.distribusi_warga');
        })->name('qurban.distribusi_warga');
        Route::get('distribusi-shohibul', function () {
            return view('qurban.distribusi_shohibul');
        })->name('qurban.distribusi_shohibul');
        Route::get('distribusi/laporan/{date}/print', function ($date) {
            $data = Distribusi::with('user')->whereYear('created_at', $date)->get();
            $pdf = PDF::loadView('qurban.laporan.print_distribusi', ['data' => $data]);
            return $pdf->stream();
        })->name('print.distribusi');
        Route::get('shobul/laporan/{year}/print/{master_hewan_id}', function ($year, $master_hewan_id) {
            $data = ShobulQurban::with(['user', 'hewan', 'master_hewan', 'qurban'])->whereHas('hewan', function ($query) use ($year, $master_hewan_id) {
                $query->whereYear('created_at', $year);
            })->whereHas('qurban', function ($query) {
                $query->groupBy('antrian');
            })->where('master_hewan_id', $master_hewan_id)->whereNotIn('status', [0, 2])->get();
            $pdf = PDF::loadView('qurban.laporan.print_mudhohi', ['data' => $data, 'id_master_hewan' => $master_hewan_id])->setPaper('a4');
            return $pdf->stream();
        })->name('print.shohibul');
    });
});
