<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BipannaHospitalWiseExport implements FromArray, WithHeadings, WithStyles
{
    protected $hospitalData;
    protected $diseaseNames;
    protected $hospitalNames;
    protected $hospitalTotalPatients;
    public function __construct($hospitalData, $diseaseNames, $hospitalNames, $hospitalTotalPatients)
    {
        $this->hospitalData = $hospitalData;
        $this->diseaseNames = $diseaseNames;
        $this->hospitalNames = $hospitalNames;
        $this->hospitalTotalPatients = $hospitalTotalPatients;
    }

    public function array(): array
    {
        $data = [];
        foreach ($this->hospitalData as $hospitalId => $patient) {
            $patientData = [
                'hospital' => $this->hospitalNames[$hospitalId] ?? ''
            ];
            foreach ($this->diseaseNames as $index => $disease) {
                $patientData[$disease] = isset($patient[$index]) ? $patient[$index] : '';
            }
            $patientData['total'] = $this->hospitalTotalPatients[$hospitalId] ?? '0';
            $data[] = $patientData;
        }
        return $data;
    }

    public function headings(): array
    {
        $name = [];
        foreach ($this->diseaseNames as $diseaseName) {
            $name[] = $diseaseName;
        }
        $staticHeaser = [
            'अस्पतालको नाम', //A
        ];
        $totalHeader = [
            'जम्मा'
        ];

        return array_merge($staticHeaser, $name, $totalHeader);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:J1');
        $sheet->setCellValue('A1', "अनुसूची-१०");
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setWrapText(true);

        $subtitles = [
            " ( दफा ३ उप दफा (५.घ) संग सम्बन्धित)" => 2,
            " विपन्न नागरिकलाई कडा रोग उपचारका लागि सिफारिस गरिएको प्रतिवेदन फाराम" => 3,
            " मिति : " . ad_to_bs(now()->format('Y-m-d')) => 4,
            "स्थानीय तहको नाम:" => 5,
            "बार्षिक प्रतिवेदन:" => 6,
            "आर्थिक वर्ष:" . currentFiscalYear()->name => 7,
        ];

        foreach ($subtitles as $text => $row) {
            $sheet->mergeCells("A{$row}:J{$row}");
            $sheet->setCellValue("A{$row}", $text);
            $sheet->getStyle("A{$row}")->getFont()->setSize(12);
            $sheet->getRowDimension($row)->setRowHeight(20);
            $sheet->getStyle("A{$row}")->getAlignment()->setWrapText(true);
        }

        $sheet->getStyle('A2:J2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3:J3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A4:J4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        $headingsRow = 8;
        $sheet->fromArray($this->headings(), null, 'A' . $headingsRow);

        $dataRow = $headingsRow + 1;
        $dataArray = $this->array();
        $sheet->fromArray($dataArray, null, 'A' . $dataRow);

        $sheet->getStyle('A' . $headingsRow . ':J' . $headingsRow)->getFont()->setBold(true);
        $sheet->getStyle('A8:I' . $sheet->getHighestRow())->getAlignment()->setHorizontal('center')->setVertical('center');

        $styleRange = 'A1:J' . $sheet->getHighestRow();
        $sheet->getStyle($styleRange)->getAlignment()->setWrapText(true);

        $columns = range('A', 'J');
        $columnWidths = [
            'A' => 17,
            'B' => 8,
            'C' => 12,
            'D' => 8,
            'E' => 10,
            'F' => 12,
            'G' => 10,
            'H' => 18,
            'I' => 20,
            'J' => 10,
        ];
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        $highestRow = $sheet->getHighestRow();
        for ($row = $headingsRow; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }
    }
}
