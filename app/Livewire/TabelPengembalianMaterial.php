<?php

namespace App\Livewire;

use App\Models\Pekerjaan;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class TabelPengembalianMaterial extends Component
{
    use WithPagination;
    public $search = '';
    public $startDate;
    public $endDate;

    protected $updatesQueryString = ['search'];
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

        return view('livewire.tabel-pengembalian-material', [
            'pekerjaans' => $pekerjaans
        ]);
    }
}
