<?php

namespace App\Livewire;

use App\Exports\RekapPengembalianMaterialExport;
use App\Models\Pekerjaan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class TabelRekapPengembalianMaterial extends Component
{
    use WithPagination;

    public $search = '';
    public $filterBy = '';
    public $perPage = 5;
    public $startDate;
    public $endDate;

    protected $updatesQueryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterBy()
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
        $query = Pekerjaan::query()
            ->where(function ($q) {
                $q->where('no_agenda', 'like', "%{$this->search}%")
                    ->orWhere('petugas', 'like', "%{$this->search}%");
            });

        if ($this->filterBy && $this->startDate && $this->endDate) {
            $query->whereBetween($this->filterBy, [$this->startDate, $this->endDate]);
        }

        $pekerjaans = $query->latest()->paginate($this->perPage);

        return view('livewire.tabel-rekap-pengembalian-material', compact('pekerjaans'));
    }

    public function cetak_pdf()
    {
        $pekerjaans = Pekerjaan::with('materialDikembalikans.gambarMaterials')
            ->where(function ($q) {
                $q->where('no_agenda', 'like', "%{$this->search}%")
                    ->orWhere('petugas', 'like', "%{$this->search}%");
            })
            ->get();

        $pdf = Pdf::loadView('rekap_pengembalian_material', ['pekerjaans' => $pekerjaans])
            ->setPaper('A4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'rekap-pengembalian.pdf');
    }

    public function export()
    {
        return Excel::download(
            new RekapPengembalianMaterialExport($this->search, $this->startDate, $this->endDate, $this->filterBy),
            'rekap_pengembalian_material.xlsx'
        );
    }
}
