<?php
namespace App\Exports;

use App\Models\Pekerjaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class RekapPengembalianMaterialExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithDrawings
{
    protected $search;
    protected $counter;
    protected $startDate;
    protected $endDate;
    protected $filterBy;

    public function __construct($search, $startDate, $endDate, $filterBy)
    {
        $this->search = $search;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->filterBy = $filterBy;
        $this->counter = 1;
    }

    public function collection()
    {
        $query = Pekerjaan::with('materialDikembalikans.gambarMaterials');

        $query->where(function ($q) {
            $q->where('no_agenda', 'like', "%{$this->search}%")
                ->orWhere('petugas', 'like', "%{$this->search}%");
        });

        if ($this->filterBy && $this->startDate && $this->endDate) {
            $query->whereDate($this->filterBy, '>=', $this->startDate)
                ->whereDate($this->filterBy, '<=', $this->endDate);
        }

        return $query->get();
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
            'Jumlah',
            'Gambar'
        ];
    }

    public function map($pekerjaan): array
    {
        $rows = [];
        $materialCount = count($pekerjaan->materialDikembalikans);

        foreach ($pekerjaan->materialDikembalikans as $index => $material) {
            $row = [
                $index === 0 ? $this->counter : '',
                $index === 0 ? $pekerjaan->no_agenda : '',
                $index === 0 ? $pekerjaan->petugas : '',
                $index === 0 ? $pekerjaan->nama_pelanggan : '',
                $index === 0 ? $pekerjaan->mutasi : '',
                $material->material->nama,
                "{$material->jumlah} {$material->material->satuan}",
                ''
            ];

            $rows[] = $row;
        }

        $this->counter++;
        return $rows;
    }

    public function drawings()
    {
        $drawings = [];
        $row = 2;

        $materials = $this->collection();

        foreach ($materials as $pekerjaan) {
            foreach ($pekerjaan->materialDikembalikans as $material) {
                foreach ($material->gambarMaterials as $gambar) {
                    if (!empty($gambar->gambar)) {
                        $drawing = new Drawing();
                        $drawing->setName($material->material->nama);
                        $drawing->setDescription($material->material->nama);
                        $drawing->setPath(public_path('storage/' . $gambar->gambar));
                        $drawing->setHeight(80);
                        $drawing->setCoordinates('H' . $row);
                        $drawing->setOffsetX(35);
                        $drawing->setOffsetY(10);
                        $drawings[] = $drawing;
                    }
                }
                $row++;
            }
        }

        return $drawings;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([
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

        $sheet->getStyle('A2:H' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        for ($row = 2; $row <= $sheet->getHighestRow(); $row++) {
            $sheet->getRowDimension($row)->setRowHeight(80);
        }

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(25);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setWidth(15);
        $sheet->getColumnDimension('H')->setWidth(20);

        $sheet->getStyle('A1:H' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:H' . ($sheet->getHighestRow()))->getAlignment()->setVertical('center');

        $row = 2;
        $materials = Pekerjaan::with('materialDikembalikans')->get();

        foreach ($materials as $pekerjaan) {
            $materialCount = count($pekerjaan->materialDikembalikans);
            if ($materialCount > 1) {
                $sheet->mergeCells("A{$row}:A" . ($row + $materialCount - 1));
                $sheet->mergeCells("B{$row}:B" . ($row + $materialCount - 1));
                $sheet->mergeCells("C{$row}:C" . ($row + $materialCount - 1));
                $sheet->mergeCells("D{$row}:D" . ($row + $materialCount - 1));
                $sheet->mergeCells("E{$row}:E" . ($row + $materialCount - 1));
            }
            $row += $materialCount;
        }

        return [];
    }
}
