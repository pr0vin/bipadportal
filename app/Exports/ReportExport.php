<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromArray, WithHeadings, WithStyles
{
    protected $rows;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    /**
     * Data rows only (NO title here)
     */
    public function array(): array
    {
        $data = [];

        foreach ($this->rows as $index => $row) {
            $rowData = [
                $index + 1,
                $row->name,
            ];

            // disease columns (1–8 exactly like Blade)
            foreach (range(1, 8) as $diseaseId) {
                $rowData[] = $row->diseases
                    ->where('disease_id', $diseaseId)
                    ->sum('patient_count');
            }

            // estimated loss
            $rowData[] = $row->estimated_loss ?? 0;

            $data[] = $rowData;
        }

        return $data;
    }

    /**
     * Headings (same order as table)
     */
    public function headings(): array
    {
        return [
            'क्र.स',
            'घटनाको प्रकार',
            'मृत्यु',
            'वेपत्ता',
            'घाईते',
            'प्रभावित परिवार',
            'हराएका र जलेका पशुचौपाया',
            'घरको क्षती (पुर्ण)',
            'घरको क्षती (आंशिक)',
            'गोठ क्षति',
            'अनुमानित क्षति रकम रु.',
        ];
    }

    /**
     * Styling
     */
    public function styles(Worksheet $sheet)
    {
        // Title
        $sheet->mergeCells('A1:K1');
        $sheet->setCellValue('A1', 'प्रकोपको सङख्या र क्षतिको विवरण');

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

        // Headings row
        $sheet->getStyle('A2:K2')->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center'],
        ]);

        // Column widths
        $widths = [
            'A' => 6,
            'B' => 30,
            'C' => 10,
            'D' => 10,
            'E' => 10,
            'F' => 18,
            'G' => 20,
            'H' => 14,
            'I' => 14,
            'J' => 12,
            'K' => 18,
        ];

        foreach ($widths as $col => $width) {
            $sheet->getColumnDimension($col)->setWidth($width);
        }

        // Wrap & center everything
        $sheet->getStyle('A1:K' . $sheet->getHighestRow())
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical('center')
            ->setHorizontal('center');
    }
}
