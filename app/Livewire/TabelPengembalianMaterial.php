<?php

namespace App\Livewire;

use App\Models\Pekerjaan;
use Livewire\Component;
use Livewire\WithPagination;

class TabelPengembalianMaterial extends Component
{
    use WithPagination;
    public $search = '';
    protected $updatesQueryString = ['search'];
    public function render()
    {
        return view('livewire.tabel-pengembalian-material', [
            'pekerjaans' => Pekerjaan::where('no_agenda', 'like', "%{$this->search}%")
                ->orWhere('petugas', 'like', "%{$this->search}%")
                ->paginate(5)
        ]);
    }
}
