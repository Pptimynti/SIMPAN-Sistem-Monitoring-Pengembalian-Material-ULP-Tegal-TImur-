<?php

namespace App\Livewire;

use App\Models\Material;
use Livewire\Component;
use Livewire\WithPagination;

class TabelMaterial extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;
    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $materials = Material::where('nama', 'like', "%{$this->search}%")->orderBy('nama', 'asc')->paginate($this->perPage);
        return view('livewire.tabel-material', compact('materials'));
    }
}
