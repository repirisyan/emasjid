<?php

namespace App\Http\Livewire\Bendahara;

use App\Models\DetailSaldo;
use App\Models\Keuangan;
use App\Models\Saldo;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanKeuangan extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $readyToLoad, $kategori, $tanggal, $keterangan, $nilai, $id_keuangan, $konfirmasi, $bulan, $tahun, $menu_saldo;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'kategori' => 'required',
        'tanggal' => 'required|date',
        'keterangan' => 'required',
        'nilai' => 'required|numeric|min:0'
    ];

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
        //Kategori (Pemasukkan & Pengeluaran)
        $this->kategori = 1;
        $this->readyToLoad = false;
    }

    public function render()
    {
        return view('livewire.bendahara.laporan-keuangan', [
            'data' => $this->readyToLoad ? Keuangan::with('user')->whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->where('kategori', $this->kategori)->simplePaginate(30) : [],
            'data_saldo' => $this->readyToLoad && $this->menu_saldo ? DetailSaldo::whereYear('tanggal', $this->tahun)->simplePaginate(30) : [],
        ]);
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function detail_saldo($bulan, $tahun, $kategori)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
        $this->kategori = $kategori;
        $this->menu_saldo = false;
    }

    public function menu($menu)
    {
        $this->kategori = $menu;
        $this->bulan = date('m');
        $this->tahun = date('Y');
        $this->menu_saldo = false;
    }

    public function menu_saldo()
    {
        $this->kategori = null;
        $this->menu_saldo = true;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'kategori', 'menu_saldo', 'bulan', 'tahun');
    }

    public function store()
    {
        $this->validate();
        try {
            Keuangan::create([
                'user_id' => auth()->user()->id,
                'kategori' => $this->kategori,
                'tanggal' => $this->tanggal,
                'keterangan' => $this->keterangan,
                'nilai' => $this->nilai,
                'status' => 1,
            ]);
            $this->alert(
                'success',
                'Data keuangan berhasil disimpan'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }

    public function edit($id, $keterangan, $nilai, $tanggal)
    {
        $this->id_keuangan = $id;
        $this->keterangan = $keterangan;
        $this->nilai = $nilai;
        $this->tanggal = $tanggal;
    }

    public function tutup_buku()
    {
        $this->validate([
            'bulan' => 'required|digits:2',
            'tahun' => 'digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'konfirmasi' => 'required|string|' . Rule::in(['KONFIRMASI']),
        ]);
        $cek = DetailSaldo::whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->exists();
        if ($cek) {
            $this->alert(
                'error',
                'Data sudah ada'
            );
        } else {
            $pemasukan = Keuangan::where('kategori', 1)->whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->sum('nilai');
            $pengeluaran = Keuangan::where('kategori', 2)->whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->sum('nilai');
            $saldo = $pemasukan - $pengeluaran;
            $saldo_awal = Saldo::value('jumlah_saldo');
            DB::transaction(function () use ($pemasukan, $pengeluaran, $saldo, $saldo_awal) {
                DetailSaldo::create([
                    'tanggal' => $this->tahun . '-' . $this->bulan . '-' . '01',
                    'pemasukan' => $pemasukan,
                    'pengeluaran' => $pengeluaran,
                    'saldo' => $saldo + $saldo_awal,
                    'saldo_awal' => $saldo_awal
                ]);
                $id = DetailSaldo::whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->value('id');
                Keuangan::whereMonth('tanggal', $this->bulan)->whereYear('tanggal', $this->tahun)->update([
                    'detail_saldo_id' => $id
                ]);
                Saldo::find(1)->increment('jumlah_saldo', $saldo);
            });
            $this->alert(
                'success',
                'Data tutup buku berhasil disimpan'
            );
        }
        $this->dispatchBrowserEvent('userTutup');
        $this->emit('userTutup');
        $this->resetFields();
    }

    public function update()
    {
        $this->validate();
        try {
            Keuangan::where('id', $this->id_keuangan)->update([
                'keterangan' => $this->keterangan,
                'nilai' => $this->nilai,
                'tanggal' => $this->tanggal,
            ]);
            $this->alert(
                'success',
                'Data keuangan berhasil diubah'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Hapus data ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);
        $this->id_keuangan = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            Keuangan::destroy($this->id_keuangan);
            $this->alert(
                'success',
                'Data berhasil dihapus'
            );
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menghapus data'
            );
        }
        $this->resetFields();
    }

    public function cancelled()
    {
        $this->resetFields();
    }
}
