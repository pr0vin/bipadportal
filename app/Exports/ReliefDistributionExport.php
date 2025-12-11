<?php

namespace App\Exports;

use App\Patient;
use App\Address;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReliefDistributionExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    protected $municipalityId;
    protected $titleMessage;

    public function __construct($municipalityId, $titleMessage = 'वितरण गरिएको राहतको विवरण')
    {
        $this->municipalityId = $municipalityId;
        $this->titleMessage   = $titleMessage;
    }

    public function collection()
    {
        return Patient::select(
                'name',
                'ward_number',
                'mobile_number',
                'damage_type',
                'damage_description',
                'estimated_loss',
                'relief_amount',
                'verified_date'
            )
            ->whereNotNull('verified_date')
            ->where('municipality_id', $this->municipalityId)
            ->orderBy('ward_number')
            ->get()
            ->map(function ($row) {
                return [
                    'name'              => $row->name,
                    'ward'              => $row->ward_number,
                    'mobile'            => $row->mobile_number,
                    'damage_type'       => $row->damage_type,
                    'damage_desc'       => $row->damage_description,
                    'estimated_loss'    => $row->estimated_loss,
                    'relief_amount'     => $row->relief_amount,
                    'verified_date'     => $row->verified_date,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'लाभग्राहीको नाम',
            'वडा नं.',
            'मोबाइल नं.',
            'क्षतिको प्रकार',
            'क्षतिको विवरण',
            'अनुमानित क्षति रकम (रु.)',
            'वितरण गरिएको राहत रकम (रु.)',
            'सत्यापन मिति',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 10,
            'C' => 18,
            'D' => 18,
            'E' => 30,
            'F' => 15,
            'G' => 18,
            'H' => 15,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // ----------------------------
        // Municipality Title Row
        // ----------------------------
        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', Address::find($this->municipalityId)->municipality);
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(28);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center')->setVertical('center');

        // ----------------------------
        // Report Title Row
        // ----------------------------
        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', $this->titleMessage);
        $sheet->getStyle('A2')->getFont()->setSize(12);
        $sheet->getRowDimension('2')->setRowHeight(24);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2')->getAlignment()->setWrapText(true);

        // ----------------------------
        // Headings (Row 3)
        // ----------------------------
        $sheet->fromArray($this->headings(), null, 'A3');
        $sheet->getStyle('A3:H3')->getFont()->setBold(true);
        $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal('center');

        // ----------------------------
        // Fill Data from Row 4
        // ----------------------------
        $sheet->fromArray($this->collection()->toArray(), null, 'A4');

        // Center all cells
        $sheet->getStyle('A1:H' . $sheet->getHighestRow())
              ->getAlignment()->setHorizontal('center')->setVertical('center');

        // Wrap text everywhere
        $sheet->getStyle('A1:H' . $sheet->getHighestRow())
              ->getAlignment()->setWrapText(true);

        // Auto row height
        $highestRow = $sheet->getHighestRow();
        for ($row = 1; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }
    }
}
