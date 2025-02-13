<?php
namespace App\Exports;

use App\Models\Pekerjaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapPengembalianMaterialExport implements FromCollection, WithHeadings, WithMapping
{
    protected $search;

    public function __construct($search)
    {
        $this->search = $search;
    }

    public function collection()
    {
        return Pekerjaan::with('materialDikembalikans.gambarMaterials')
            ->where('no_agenda', 'like', "%{$this->search}%")
            ->orWhere('petugas', 'like', "%{$this->search}%")
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'No Agenda',
            'Petugas',
            'Nama Pelanggan',
            'Mutasi',
            'Material Nama',
            'Jumlah',
            'Gambar'
        ];
    }

    public function map($pekerjaan): array
    {
        $rows = [];

        foreach ($pekerjaan->materialDikembalikans as $material) {
            $gambarUrls = $material->gambarMaterials->pluck('gambar')->map(function ($gambar) {
                return asset('storage/' . $gambar);
            })->implode(", ");

            $rows[] = [
                $pekerjaan->id,
                $pekerjaan->no_agenda,
                $pekerjaan->petugas,
                $pekerjaan->nama_pelanggan,
                $pekerjaan->mutasi,
                $material->nama,
                $material->jumlah,
                $gambarUrls,
            ];
        }

        return $rows;
    }
}
