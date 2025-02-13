<?php

namespace App\Livewire;

use App\Exports\RekapPengembalianMaterialExport;
use App\Models\Pekerjaan;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TabelRekapPengembalianMaterial extends Component
{
    use WithPagination;
    public $search = '';
    protected $updatesQueryString = ['search'];
    public function render()
    {
        return view('livewire.tabel-rekap-pengembalian-material', [
            'pekerjaans' => Pekerjaan::where('no_agenda', 'like', "%{$this->search}%")
                ->orWhere('petugas', 'like', "%{$this->search}%")
                ->paginate(5)
        ]);
    }

    public function export()
    {
        return Excel::download(new RekapPengembalianMaterialExport($this->search), 'rekap_pengembalian_material.xlsx');
    }
}
