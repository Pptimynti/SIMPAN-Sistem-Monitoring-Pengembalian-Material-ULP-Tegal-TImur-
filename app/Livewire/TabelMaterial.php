<?php

namespace App\Livewire;

use App\Models\Material;
use Livewire\Component;

class TabelMaterial extends Component
{
    public function render()
    {
        $materials = Material::all();
        return view('livewire.tabel-material', compact('materials'));
    }
}
