<?php

namespace App\Exports;

use App\Address;
use App\Renew;
use App\Patient;
use Carbon\Carbon;
use App\Municipality;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DataExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $message;
    protected $dateFrom;
    protected $dateTo;
    public function __construct($message, $dateFrom, $dateTo)
    {
        $this->message = $message;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
    public function collection()
    {
        $fromDate = $this->dateFrom;
        $toDate = $this->dateTo;


        $status = 'registered';
        $municipality_id = municipalityId();
        $patients = Patient::with('disease.application_types')->where('address_id', $municipality_id);
        $patients = $patients->whereNotNull('verified_date');
        $patients = $patients->whereNotNull('registered_date');
        $patients = $patients->whereNull('closed_date');
        $patients = $patients->whereHas('disease.application_types', function ($query){
            $query->where('application_types.id', request('diseaseType'));
        });
        if (request('name')) {
            $patients = $patients->where('name','like','%'.request('name').'%');
        }
        if (request('disease_id')) {
            $patients = $patients->where('disease_id',request('disease_id'));
        }
        if (request('date_from')) {
            $patients = $patients->where('registered_date', '>=', $fromDate);
        }
        if (request('date_to')) {
            $patients = $patients->where('registered_date', '<=', $toDate);
        }
        if (request('ward')) {
            $patients = $patients->where('ward_number',request('ward'));
        }
        if (request('gender')) {
            $patients = $patients->where('gender',request('gender'));
        }
        if (request('status') == "closed") {
            $patients = $patients->whereNotNull('closed_date');
        }
        // $patients = $patients->paginate(15);
            // $organizations = Renew::with('patient.municipality');





            $patients = $patients->latest()->get();
            // dd($patients);
            return $patients->map(function ($renew) {
                $count = Renew::where('patient_id', $renew->patient_id)->count();
                return [
                    'Patient Name' => $renew->name ?? 'N/A',
                    'Patient Gender' => $renew->gender == 'Male' ? 'पु' : 'म',
                    'Patient Age' => $renew->age ?? 'N/A',
                    'Address' => $renew->tole.'(वाड न.'.$renew->ward_number.')',
                    'Disease' => $renew->disease_id ? $renew->disease->name : 'N/A',
                    'Registration Date' => $renew->registered_date ?? 'N/A',
                    'Citizenship Number' => $renew->citizenship_number ?? 'N/A',
                    // 'Month' => $renew->month ?? 'N/A',
                    // 'rate' => $renew->price_rate ?? 'N/A',
                    // 'total' => $renew->price_rate * $renew->month,
                    'Mobile Number' => $renew->mobile_number ?? 'N/A',
                    'Kaifiyat' => $count > 1 ? 'पुरानो' : 'नया',
                ];
            });
    }
    public function headings(): array
    {
        return [
            'बिरामीको नाम', //A
            'उमेर', //B
            'लिङ्ग', //C
            'नागरिकता प्र.प.नं/ जन्मदर्ता नं. ', //D
            'ठेगाना',  //E
            'रोगको किसिम ', //F
            ' उपचार गरेको अस्पताल ',
            'कैफियत' //L
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 4,
            'C' => 6,
            'D' => 20,
            'E' => 20,
            'F' => 15,
            'G' => 18,
            'H' => 8,
            'I' => 5,
            // 'J' => 6,
            // 'K' => 20,
            // 'L' => 15,
        ];
    }
    public function styles(Worksheet $sheet)
    {


        $sheet->mergeCells('A1:I1');
        $sheet->setCellValue('A1', Address::find(municipalityId())->municipality);
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(30);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setWrapText(true); // Enable text wrapping for this cell

        $sheet->mergeCells('A2:I2');
        $sheet->setCellValue('A2', $this->message);
        $sheet->getStyle('A2')->getFont()->setSize(12);
        $sheet->getRowDimension('2')->setRowHeight(40); // Adjust row height to accommodate text wrapping
        $sheet->getStyle('A2')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A2')->getAlignment()->setWrapText(true); // Enable text wrapping for this cell

        // Add headings and data
        $headingsRow = 3;
        $sheet->fromArray($this->headings(), null, 'A' . $headingsRow);

        $dataRow = $headingsRow + 1;
        $sheet->fromArray($this->collection()->toArray(), null, 'A' . $dataRow);

        // // Style headings
        $sheet->getStyle('A' . $headingsRow . ':G' . $headingsRow)->getFont()->setBold(true);

        // // Style and align cells
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:I2')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A3:I3')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:I' . $sheet->getHighestRow())->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A1:I1')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A2:I2')->getAlignment()->setWrapText(true); // Enable text wrapping for this cell
        $sheet->getStyle('A1:I1')->getFont()->setBold(false);

        // // Set column widths
        $columns = range('A', 'L');
        $columnWidths=[
            'A' => 25,
            'B' => 4,
            'C' => 6,
            'D' => 20,
            'E' => 20,
            'F' => 15,
            'G' => 18,
            'H' => 8,
            'I' => 5,
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
