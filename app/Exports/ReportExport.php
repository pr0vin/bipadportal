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

class ReportExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $message;
    // protected $dateFrom;
    // protected $dateTo;
    protected $currentQuarter;
    public function __construct($message, $currentQuarter)
    {
        $this->message = $message;
        // $this->dateFrom = $dateFrom;
        // $this->dateTo = $dateTo;
        $this->currentQuarter = $currentQuarter;
    }
    public function collection()
    {


        $status = 'registered';
        $municipality_id = municipalityId();
        $organizations = Renew::with('patient');

        if (request('payment_status') == 'unpaid') {
            $organizations = $organizations->where('isPaid', 0);
        } else {
            $organizations = $organizations->where('isPaid', 1);
        }
        if (request('status') == "closed") {
            $organizations = $organizations->whereHas('patient', function ($query) {
                $query->whereNotNull('closed_date');
            });
        }
        if (request('status') == "renewed") {
            $year = Carbon::parse(ad_to_bs(today()->format('Y-m-d')))->format('Y');
            $month = Carbon::parse(ad_to_bs(today()->format('Y-m-d')))->format('m');
            $today = Carbon::parse($year . '-' . $month . '-2');
            $organizations = $organizations->whereHas('patient', function ($query) use ($today) {
                $query->whereHas('renews', function ($query1) use ($today) {
                    $query1->orderBy('id')->take(1)
                        ->whereDate('next_renew_date', '>=', $today);
                });
            });
        }

        if (request('status') == "not_renewed") {
            $year = Carbon::parse(ad_to_bs(today()->format('Y-m-d')))->format('Y');
            $month = Carbon::parse(ad_to_bs(today()->format('Y-m-d')))->format('m');
            $today = Carbon::parse($year . '-' . $month . '-2');
            $organizations = $organizations->whereHas('patient', function ($query) use ($today) {
                $query->whereHas('renews', function ($query1) use ($today) {
                    $query1->orderBy('id')->take(1)
                        ->whereDate('next_renew_date', '<=', $today);
                });
            });
        }


        $organizations = $organizations->whereHas('patient', function ($query2) use ($municipality_id) {
            $query2->where('address_id', $municipality_id);
        });
        $organizations = $organizations->latest()->get();
        $querter = $this->currentQuarter;
        $filteredOrganizations = $organizations->filter(function ($organization) use ($querter) {
            return $organization->current_renew_quarter === $querter;
        });
        return $filteredOrganizations->map(function ($renew) {
            $count = Renew::where('patient_id', $renew->patient_id)->count();
            return [
                'Patient Name' => $renew->patient->name ?? 'N/A',
                'Patient Gender' => $renew->patient->gender == 'Male' ? 'पु' : 'म',
                'Patient Age' => $renew->patient->age ?? 'N/A',
                'Address' => $renew->patient->ward_number,
                'Disease' => $renew->patient->disease_id ? $renew->patient->disease->name : 'N/A',
                'Registration Date' => $renew->patient->registered_date ?? 'N/A',
                'Citizenship Number' => $renew->patient->citizenship_number ?? 'N/A',
                'Month' => $renew->month ?? 'N/A',
                'rate' => $renew->price_rate ?? 'N/A',
                'total' => $renew->price_rate * $renew->month,
                'bank_account_number' => $renew->patient->bank_account_number,
                'Mobile Number' => $renew->patient->mobile_number ?? 'N/A',
                'Kaifiyat' => $count > 1 ? 'पुरानो' : 'नया',
            ];
        });
    }
    public function headings(): array
    {
        return [
            'लाभग्राहिको नाम थर', //A
            'लिङ्ग', //B
            'उमेर (बर्ष)', //C
            'ठेगाना', //D
            'रोगको किसिम',  //E
            'दर्ता मिति', //F
            'रा.प.प.नं../ना.प्र.प.नं./जन्म दर्ता प्र.प.नं.', //G
            'भुक्तानी पाएको(महिना)', //H
            'दर', //I
            'जम्मा रु', //J
            'लाभ ग्राहिको बैंक/खाता नं', //K
            'मोबाइल नम्बर', //L
            'कैफियत' //M
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
            'J' => 6,
            'K' => 20,
            'L' => 20,
            'M' => 15,
        ];
    }
    public function styles(Worksheet $sheet)
    {


        $sheet->mergeCells('A1:M1');
        $sheet->setCellValue('A1', Address::find(municipalityId())->municipality);
        $sheet->getStyle('A1')->getFont()->setSize(14)->setBold(true);
        $sheet->getRowDimension('1')->setRowHeight(30);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getAlignment()->setWrapText(true); // Enable text wrapping for this cell

        $sheet->mergeCells('A2:M2');
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

        // Style headings
        $sheet->getStyle('A' . $headingsRow . ':M' . $headingsRow)->getFont()->setBold(true);

        // Style and align cells
        $sheet->getStyle('A1:M1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:M2')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A3:M3')->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A2:M' . $sheet->getHighestRow())->getAlignment()->setHorizontal('center')->setVertical('center');
        $sheet->getStyle('A1:M1')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A2:M2')->getAlignment()->setWrapText(true); // Enable text wrapping for this cell
        $sheet->getStyle('A1:M1')->getFont()->setBold(false);

        // Set column widths
        $columns = range('A', 'M');
        $columnWidths = [
            'A' => 25,
            'B' => 4,
            'C' => 6,
            'D' => 20,
            'E' => 20,
            'F' => 15,
            'G' => 18,
            'H' => 8,
            'I' => 5,
            'J' => 6,
            'K' => 20,
            'L' => 20,
            'M' => 15,
        ];
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }
        $highestRow = $sheet->getHighestRow();
        for ($row = $headingsRow; $row <= $highestRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(-1); // Auto-size row height
        }
        $sheet->getStyle('A1:M' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
    }
}
