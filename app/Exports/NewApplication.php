<?php

namespace App\Exports;

use App\User;
use App\Address;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NewApplication implements FromArray, WithHeadings,WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $patients;
    protected $status;
    protected $applicationType;

    public function __construct($patients, $status, $applicationType)
    {
        $this->patients = $patients;
        $this->status = $status;
        $this->applicationType = $applicationType;
    }
    public function array(): array
    {
        $data = [];
        foreach ($this->patients as $patient) {
            $gender = "";
            $reg_date = "";
            $tokenNumber = "";
            $patientGender = strtolower($patient->gender ?? '');

            if ($patientGender == 'male') {
                $gender = 'पुरुष';
            } elseif ($patientGender == 'female') {
                $gender = 'महिला';
            } else {
                $gender = 'अन्य';
            }

            if ($patient->registered_date) {
                $reg_date = dateFormat($patient->registered_date);
                $tokenNumber=$patient->registration_number;
            } else {
                $reg_date = ad_to_bs($patient->applied_date);
                $tokenNumber=$patient->onlineApplication->token_number;
            }
            if($patient->closed_date){
                $reg_date = dateFormat($patient->closed_date);
             }
             if($this->status == 'renew'){
                $reg_date = dateFormat($patient->closed_date);
             }
            $data[] = [
                'Token number' => $tokenNumber,
                'Reg_date' => $reg_date,
                'Patient_name' => $patient->name,
                'Patient_name_en' => $patient->name_en,
                'Gender' => $gender,
                'Disease' => $patient->disease->name,
                'contact_person' => $patient->contact_person,
                'contact_person_contact_number' => $patient->mobile_number,
            ];
        }
        return $data;
    }

    public function headings(): array
    {
        if ($this->status  == 'new') {

            return [
                'टोकन नं.', //A
                'आवेदन मिति', //B
                'बिरामीको नाम', //C
                'बिरामीको नाम (English)', //D
                'लिंग',  //E
                'रोग', //F
                'सम्पर्क व्यक्ति नाम थर', //G
                'सम्पर्क नम्बर', //H
            ];
        }
        if ($this->status  == 'registered') {
            return [
                'दर्ता नं.', //A
                'दर्ता मिति', //B
                'बिरामीको नाम', //C
                'बिरामीको नाम (English)', //D
                'लिंग',  //E
                'रोग', //F
                'सम्पर्क व्यक्ति नाम थर', //G
                'सम्पर्क नम्बर', //H
            ];
        }
        if ($this->status  == 'closed') {
            return [
                'दर्ता नं.', //A
                'लागतकट्टा मिति', //B
                'बिरामीको नाम', //C
                'बिरामीको नाम (English)', //D
                'लिंग',  //E
                'रोग', //F
                'सम्पर्क व्यक्ति नाम थर', //G
                'सम्पर्क नम्बर', //H
            ];
        }
        if ($this->status  == 'renew' || $this->status == 'dateExpired') {
            return [
                'दर्ता नं.', //A
                'नबिकरण मिति', //B
                'बिरामीको नाम', //C
                'बिरामीको नाम (English)', //D
                'लिंग',  //E
                'रोग', //F
                'सम्पर्क व्यक्ति नाम थर', //G
                'सम्पर्क नम्बर', //H
            ];
        }
    }


    public function styles(Worksheet $sheet)
    {
        if($this->status == 'new'){
            $applicationType='(नयाँ आबेदन हरु)';
        }elseif($this->status == 'registered'){
            $applicationType='(दर्ता/सिफारिस भएका)';
        }elseif($this->status == 'closed'){
            $applicationType='(लागतकट्टा भएका)';
        }elseif($this->status == 'renew'){
            $applicationType='(नबिकरण भएका)';
        }elseif($this->status == 'dateExpired'){
            $applicationType='(नबिकरण नभएका)';
        }

        $sheet->mergeCells('A1:H1');
        $sheet->setCellValue('A1', Address::find(municipalityId())->municipality);
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(20);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setWrapText(true);

        $sheet->mergeCells('A2:H2');
        $sheet->setCellValue('A2', $this->applicationType);
        $sheet->getStyle('A2')->getFont()->setSize(12);
        $sheet->getRowDimension('2')->setRowHeight(20);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setWrapText(true);

        $sheet->mergeCells('A3:H3');
        $sheet->setCellValue('A3', $applicationType);
        $sheet->getStyle('A3')->getFont()->setSize(12);
        $sheet->getRowDimension('3')->setRowHeight(20);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A3')->getAlignment()->setWrapText(true);



        $headingsRow = 4;
        $sheet->fromArray($this->headings(), null, 'A' . $headingsRow);

        $dataRow = $headingsRow + 1;

        $dataArray = $this->array();
        $sheet->fromArray($dataArray, null, 'A' . $dataRow);

        $sheet->getStyle('A' . $headingsRow . ':H' . $headingsRow)->getFont()->setBold(true);

        $sheet->getStyle('A1:H1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:H2')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A3:H3')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A4:H' . $sheet->getHighestRow())->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A1:H1')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A2:H2')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:H1')->getFont()->setBold(false);

        $columns = range('A', 'H');
        $columnWidths = [
            'A' => 15,
            'B' => 17,
            'C' => 20,
            'D' => 20,
            'E' => 10,
            'F' => 15,
            'G' => 22,
            'H' => 18,
        ];
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
        $highestRow = $sheet->getHighestRow();
        for ($row = $headingsRow; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1); // Auto-size row height
        }
        $sheet->getStyle('A1:H' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }
}
