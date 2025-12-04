<?php

namespace App\Exports;

use App\Address;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaymentExport implements FromArray,WithHeadings,WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $totalRenew;
    protected $message;
    public function __construct($totalRenew,$message)
    {
        $this->totalRenew = $totalRenew;
        $this->$message=$message;
    }

    public function array(): array
    {
        $data = [];
        foreach($this->totalRenew as $renew){
            // dd($renew->id);
            $gender=$renew->patient->gender;
            if(strtolower($gender) == 'male'){
                $gender="पुरुष";
            }elseif(strtolower($gender) == 'female'){
                $gender="महिला";
            }else{
                $gender="अन्या";
            }
            $patientData=[
                'name'=>$renew->patient->name,
                'name_en'=>$renew->patient->name_en,
                'gender'=>$gender,
                'age'=>$renew->patient->age,
                'address'=>$renew->patient->address->municipality.'-'.$renew->patient->ward_number,
                'disease'=>$renew->patient->disease->name,
                'register_date'=>$renew->patient->registered_date,
                'citizenship_number'=>$renew->patient->citizenship_number,
                'month'=>$renew->month,
                'price_rate'=>$renew->price_rate,
                'total_price'=>$renew->price_rate*$renew->month,
                'mobile_number'=>$renew->patient->mobile_number
            ];
            $data[] = $patientData;
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'लाभग्रहिको नाम',
            'लाभग्रहिको नाम (en)',
            'लिङ्ग',
            'उमेर(बर्ष)',
            'ठेगाना',
            'रोगको किसिम',
            'दर्ता मिति',
            'रा.प.प.नं./ना.प्र.प.नं./जन्म दर्ता प्र.प.नं.',
            'भुक्तानी पाउने(महिना)',
            'दर',
            'जम्मा रु',
            'मोबाइल नम्बर',
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $title="मृर्गौला प्रत्यारोपण गरेका, डायलासिस गराई रहेका, क्यान्सर रोगी र मेरुदण्ड पक्षघातका बिरामीहरुलाई औषधि उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम मासिक रु. ५ हजारका दरले रकम भुक्तानी दिएको बिबरण(आ. व.".currentFiscalYear()->name.") ";

        $sheet->mergeCells('A1:L1');
        $sheet->setCellValue('A1', Address::find(municipalityId())->municipality);
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(30);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setWrapText(true);

        $sheet->mergeCells('A2:L2');
        $sheet->setCellValue('A2', $title);
        $sheet->getStyle('A2')->getFont()->setSize(12);
        $sheet->getRowDimension('2')->setRowHeight(40);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setWrapText(true);
        $headingsRow = 3;
        $sheet->fromArray($this->headings(), null, 'A' . $headingsRow);

        $dataRow = $headingsRow + 1;
        // $sheet->fromArray($this->collection()->toArray(), null, 'A' . $dataRow);

        $dataArray = $this->array(); // Replace this with your actual method to get the array
        $sheet->fromArray($dataArray, null, 'A' . $dataRow);
        // // Style and align cells
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:L2')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A3:L3')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:L' . $sheet->getHighestRow())->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A1:L1')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A2:L2')->getAlignment()->setWrapText(true); // Enable text wrapping for this cell
        $sheet->getStyle('A1:L1')->getFont()->setBold(false);

        // // Set column widths
        $columns = range('A', 'L');
        $columnWidths=[
            'A' => 20,
            'B' => 20,
            'C' => 6,
            'D' => 10,
            'E' => 20,
            'F' => 12,
            'G' => 15,
            'H' => 10,
            'I' => 10,
            'J' => 7,
            'K' => 7,
            'L' => 15,
        ];
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
        $highestRow = $sheet->getHighestRow();
        for ($row = $headingsRow; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1);
        }
        $sheet->getStyle('A1:L' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }

}
