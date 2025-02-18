<?php

namespace App\Livewire;

use App\Models\Pekerjaan;
use Carbon\Carbon;
use Livewire\Component;

class TabelPengembalianMaterialPetugas extends Component
{
    public $search = '';
    public function render()
    {
        $pekerjaans = Pekerjaan::with('materialDikembalikans.gambarMaterials')
            ->where('no_agenda', 'like', "%{$this->search}%")
            ->orWhere('petugas', 'like', "%{$this->search}%")
            ->orWhere('created_at', Carbon::parse(today()))->get();
        return view('livewire.tabel-pengembalian-material-petugas', compact('pekerjaans'));
    }
}
