<?php

namespace App\Livewire;

use App\Models\MaterialBekas;
use Livewire\Component;
use Livewire\WithPagination;

class TabelMaterialReturn extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;
    public function render()
    {
        $materialBekas = MaterialBekas::with('material')
            ->whereHas('material', function ($query) {
                $query->where('nama', 'like', "%{$this->search}%");
            })->paginate($this->perPage);
        return view('livewire.tabel-material-return', compact('materialBekas'));
    }
}
