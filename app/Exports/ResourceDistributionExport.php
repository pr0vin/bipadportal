<?php

namespace App\Exports;

use App\DistributionDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ResourceDistributionExport implements
    FromCollection,
    WithHeadings,
    WithColumnWidths,
    WithStyles,
    WithCustomStartCell
{
    protected $titleMessage;

    public function __construct(
        $titleMessage = 'राहत उद्धार सामग्रीहरुको विवरण'
    ) {
        $this->titleMessage = $titleMessage;
    }

    /**
     * Start data AFTER title
     */
    public function startCell(): string
    {
        return 'A3'; // headings will be on row 3
    }

    /**
     * Data rows
     */
    public function collection()
    {
        return DistributionDetail::with([
                'resource.unit',
                'distribution.patient'
            ])
            ->whereHas('distribution', function ($q) {
                $q->where('type', 0)
                  ->whereNull('deleted_at');
            })
            ->latest()
            ->get()
            ->values()
            ->map(function ($item, $index) {
                return [
                    $index + 1,
                    $item->resource->name ?? '-',
                    $item->quantity . ' ' . ($item->resource->unit->name ?? ''),
                    ($item->distribution->patient->name ?? '—') .
                        ($item->distribution->remark
                            ? ' / ' . $item->distribution->remark
                            : ''),
                ];
            });
    }

    /**
     * Column headings
     */
    public function headings(): array
    {
        return [
            'क्र.स.',
            'सामग्रीको नाम',
            'परिमाण',
            'कैफियत',
        ];
    }

    /**
     * Column widths
     */
    public function columnWidths(): array
    {
        return [
            'A' => 8,
            'B' => 30,
            'C' => 18,
            'D' => 40,
        ];
    }

    /**
     * Sheet styling (TITLE HERE)
     */
    public function styles(Worksheet $sheet)
    {
        // 🔹 Title
        $sheet->mergeCells('A1:D1');
        $sheet->setCellValue('A1', $this->titleMessage);

        $sheet->getStyle('A1')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center',
            ],
        ]);

        $sheet->getRowDimension(1)->setRowHeight(32);

        // 🔹 Headings style (Row 3)
        $sheet->getStyle('A3:D3')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center'],
        ]);

        // 🔹 Wrap all data
        $sheet->getStyle('A1:D' . $sheet->getHighestRow())
            ->getAlignment()
            ->setWrapText(true);
    }
}
