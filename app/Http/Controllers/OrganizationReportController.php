<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\Renew;
use App\Disease;
use App\Patient;
use App\Distribution;
use App\PatientApplicationDisease;
use App\Hospital;
use App\DistributionDetail;
use Carbon\Carbon;
use App\FiscalYear;
use App\Exports\DataExport;
use Illuminate\Http\Request;
use App\Exports\DirghaExport;
use App\Exports\ReportExport;
use Illuminate\Support\Facades\DB;
use Psy\CodeCleaner\ReturnTypePass;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Exports\BipannaDiseseWiseExport;
use App\Exports\BipannaHospitalWiseExport;
use App\Exports\ReliefDistributionExport;
use App\Exports\SamajikExport;
use App\Exports\ResourceDistributionExport;


class OrganizationReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if (!municipalityId()) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }

        $title = 'रिपोर्ट';
        $period = null;
        $currentQuarter = null;
        if (request('quarter')) {
            $currentQuarter = request('quarter');
        }

        if ($currentQuarter == 1) {
            $period = 4;
        } elseif ($currentQuarter == 2) {
            $period = 7;
        } elseif ($currentQuarter == 3) {
            $period = 10;
        } else {
            $period = 1;
        }


        $diseases = Disease::whereHas('application_types', function ($query) {
            $query->where('application_types.id', 1);
        })->get();

        $patients = Renew::with('patient')->whereHas('patient', function ($query) {
            $query->where('address_id', municipalityId());
        });




        if ($request->isPaid == 'paid') {
            $patients = $patients->where('isPaid', 1);
        } else {
            $patients = $patients->where('isPaid', 0);
        }
        if ($request->name) {
            $name = $request->name;
            $patients = $patients->whereHas('patient', function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%')->orWhere('name_en', 'like', '%' . $name . '%');
            });
        }
        if ($request->disease_id) {
            $disease_id = $request->disease_id;
            $patients = $patients->whereHas('patient', function ($query) use ($disease_id) {
                $query->where('disease_id', $disease_id);
            });
        }

        if ($request->fiscal_year) {
            $patients = $patients->where('fiscal_year_id', $request->fiscal_year);
        } else {
            $patients = $patients->where('fiscal_year_id', currentFiscalYear()->id);
        }
        if ($request->ward) {
            $ward = $request->ward;
            $patients = $patients->whereHas('patient', function ($query) use ($ward) {
                $query->where('ward_number', $ward);
            });
        }
        if (request('gender')) {
            $gender = strtolower(request('gender')); // Convert to lowercase

            $patients = $patients->whereHas('patient', function ($query) use ($gender) {
                $query->whereRaw('LOWER(gender) = ?', [$gender]); // Use LOWER function for case-insensitivity
            });
        }
        $patients = $patients->latest()->get()->groupBy('patient_id');
        $patientsList = [];
        foreach ($patients as $patient) {


            $patientsList[] = [
                'patient_name' => $patient[0]->patient->name,
                'patient_name_en' => $patient[0]->patient->name_en,
                'patient_dob' => $patient[0]->patient->dob ?? '',
                'patient_closed_date' => $patient[0]->patient->closed_date,
                'patient_gender' => $patient[0]->patient->gender,
                'patient_address' => $patient[0]->patient->address->municipality . " - " . $patient[0]->patient->ward_number . ' , ' . $patient[0]->patient->tole,
                'patient_citizenship_number' => $patient[0]->patient->citizenship_number,
                'patient' => $patient,
                'doctor' => $patient[0]->patient->doctor,
            ];
        }

        $months = [4, 5, 6, 7, 8, 9, 10, 11, 12, 1, 2, 3];
        if ($request->excel) {
            $title = 'औषधि उपचार बापत खर्च पाउने व्यक्तिहरुको अभिलेख राख्ने ढाँचा';
            if ($request->isPaid == 'paid') {
                $title = 'औषधि उपचार बापत खर्च पाएका व्यक्तिहरुको अभिलेख राख्ने ढाँचा';
            }
            return Excel::download(new DirghaExport($patientsList, $months, $title), 'दिर्घ मासिक उपचार खर्च रिपोर्ट.xlsx');
        }

        // return $patientsList;
        return view('organization.report.dirghaReport.index', compact('diseases', 'patientsList', 'months'));
    }

    // public function dirghaReport(Request $request)
    // {

    //     if (!municipalityId()) {
    //         return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
    //     }
    //     $todayDate = ad_to_bs(now()->format('Y-m-d'));
    //     $year = Carbon::parse($todayDate)->format('Y');
    //     $month = Carbon::parse($todayDate)->format('m');
    //     if ($month + 3 > 12) {
    //         $year = $year + 1;
    //     }
    //     $oldMonth = $month;
    //     $month = $month + 3;
    //     if ($month == 13) {
    //         $month = 1;
    //     }
    //     if ($month == 14) {
    //         $month = 2;
    //     }
    //     if ($month == 15) {
    //         $month = 3;
    //     }
    //     $fiscalYear = FiscalYear::where('is_running', 1)->first();

    //     if (!$fiscalYear) {
    //         return redirect()->back()->with('error', 'Please active a fiscal year');
    //     }

    //     if ($request->date_from) {
    //         $dateFrom = $request->date_from[0];
    //     }
    //     if ($request->date_to) {
    //         $dateTo = $request->date_to[0];
    //     }

    //     if ($request->diseaseType == 1) {
    //         $fileName = "दीर्घरोगी मासिक उपचार खर्च.xlsx";
    //         if (request('payment_status' == "upaid")) {

    //             $message = "मृर्गौला प्रत्यारोपण गरेका, डायलासिस गराई रहेका, क्यान्सर रोगी र मेरुदण्ड पक्षघातका बिरामीहरुलाई औषधि उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम
    //                             मासिक रु. ५ हजारका दरले रकम भुक्तानी नदिएको विवरण";
    //         } else {
    //             $message = "मृर्गौला प्रत्यारोपण गरेका, डायलासिस गराई रहेका, क्यान्सर रोगी र मेरुदण्ड पक्षघातका बिरामीहरुलाई औषधि उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम
    //             मासिक रु. ५ हजारका दरले रकम भुक्तानी पाएका विवरण";
    //         }
    //     } elseif ($request->diseaseType == 2) {
    //         $fileName = "बिपन्न सहयोगको सिफारिस.xlsx";
    //         $message = " विपन्न नागरिक बिरामीहरुलाई औषधी उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम मासिक रू. ५००० का दरलेरकम भुक्तानी दिएको विवरण";
    //     } elseif ($request->diseaseType == 3) {
    //         $fileName = "सामाजिक विकास मन्त्रालय.xlsx";
    //         $message = "सामाजिक विकास मन्त्रालय औषधी उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम मासिक रू. ५००० का दरलेरकम भुक्तानी दिएको विवरण";
    //     } elseif ($request->diseaseType == 4) {
    //         $fileName = "नगरपालिका.xlsx";
    //         $message = "नगरपालिका औषधी उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम मासिक रू. ५००० का दरलेरकम भुक्तानी दिएको विवरण ";
    //     }

    //     $message = $message . "(आ. व." . $fiscalYear->name;
    //     if ($request->date_from) {
    //         $message = $message . " मिति " . englishToNepaliLetters($dateFrom) . " देखि ";
    //     }
    //     if ($request->date_to) {

    //         $message = $message  . englishToNepaliLetters($dateTo) . " सम्म";
    //     }
    //     $message = $message . ")";
    //     $currentQuarter = null;
    //     if (request('quarter')) {
    //         $currentQuarter = (int)request('quarter');
    //     } else {
    //         $currentQuarter = currentquarter();
    //     }

    //     if ($request->excel) {
    //         if ($request->diseaseType == 1) {
    //             return Excel::download(new ReportExport($message, $currentQuarter), $fileName);
    //         } else {
    //             return Excel::download(new DataExport($message, $dateFrom, $dateTo), $fileName);
    //         }
    //     }


    //     $applicationTypeId = $request->diseaseType ?? 1;

    //     $title = 'रिपोर्ट';
    //     return view('organization.report.index', [
    //         'title' => $title,
    //         'message' => $message,
    //         // 'diseaseCounts' => $diseaseCounts,
    //         'applicationTypeId' => $applicationTypeId,
    //     ]);
    // }



    public function dirghaReport(Request $request)
    {

        if (!municipalityId()) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }

        // ===============================
        // Nepali date + quarter logic
        // ===============================
        $todayDate = ad_to_bs(now()->format('Y-m-d'));
        $year  = Carbon::parse($todayDate)->format('Y');
        $month = Carbon::parse($todayDate)->format('m');

        if ($month + 3 > 12) {
            $year++;
        }

        $month += 3;
        if ($month > 12) {
            $month -= 12;
        }

        // ===============================
        // Fiscal year check
        // ===============================
        $fiscalYear = FiscalYear::where('is_running', 1)->first();

        if (!$fiscalYear) {
            return redirect()->back()->with('error', 'Please active a fiscal year');
        }

        // ===============================
        // Filters
        // ===============================
        $dateFrom = $request->date_from[0] ?? null;
        $dateTo   = $request->date_to[0] ?? null;

        $applicationTypeId = $request->diseaseType ?? 1;

        $message = 'प्रकोपको सङख्या र क्षतिको विवरण';
        $title   = 'रिपोर्ट';

        // ===============================
        // Build SAME data as Livewire
        // ===============================
        $applicationTypeCounts = PatientApplicationDisease::with([
            'disease',
            'patientApplication.application_type',
            'patientApplication.patient'
        ])
            ->whereHas('patientApplication.patient', function ($query) {
                $query->whereNotNull('verified_date');
            })
            ->when($dateFrom, function ($q) use ($dateFrom) {
                $q->whereHas('patientApplication', function ($qq) use ($dateFrom) {
                    $qq->where('registered_date', '>=', $dateFrom);
                });
            })
            ->when($dateTo, function ($q) use ($dateTo) {
                $q->whereHas('patientApplication', function ($qq) use ($dateTo) {
                    $qq->where('registered_date', '<=', $dateTo);
                });
            })
            ->get()
            ->groupBy(
                fn($item) =>
                $item->patientApplication->application_type->name ?? 'Unknown'
            )
            ->map(function ($diseases, $typeName) {

                $totalLoss = $diseases->sum(
                    fn($d) =>
                    $d->patientApplication->patient->estimated_amount ?? 0
                );

                return (object) [
                    'name' => $typeName,
                    'diseases' => $diseases->map(function ($d) {
                        return (object) [
                            'disease_id'    => $d->disease_id,
                            'disease_name'  => $d->disease->name ?? 'Unknown',
                            'patient_count' => 1,
                        ];
                    }),
                    'estimated_loss' => $totalLoss,
                ];
            })
            ->values();

        // ===============================
        // Excel export
        // ===============================
        if ($request->has('excel')) {
            return Excel::download(
                new ReportExport($applicationTypeCounts),
                'प्रकोपको सङख्या र क्षतिको विवरण.xlsx'
            );
        }

        // ===============================
        // Normal view (Livewire loads data again)
        // ===============================
        return view('organization.report.index', [
            'title'              => $title,
            'message'            => $message,
            'applicationTypeId'  => $applicationTypeId,
        ]);
    }



    public function reliefReport(Request $request)
    {

        if (!municipalityId()) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }


        if ($request->has('excel')) {
            return Excel::download(
                new ReliefDistributionExport($request),
                'relief_distribution_report.xlsx'
            );
        }


        $patientsQuery = Patient::query()->whereNotNull('verified_date')->where('status', 'paid')->whereHas('paymentDetails.payment');


        if ($request->filled('fiscal_year_id')) {
            $patientsQuery->whereHas('paymentDetails.payment', function ($q) use ($request) {
                $q->where('fiscal_year_date', $request->fiscal_year_id);
            });
        }


        if ($request->filled('from_date') || $request->filled('to_date')) {

            $patientsQuery->whereHas('paymentDetails.payment', function ($q) use ($request) {

                if ($request->filled('from_date')) {
                    $q->whereDate('paid_date', '>=', $request->from_date);
                }

                if ($request->filled('to_date')) {
                    $q->whereDate('paid_date', '<=', $request->to_date);
                }
            });
        }


        $patients = $patientsQuery
            ->with([
                'paymentDetails.payment' => function ($q) {
                    $q->latest();
                }
            ])->get();

        return view('livewire.ReliefDistributionReport', [
            'reliefDetails' => $patients
        ]);
    }





    public function resourceDistributionReport(Request $request)
    {
        if (!municipalityId()) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }

        if ($request->excel) {
            return Excel::download(
                new ResourceDistributionExport('राहत उद्धार सामग्रीहरुको विवरण'),
                'resource_distribution_report.xlsx'
            );
        }

        $resourceDetails = DistributionDetail::with([
            'resource.unit',
            'distribution'
        ])
            ->whereHas('distribution', function ($q) {
                $q->where('type', 0)
                    ->whereNull('deleted_at');
            })
            ->latest()
            ->get();

        return view(
            'livewire.ResourceDistributionReport',
            compact('resourceDetails')
        );
    }



    public function registeredPatientReport()
    {
        $patients =  Patient::with('address')->where('address_id', municipalityId())->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 2);
        })->whereNotNull('registered_date')->get();

        return view('organization.report.bipanna.registeredReport', compact('patients'));
    }
}
