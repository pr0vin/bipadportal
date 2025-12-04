<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DirghaExport implements FromArray, WithHeadings, WithColumnWidths,WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $patientLists;
    protected $months;
    protected $title;
    public function __construct($patientLists, $months,$title)
    {
        $this->patientLists = $patientLists;
        $this->months = $months;
        $this->title=$title;
    }
    public function array(): array
    {
        $data = [];
        foreach ($this->patientLists as $patient) {
            $patientGender = '';
            if (strtolower($patient['patient_gender']) == 'female') {
                $patientGender = 'महिला';
            } elseif (strtolower($patient['patient_gender']) == 'male') {
                $patientGender = 'पुरुष';
            } else {
                $patientGender = 'अन्य';
            }

            // Initialize the data array for each patient
            $patientData = [
                'name' => $patient['patient_name'],
                'name_en' => $patient['patient_name_en'],
                'age' => $patient['patient_dob'],
                'patientGender' => $patientGender,
                'address' => $patient['patient_address'],
                'citizenship' => $patient['patient_citizenship_number'],
                'group' => "",
                'doctor' => $patient['doctor'] ? $patient['doctor']->name.",NMC No:-".$patient['doctor']->nmc_no : '',
                // 'months' => [] // Array to hold month data
            ];

            foreach ($this->months as $month) {
                $isDataAvailable = false;
                foreach ($patient['patient'] as $item) {
                    if ($month > renewMonth($item->next_renew_date) - $item->month && $month <= renewMonth($item->next_renew_date)) {
                        $patientData[] =
                            $item->price_rate;
                        $isDataAvailable = true;
                    }
                }
                // If no data is available, push a default value
                if (!$isDataAvailable) {
                    $patientData[] =
                        "0";
                }
            }

            // Push the patient data to the main data array
            $data[] = $patientData;
        }

        return $data;
    }

    public function headings(): array
    {
        return [
            'लाभग्रहिको नाम', //A
            'लाभग्रहिको नाम (en)', //B
            'जन्म मिति', //C
            'लिङ्ग', //D
            'स्थायी ठेगाना',  //E

            'राष्ट्रिय परिचयपत्र नं/नागरिकता प्रमाणपत्र नं/जन्मदर्ता प्रमाणपत्र नं', //F
            'लक्षित समूह', //F
            'सिफारिस गर्ने चिकित्सकको बिवरण (नाम, कार्यरत संस्था र नेपाल मेडिकल काउन्सिल नं.)', //H
            'साउन',  //I
            'भदौ', //J
            'असोज', //K
            'कार्तिक', //L
            'मङ्सिर', //M
            'पौष', //N
            'माघ', //O
            'फाल्गुण', //P
            'चैत्र', //Q
            'बैशाख', //R
            'ज्येष्ठ', //S
            'आषाढ', //T
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 17,
            'B' => 17,
            'C' => 10,
            'D' => 8,
            'E' => 18,
            'F' => 20,
            'G' => 15,
            'H' => 22,
            'I' => 6,
            'J' => 5,
            'K' => 6,
            'L' => 7,
            'M' => 7,
            'N' => 5,
            'O' => 5,
            'P' => 7,
            'Q' => 5,
            'R' => 6,
            'S' => 5,
            'T' => 7,
        ];
    }

    public function styles(Worksheet $sheet)
    {


        $sheet->mergeCells('A1:T1');
        $sheet->setCellValue('A1', "अनुसूची-४");
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(30);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setWrapText(true); // Enable text wrapping for this cell

        $sheet->mergeCells('A2:T2');
        $sheet->setCellValue('A2', "(दफा ७ संग सम्बन्धित)");
        $sheet->getStyle('A2')->getFont()->setSize(12);
        $sheet->getRowDimension('2')->setRowHeight(40); // Adjust row height to accommodate text wrapping
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setWrapText(true); // Enable text wrapping for this cell

        $sheet->mergeCells('A3:T3');
        $sheet->setCellValue('A3', $this->title);
        $sheet->getStyle('A3')->getFont()->setSize(12);
        $sheet->getRowDimension('3')->setRowHeight(40); // Adjust row height to accommodate text wrapping
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3')->getAlignment()->setWrapText(true);

        // Add headings and data
        $headingsRow = 4;
        $sheet->fromArray($this->headings(), null, 'A' . $headingsRow);

        $dataRow = $headingsRow + 1;
        // $sheet->fromArray($this->collection()->toArray(), null, 'A' . $dataRow);

        $dataArray = $this->array(); // Replace this with your actual method to get the array
        $sheet->fromArray($dataArray, null, 'A' . $dataRow);

        // Style headings
        $sheet->getStyle('A' . $headingsRow . ':T' . $headingsRow)->getFont()->setBold(true);

        // Style and align cells
        $sheet->getStyle('A1:T1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:T2')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A3:T3')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:T' . $sheet->getHighestRow())->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A1:T1')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A2:T2')->getAlignment()->setWrapText(true); // Enable text wrapping for this cell
        $sheet->getStyle('A1:T1')->getFont()->setBold(false);

        // Set column widths
        $columns = range('A', 'T');
        $columnWidths = [
            'A' => 17,
            'B' => 17,
            'C' => 10,
            'D' => 8,
            'E' => 18,
            'F' => 20,
            'G' => 15,
            'H' => 22,
            'I' => 6,
            'J' => 5,
            'K' => 8,
            'L' => 7,
            'M' => 8,
            'N' => 5,
            'O' => 5,
            'P' => 8,
            'Q' => 5,
            'R' => 7,
            'S' => 5,
            'T' => 7,
        ];
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
        $highestRow = $sheet->getHighestRow();
        for ($row = $headingsRow; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1); // Auto-size row height
        }
        $sheet->getStyle('A1:T' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }
}
