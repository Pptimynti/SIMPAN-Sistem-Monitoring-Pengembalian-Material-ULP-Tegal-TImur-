<?php

namespace App\Livewire;

use App\Exports\RekapPengembalianMaterialExport;
use App\Models\Pekerjaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TabelRekapPengembalianMaterial extends Component
{
    use WithPagination;
    public $search = '';
    public $startDate;
    public $endDate;
    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Pekerjaan::query();

        $query->where(function ($q) {
            $q->where('no_agenda', 'like', "%{$this->search}%")
                ->orWhere('petugas', 'like', "%{$this->search}%");
        });

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', Carbon::parse($this->startDate));
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', Carbon::parse($this->endDate));
        }

        $pekerjaans = $query->latest()->paginate(5);

        return view('livewire.tabel-rekap-pengembalian-material', compact('pekerjaans'));
    }


    public function cetak_pdf()
    {
        $pekerjaans = Pekerjaan::with('materialDikembalikans.gambarMaterials')
            ->where('no_agenda', 'like', "%{$this->search}%")
            ->orWhere('petugas', 'like', "%{$this->search}%")
            ->get();

        $pdf = Pdf::loadView('rekap_pengembalian_material', ['pekerjaans' => $pekerjaans])->setPaper('A4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'rekap-pengembalian.pdf');
    }


    public function export()
    {
        return Excel::download(new RekapPengembalianMaterialExport($this->search), 'rekap_pengembalian_material.xlsx');
    }
}
