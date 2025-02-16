<?php
namespace App\Exports;

use App\Models\Pekerjaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapPengembalianMaterialExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $search;
    protected $counter;

    public function __construct($search)
    {
        $this->search = $search;
        $this->counter = 1;
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
            'Nama Material',
            'Jumlah'
        ];
    }

    public function map($pekerjaan): array
    {
        $rows = [];

        foreach ($pekerjaan->materialDikembalikans as $index => $material) {
            $row = [
                $index === 0 ? $this->counter : '',
                $index === 0 ? $pekerjaan->no_agenda : '',
                $index === 0 ? $pekerjaan->petugas : '',
                $index === 0 ? $pekerjaan->nama_pelanggan : '',
                $index === 0 ? $pekerjaan->mutasi : '',
                $material->nama,
                "x{$material->jumlah}"
            ];

            $rows[] = $row;
        }
        $this->counter++;
        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:G1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->getStyle('A2:G' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(30);
        $sheet->getColumnDimension('G')->setWidth(15);

        $sheet->getStyle('A1:G' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');

        return [];
    }
}
