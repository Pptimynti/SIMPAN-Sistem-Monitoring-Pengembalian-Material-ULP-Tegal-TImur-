<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use App\Models\MaterialBekas;
use Livewire\Component;
use Livewire\WithPagination;

class TabelMaterialReturn extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;

    use WithPagination;
    public function render()
    {

        $activityLogs = ActivityLog::where('aktivitas', 'Menggunakan Material Return')->paginate(5);
        $materialBekas = MaterialBekas::with('material')
            ->whereHas('material', function ($query) {
                $query->where('nama', 'like', "%{$this->search}%");
            })->paginate($this->perPage);
        return view('livewire.tabel-material-return', compact('materialBekas', 'activityLogs'));
    }
}
