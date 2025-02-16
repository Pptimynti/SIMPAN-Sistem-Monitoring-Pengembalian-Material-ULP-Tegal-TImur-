<?php

namespace App\Exports;

use App\Models\Pekerjaan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetailRekapPengembalianMaterial implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $pekerjaanId;

    public function __construct($pekerjaanId)
    {
        $this->pekerjaanId = $pekerjaanId;
    }

    public function collection()
    {
        $pekerjaan = Pekerjaan::with('materialDikembalikans.gambarMaterials')
            ->findOrFail($this->pekerjaanId);

        return collect([$pekerjaan]);
    }

    public function headings(): array
    {
        return [
            'NO AGENDA',
            'PETUGAS',
            'NAMA PELANGGAN',
            'MUTASI',
            'MATERIAL DIKEMBALIKAN',
            'JUMLAH'
        ];
    }

    public function map($pekerjaan): array
    {
        $rows = [];
        $firstRow = true;

        foreach ($pekerjaan->materialDikembalikans as $material) {
            if ($firstRow) {
                $row = [
                    $pekerjaan->no_agenda,
                    $pekerjaan->petugas,
                    $pekerjaan->nama_pelanggan,
                    $pekerjaan->mutasi,
                    $material->nama,
                    "x{$material->jumlah}"
                ];
                $firstRow = false;
            } else {
                $row = [
                    '',
                    '',
                    '',
                    '',
                    $material->nama,
                    "x{$material->jumlah}"
                ];
            }

            $rows[] = $row;
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
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

        $sheet->getStyle('A2:F' . ($sheet->getHighestRow()))->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(25);
        $sheet->getColumnDimension('F')->setWidth(15);

        $sheet->getStyle('A1:F' . ($sheet->getHighestRow()))->getAlignment()->setHorizontal('center');

        return [];
    }
}
