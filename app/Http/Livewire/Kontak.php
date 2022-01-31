<?php

namespace App\Http\Livewire;

use App\Models\Kontak as ModelsKontak;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Kontak extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $readyToLoad, $status, $pesan, $new_id;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = [
        'confirmed',
        'cancelled',
    ];

    public function mount()
    {
        $this->status = 1;
        $this->readyToLoad = false;
    }

    public function loadPosts()
    {
        $this->readyToLoad = true;
    }

    public function resetFields()
    {
        $this->resetExcept('readyToLoad', 'status');
    }

    public function render()
    {
        return view('livewire.kontak', [
            'data' => $this->readyToLoad ? ModelsKontak::where('status', $this->status)->orderBy('created_at', 'desc')->simplePaginate(15) : [],
        ]);
    }

    public function updated(){
        $this->resetPage();
    }

    public function open_mail($id, $pesan)
    {
        $this->pesan = $pesan;
        try {
            ModelsKontak::find($id)->update([
                'status' => 2,
                'updated_at' => now(),
            ]);
        } catch (\Throwable $th) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat membuka pesan',
            );
        }
    }

    public function see_mail($pesan)
    {
        $this->pesan = $pesan;
    }

    public function triggerConfirm($id)
    {
        $this->confirm('Apakah anda ingin menghapus pesan ini ?', [
            'toast' => false,
            'position' => 'center',
            'confirmButtonText' =>  'Ya',
            'cancelButtonText' =>  'Batal',
            'onConfirmed' => 'confirmed',
            'onDismissed' => 'cancelled'
        ]);

        $this->new_id = $id;
    }

    public function confirmed()
    {
        try {
            ModelsKontak::destroy($this->new_id);
            $this->alert(
                'success',
                'Pesan berhasil dihapus'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat menghapus pesan'
            );
        }
        $this->resetFields();
    }

    public function cancelled()
    {
        $this->resetFields();
    }
}
