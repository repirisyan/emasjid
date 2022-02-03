<?php

namespace App\Http\Livewire;

use App\Models\KeuanganZiswaf;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class LaporanKeuanganZiswaf extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $readyToLoad, $new_id, $dari, $sampai, $tanggal, $item, $debit, $kredit, $saldo, $debit_infaq, $debit_pinjaman, $kredit_infaq, $kredit_pinjaman, $saldo_infaq_shodaqoh, $piutang;
    protected $paginationTheme = 'bootstrap';
    protected $rules = [
        'tanggal' => 'required|date',
        'item' => 'required',
        'debit' => 'nullable|numeric|min:0',
        'kredit' => 'nullable|numeric|min:0',
        'saldo' => 'nullable|numeric|min:0',
        'debit_infaq' => 'nullable|numeric|min:0',
        'debit_pinjaman' => 'nullable|numeric|min:0',
        'kredit_infaq' => 'nullable|numeric|min:0',
        'kredit_pinjaman' => 'nullable|numeric|min:0',
        'saldo_infaq_shodaqoh' => 'nullable|numeric|min:0',
        'piutang' => 'nullable|numeric|min:0',
    ];

    protected $listeners = [
        'confirmed',
        'cancelled'
    ];
    public function mount()
    {
        $this->dari = date("Y-m-01");
        $this->sampai = date("Y-m-t");
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function resetFields()
    {
        $this->resetValidation();
        $this->resetExcept('readyToLoad', 'dari', 'sampai');
    }

    public function render()
    {
        return view('livewire.laporan-keuangan-ziswaf', [
            'data' => $this->readyToLoad ? KeuanganZiswaf::whereBetween('tanggal', [$this->dari, $this->sampai])->simplePaginate(15) : []
        ]);
    }

    public function store()
    {
        $this->validate();
        try {
            KeuanganZiswaf::create([
                'tanggal' => $this->tanggal,
                'item' => $this->item,
                'debit' => $this->debit,
                'kredit' => $this->kredit,
                'saldo' => $this->saldo,
                'debit_infaq' => $this->debit_infaq,
                'debit_pinjaman' => $this->debit_pinjaman,
                'kredit_infaq' => $this->kredit_infaq,
                'kredit_pinjaman' => $this->kredit_pinjaman,
                'saldo_infaq' => $this->saldo_infaq_shodaqoh,
                'piutang' => $this->piutang
            ]);
            $this->alert(
                'success',
                'Data berhasil disimpan'
            );
        } catch (\Throwable $th) {
            //throw $th;
            $this->alert(
                'error',
                'Terjadi kesalahan saat menyimpan data'
            );
        }
        $this->dispatchBrowserEvent('userStore');
        $this->emit('userStore');
        $this->resetFields();
    }

    public function update()
    {
        $this->validate();
        try {
            KeuanganZiswaf::find($this->new_id)->update([
                'tanggal' => $this->tanggal,
                'item' => $this->item,
                'debit' => $this->debit,
                'kredit' => $this->kredit,
                'saldo' => $this->saldo,
                'debit_infaq' => $this->debit_infaq,
                'debit_pinjaman' => $this->debit_pinjaman,
                'kredit_infaq' => $this->kredit_infaq,
                'kredit_pinjaman' => $this->kredit_pinjaman,
                'saldo_infaq' => $this->saldo_infaq_shodaqoh,
                'piutang' => $this->piutang
            ]);
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Throwable $th) {
            //throw $th;
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->dispatchBrowserEvent('userUpdate');
        $this->emit('userUpdate');
        $this->resetFields();
    }

    public function edit($id)
    {
        $this->new_id = $id;
        $data = KeuanganZiswaf::where('id', $id)->first();
        $this->tanggal = $data->tanggal;
        $this->item = $data->item;
        $this->debit = $data->debit;
        $this->kredit = $data->kredit;
        $this->saldo = $data->saldo;
        $this->debit_infaq = $data->debit_infaq;
        $this->kredit_infaq = $data->kredit_infaq;
        $this->kredit_pinjaman = $data->kredit_pinjaman;
        $this->saldo_infaq_shodaqoh = $data->saldo_infaq;
        $this->piutang = $data->piutang;
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Apa anda yakin akan menghapus data ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Hapus',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);
        $this->new_id = $id;
    }

    public function confirmed()
    {
        // Example code inside confirmed callback
        try {
            KeuanganZiswaf::destroy($this->new_id);
            $this->alert(
                'success',
                'Data keuangan ziswaf berhasil dihapus'
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
