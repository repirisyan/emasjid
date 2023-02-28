<?php

namespace App\Http\Livewire\Ziswaf;

use App\Models\ZiswafVisiMisi;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class VisiMisi extends Component
{
    use LivewireAlert;

    public $deskripsi;

    public function render()
    {
        return view('livewire.ziswaf.visi-misi', [
            'data' => ZiswafVisiMisi::where('id', 1)->first()
        ]);
    }

    public function update()
    {
        try {
            ZiswafVisiMisi::find(1)->update([
                'visi_misi' => $this->deskripsi
            ]);
            $this->alert(
                'success',
                'Data berhasil diubah'
            );
        } catch (\Exception $e) {
            $this->alert(
                'error',
                'Terjadi kesalahan saat mengubah data'
            );
        }
        $this->reset('deskripsi');
    }
}
