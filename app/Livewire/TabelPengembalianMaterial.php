<?php

namespace App\Livewire;

use App\Models\Pekerjaan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TabelPengembalianMaterial extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $filterBy = '';
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
        $query = Pekerjaan::query();

        if ($this->filterBy && $this->startDate && $this->endDate) {
            if ($this->filterBy === 'created_at') {
                $query->whereBetween(DB::raw('DATE(created_at)'), [$this->startDate, $this->endDate]);
            } else {
                $query->whereBetween($this->filterBy, [$this->startDate, $this->endDate]);
            }
        }

        $query->where(function ($q) {
            $q->where('no_agenda', 'like', "%{$this->search}%")
                ->orWhere('petugas', 'like', "%{$this->search}%")
                ->orWhere('mutasi', 'like', "%{$this->search}%");
        });

        $pekerjaans = $query->with('materialDikembalikans.material')->latest()->paginate($this->perPage);

        return view('livewire.tabel-pengembalian-material', [
            'pekerjaans' => $pekerjaans
        ]);
    }
}
