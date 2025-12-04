<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class SamajikExport implements FromArray,WithHeadings,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $patients;
    public function __construct($patients)
    {
        $this->patients = $patients;
    }
    public function array(): array
    {
        $data = [];
        foreach ($this->patients as  $patient) {
            $patientGender = strtolower($patient->gender ?? '');

            if ($patientGender == 'male') {
                $gender = 'पुरुष';
            } elseif ($patientGender == 'female') {
                $gender = 'महिला';
            } else {
                $gender = 'अन्य';
            }
            $patientData = [
                'patient_name' => $patient->name,
                'patient_name_en' => $patient->name_en,
                'age'=>$patient->age,
                'gender'=>$gender,
                'citizenship_number'=>$patient->citizenship_number,
                'address'=>$patient->tole,
                'disease_type'=>$patient->disease->name,
                'hospital'=>$patient->hospital ? $patient->hospital->name : '',
                'description'=>$patient->description
            ];
            $data[] = $patientData;
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'लाभग्राहिको नाम थर', //A
            'लाभग्राहिको नाम थर (En)', //A
            'उमेर', //C
            'लिङ्ग', //B
            'नागरिकता प्र.प.नं/ जन्मदर्ता नं. ',
            'ठेगाना', //D
            'रोगको किसिम',  //E
            ' उपचार गरेको अस्पताल ', //F
            'कैफियत' //L
        ];
    }

    public function styles(Worksheet $sheet)
    {


        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', "अनुसूची-२");
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setWrapText(true);

        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', " ( दफा ४ उप दफा (1) को खण्ड (घ) संग सम्बन्धित )");
        $sheet->getStyle('A2')->getFont()->setSize(12);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setWrapText(true);

        $sheet->mergeCells('A3:I3');
        $sheet->setCellValue('A3', " स्थानिय तहले राख्ने बिरामीको अभिलेख");
        $sheet->getStyle('A3')->getFont()->setSize(12);
        $sheet->getRowDimension('3')->setRowHeight(20);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3')->getAlignment()->setWrapText(true);

        $sheet->mergeCells('A4:I4');
        $sheet->setCellValue('A4', " स्थानीय तहको नाम:");
        $sheet->getStyle('A4')->getFont()->setSize(12);
        $sheet->getRowDimension('4')->setRowHeight(20);
        $sheet->getStyle('A4')->getAlignment()->setWrapText(true);

        $sheet->mergeCells('A5:I5');
        $sheet->setCellValue('A5', "  आर्थिक वर्ष: २०८१/०८२ ");
        $sheet->getStyle('A5')->getFont()->setSize(12);
        $sheet->getRowDimension('5')->setRowHeight(20);
        $sheet->getStyle('A5')->getAlignment()->setWrapText(true);

        $headingsRow = 6;
        $sheet->fromArray($this->headings(), null, 'A' . $headingsRow);

        $dataRow = $headingsRow + 1;

        $dataArray = $this->array();
        $sheet->fromArray($dataArray, null, 'A' . $dataRow);

        $sheet->getStyle('A' . $headingsRow . ':I' . $headingsRow)->getFont()->setBold(true);

        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A6:I' . $sheet->getHighestRow())->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A1:I1')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A2:I2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:I1')->getFont()->setBold(false);

        $columns = range('A', 'I');
        $columnWidths = [
            'A' => 17,
            'B' => 17,
            'C' => 10,
            'D' => 8,
            'E' => 18,
            'F' => 20,
            'G' => 15,
            'H' => 22,
            'I' => 10,
        ];
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
        $highestRow = $sheet->getHighestRow();
        for ($row = $headingsRow; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1); // Auto-size row height
        }
        $sheet->getStyle('A1:I' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }
}
