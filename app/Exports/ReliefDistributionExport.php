<?php

namespace App\Exports;

use App\Patient;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReliefDistributionExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    protected $titleMessage;

    public function __construct($titleMessage = 'वितरण गरिएको राहतको विवरण')
    {
        $this->titleMessage = $titleMessage;
    }

    public function collection()
    {
        // Fetch all patients with verified_date and status paid
        return Patient::select(
                'name',
                'ward_number',
                'mobile_number',
                'description',
                'kshati_date',
                'estimated_amount',
                'paid_amount'
            )
            ->whereNotNull('verified_date')
            ->where('status', 'paid')
            ->orderBy('ward_number')
            ->get()
            ->map(function ($row, $index) {
                return [
                    'क्र.स.' => $index + 1,
                    'नामथर' => $row->name,
                    'वडा नं.' => $row->ward_number,
                    'सम्पर्क नं.' => $row->mobile_number,
                    'क्षती भएको कारण' => $row->description,
                    'क्षती मिति' => $row->kshati_date,
                    'अनुमानित क्षतिकम' => $row->estimated_amount,
                    'प्रदान रकम' => $row->paid_amount,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'क्र.स.',
            'नामथर',
            'वडा नं.',
            'सम्पर्क नं.',
            'क्षती भएको कारण',
            'क्षती मिति',
            'अनुमानित क्षतिकम',
            'प्रदान रकम',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // Serial number
            'B' => 25,
            'C' => 10,
            'D' => 18,
            'E' => 30,
            'F' => 15,
            'G' => 18,
            'H' => 18,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Report Title
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', $this->titleMessage);
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getRowDimension(1)->setRowHeight(28);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');

        // Headings
        $sheet->getStyle('A2:H2')->getFont()->setBold(true);
        $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal('center');

        // Fill headings
        $sheet->fromArray($this->headings(), null, 'A2');

        // Fill data starting from row 3
        $sheet->fromArray($this->collection()->toArray(), null, 'A3');

        // Center and wrap everything
        $sheet->getStyle('A1:H' . $sheet->getHighestRow())
            ->getAlignment()->setHorizontal('center')
            ->setVertical('center')
            ->setWrapText(true);
    }
}
