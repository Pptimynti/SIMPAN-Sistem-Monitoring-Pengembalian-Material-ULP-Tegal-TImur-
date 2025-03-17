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
use PhpOffice\PhpSpreadsheet\Style\Alignment;

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
        if ($this->filterBy && $this->startDate && $this->endDate) {
            $header = [
                ['Rekap Pengembalian Material Berdasarkan ' . $this->getFilterText() . ' Periode ' . $this->startDate . ' hingga ' . $this->endDate],
                ['PT PLN (PERSERO) ULP TEGAL TIMUR'],
                ['Catatan: Data ini adalah rekap pengembalian material berdasarkan ' . $this->getFilterText() . ' periode ' . $this->startDate . ' hingga ' . $this->endDate . '.'],
            ];
        } else {
            $header = [
                ['Rekap Semua Pengembalian Material'],
                ['PT PLN (PERSERO) ULP TEGAL TIMUR'],
                ['Catatan: Data ini adalah rekap pengembalian material secara keseluruhan.'],
            ];
        }

        $header[] = [
            'No',
            'No Agenda',
            'Tanggal PK',
            'Tanggal',
            'Petugas',
            'Nama Pelanggan',
            'Mutasi',
            'Nama Material',
            'Jumlah',
            'Gambar'
        ];

        return $header;
    }

    protected function getFilterText()
    {
        switch ($this->filterBy) {
            case 'tanggal_pk':
                return 'Tanggal PK';
            case 'created_at':
                return 'Tanggal Pengembalian';
            default:
                return '';
        }
    }

    public function map($pekerjaan): array
    {
        $rows = [];
        $materialCount = count($pekerjaan->materialDikembalikans);

        foreach ($pekerjaan->materialDikembalikans as $index => $material) {
            $row = [
                $index === 0 ? $this->counter : '',
                $index === 0 ? $pekerjaan->created_at->isoFormat('D MMMM Y') : '',
                $index === 0 ? $pekerjaan->no_agenda : '',
                $index === 0 ? $pekerjaan->tanggal_pk : '',
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

        $logo = new Drawing();
        $logo->setName('Logo');
        $logo->setDescription('Logo');
        $logo->setPath(public_path('images/pln.png'));
        $logo->setHeight(50);
        $logo->setCoordinates('A1');
        $logo->setOffsetX(10);
        $logo->setOffsetY(10);
        $drawings[] = $logo;

        $row = 5;
        $materials = $this->collection();

        foreach ($materials as $pekerjaan) {
            foreach ($pekerjaan->materialDikembalikans as $material) {
                foreach ($material->gambarMaterials as $gambar) {
                    if (!empty($gambar->gambar)) {
                        $drawing = new Drawing();
                        $drawing->setName($material->material->nama);
                        $drawing->setDescription($material->material->nama);
                        $drawing->setPath(public_path('storage/' . $gambar->gambar));
                        $drawing->setHeight(150);
                        $drawing->setCoordinates('J' . $row);
                        $drawing->setOffsetX(0);
                        $drawing->setOffsetY(0);
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
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->mergeCells('A2:J2');
        $sheet->getStyle('A2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->mergeCells('A3:J3');
        $sheet->getStyle('A3')->applyFromArray([
            'font' => [
                'italic' => true,
                'size' => 12,
                'color' => ['rgb' => '000000'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_LEFT,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A4:J4')->applyFromArray([
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

        $sheet->getStyle('A5:J' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        for ($row = 5; $row <= $sheet->getHighestRow(); $row++) {
            $sheet->getRowDimension($row)->setRowHeight(150);
        }

        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(25);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setWidth(40);
        $sheet->getColumnDimension('I')->setWidth(15);
        $sheet->getColumnDimension('J')->setWidth(40);

        $sheet->getStyle('A1:J' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:J' . ($sheet->getHighestRow()))->getAlignment()->setVertical('center');

        $row = 5;
        $materials = Pekerjaan::with('materialDikembalikans')->get();

        foreach ($materials as $pekerjaan) {
            $materialCount = count($pekerjaan->materialDikembalikans);
            if ($materialCount > 1) {
                $sheet->mergeCells("A{$row}:A" . ($row + $materialCount - 1));
                $sheet->mergeCells("B{$row}:B" . ($row + $materialCount - 1));
                $sheet->mergeCells("C{$row}:C" . ($row + $materialCount - 1));
                $sheet->mergeCells("D{$row}:D" . ($row + $materialCount - 1));
                $sheet->mergeCells("E{$row}:E" . ($row + $materialCount - 1));
                $sheet->mergeCells("F{$row}:F" . ($row + $materialCount - 1));
                $sheet->mergeCells("G{$row}:G" . ($row + $materialCount - 1));
            }
            $row += $materialCount;
        }

        return [];
    }
}
