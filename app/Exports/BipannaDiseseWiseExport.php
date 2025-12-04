<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BipannaDiseseWiseExport implements FromArray,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $patientLists;

    public function __construct($patientLists)
    {
        $this->patientLists = $patientLists;
    }
    public function array(): array
    {
        $data = [];
        foreach ($this->patientLists as $patient) {
            $data[] = [
                'disease' => $patient['disease'] ?? '',
                'female' => $patient['female'] ?? 0,
                'male' => $patient['male'] ?? 0,
                'other' => $patient['other'] ?? 0,
                'total' => $patient['total'] ?? 0,

                'femaleRegistered' => $patient['femaleRegistered'] ?? 0,
                'maleRegistered' => $patient['maleRegistered'] ?? 0,
                'otherRegistered' => $patient['otherRegistered'] ?? 0,
                'totalRegistered' => $patient['totalRegistered'] ?? 0,
            ];
            // dd($patient['hospital']);
        }
        return $data;
    }

    public function headings(): array
    {
        return [
            'रोग', //A
            'महिला', //B
            'पुरुष', //C
            'अन्य', //D
            'जम्मा',  //E

            'महिला (सिफारिस भएका)', //B
            'पुरुष (सिफारिस भएका)', //C
            'अन्य (सिफारिस भएका)', //D
            'जम्मा (सिफारिस भएका)',  //E
        ];
    }
}
