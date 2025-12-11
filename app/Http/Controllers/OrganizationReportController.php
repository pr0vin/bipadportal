<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\Renew;
use App\Disease;
use App\Patient;
use App\PatientApplicationDisease;
use App\Hospital;
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

class OrganizationReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // $permissions = [
        //     '1' => 'dirgha.report',
        //     '2' => 'bipanna.report',
        //     '3' => 'samajik.report',
        //     '4' => 'nagarpalika.report',
        // ];
        // $diseaseTypeId = checkPermission($permissions, request('diseaseType'));
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
            // foreach($patient as $item){

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
            // }
        }
        // return $patientsList;
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

    public function dirghaReport(Request $request)
    {
        // $permissions = [
        //     '1' => 'dirgha.report',
        //     '2' => 'bipanna.report',
        //     '3' => 'samajik.report',
        //     '4' => 'nagarpalika.report',
        // ];
        //  $diseaseTypeId = checkPermission($permissions, request('diseaseType'));
        if (!municipalityId()) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }
        $todayDate = ad_to_bs(now()->format('Y-m-d'));
        $year = Carbon::parse($todayDate)->format('Y');
        $month = Carbon::parse($todayDate)->format('m');
        if ($month + 3 > 12) {
            $year = $year + 1;
        }
        $oldMonth = $month;
        $month = $month + 3;
        if ($month == 13) {
            $month = 1;
        }
        if ($month == 14) {
            $month = 2;
        }
        if ($month == 15) {
            $month = 3;
        }
        $fiscalYear = FiscalYear::where('is_running', 1)->first();

        if (!$fiscalYear) {
            return redirect()->back()->with('error', 'Please active a fiscal year');
        }

        if ($request->date_from) {
            $dateFrom = $request->date_from[0];
        }
        if ($request->date_to) {
            $dateTo = $request->date_to[0];
        }

        if ($request->diseaseType == 1) {
            $fileName = "दीर्घरोगी मासिक उपचार खर्च.xlsx";
            if (request('payment_status' == "upaid")) {

                $message = "मृर्गौला प्रत्यारोपण गरेका, डायलासिस गराई रहेका, क्यान्सर रोगी र मेरुदण्ड पक्षघातका बिरामीहरुलाई औषधि उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम
                                मासिक रु. ५ हजारका दरले रकम भुक्तानी नदिएको विवरण";
            } else {
                $message = "मृर्गौला प्रत्यारोपण गरेका, डायलासिस गराई रहेका, क्यान्सर रोगी र मेरुदण्ड पक्षघातका बिरामीहरुलाई औषधि उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम
                मासिक रु. ५ हजारका दरले रकम भुक्तानी पाएका विवरण";
            }
        } elseif ($request->diseaseType == 2) {
            $fileName = "बिपन्न सहयोगको सिफारिस.xlsx";
            $message = " विपन्न नागरिक बिरामीहरुलाई औषधी उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम मासिक रू. ५००० का दरलेरकम भुक्तानी दिएको विवरण";
        } elseif ($request->diseaseType == 3) {
            $fileName = "सामाजिक विकास मन्त्रालय.xlsx";
            $message = "सामाजिक विकास मन्त्रालय औषधी उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम मासिक रू. ५००० का दरलेरकम भुक्तानी दिएको विवरण";
        } elseif ($request->diseaseType == 4) {
            $fileName = "नगरपालिका.xlsx";
            $message = "नगरपालिका औषधी उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम मासिक रू. ५००० का दरलेरकम भुक्तानी दिएको विवरण ";
        }

        $message = $message . "(आ. व." . $fiscalYear->name;
        if ($request->date_from) {
            $message = $message . " मिति " . englishToNepaliLetters($dateFrom) . " देखि ";
        }
        if ($request->date_to) {

            $message = $message  . englishToNepaliLetters($dateTo) . " सम्म";
        }
        $message = $message . ")";
        $currentQuarter = null;
        if (request('quarter')) {
            $currentQuarter = (int)request('quarter');
        } else {
            $currentQuarter = currentquarter();
        }
        // return $currentQuarter;
        if ($request->excel) {
            if ($request->diseaseType == 1) {
                return Excel::download(new ReportExport($message, $currentQuarter), $fileName);
            } else {
                return Excel::download(new DataExport($message, $dateFrom, $dateTo), $fileName);
            }
        }


        $applicationTypeId = $request->diseaseType ?? 1;

        $title = 'रिपोर्ट';
        return view('organization.report.index', [
            'title' => $title,
            'message' => $message,
            // 'diseaseCounts' => $diseaseCounts,
            'applicationTypeId' => $applicationTypeId,
        ]);
    }

    public function reliefReport(Request $request)
    {
        if (!municipalityId()) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }
        if ($request->excel) {

            $fileName = 'relief_distribution_report.xlsx';

            return Excel::download(
                new ReliefDistributionExport(municipalityId()),
                $fileName
            );
        }
        $reliefDetails = Patient::whereNotNull('verified_date')->get();

        return view('livewire.ReliefDistributionReport', compact('reliefDetails'));
    }


    public function periodSession(Request $request)
    {
        Session::put('renewalPeriod', $request->renewalPeriod);
        return redirect()->back();
    }

    public function hospitalWiseReport(Request $request)
    {
        $patients =  Patient::where('fiscal_year_id', currentFiscalYear()->id)->where('address_id', municipalityId())->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 2);
        });
        if (request('date_from')) {
            $dateFrom = request('date_from')[0];
        }
        if (request('date_to')) {
            $dateTo = request('date_to')[0];
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }

        if (request('date_from')) {
            $patients = $patients->where('registered_date', '>=', $dateFrom);
        }
        if (request('date_to')) {
            $patients = $patients->where('registered_date', '<=', $dateTo);
        }
        if (request('ward_number')) {
            $patients = $patients->where('ward_number', request('ward_number'));
        }
        if (request('gender')) {
            $patients = $patients->whereRaw('LOWER(gender) = ?', [strtolower(request('gender'))]);
        }

        $patients = $patients->get();

        $datas = [];
        $hospitals = Hospital::latest()->get();
        foreach ($hospitals as $hospital) {
            $total = $patients->where('hospital_id', $hospital->id)->count();

            // Case-insensitive gender counts
            $male = $patients->filter(function ($patient) use ($hospital) {
                return $patient->hospital_id == $hospital->id && strtolower($patient->gender) == 'male';
            })->count();

            $female = $patients->filter(function ($patient) use ($hospital) {
                return $patient->hospital_id == $hospital->id && strtolower($patient->gender) == 'female';
            })->count();

            $other = $patients->filter(function ($patient) use ($hospital) {
                return $patient->hospital_id == $hospital->id && strtolower($patient->gender) == 'other';
            })->count();

            // Add data to the array
            if ($total > 0) {

                $datas[] = [
                    'hospital' => $hospital->name,
                    'total' => $total,
                    'male' => $male,
                    'female' => $female,
                    'other' => $other,
                ];
            }
        }
        $datasCollection = collect($datas)->sortByDesc('total');
        $patientLists = $datasCollection->values()->all();
        if ($request->excel) {
            return Excel::download(new BipannaHospitalWiseExport($patientLists), 'bipanna hospital wise report.xlsx');
        }
        return view('organization.report.hospitalReport', compact('patientLists'));
    }

    public function registeredPatientReport()
    {
        $patients =  Patient::with('address')->where('address_id', municipalityId())->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 2);
        })->whereNotNull('registered_date')->get();

        return view('organization.report.bipanna.registeredReport', compact('patients'));
    }
    public function bipannaFinalReport(Request $request)
    {
        // Get the relevant diseases based on the application type
        $diseases = Disease::latest()->whereHas('application_types', function ($query) {
            $query->where('application_types.id', 2);
        })->get();

        // Pluck the disease IDs
        $diseaseIds = $diseases->pluck('id')->toArray();


        $patients = Patient::select('hospital_id', 'disease_id', DB::raw('count(*) as total_patients'))
            ->where('address_id', municipalityId());

        if ($request->fiscal_year_id) {
            $patients->where('fiscal_year_id', $request->fiscal_year_id);
        } else {
            $patients->where('fiscal_year_id', currentFiscalYear()->id);
        }
        $patients = $patients->whereNotNull('hospital_id')->whereIn('disease_id', $diseaseIds)
            ->whereHas('disease.application_types', function ($query) {
                $query->where('application_types.id', 2);
            })
            ->groupBy('hospital_id', 'disease_id')->get();;


        // Prepare data for the table
        $hospitalData = [];
        $hospitalTotalPatients = []; // To store the total patients per hospital
        $diseaseNames = Disease::whereIn('id', $diseaseIds)->pluck('name', 'id')->toArray();
        $hospitalNames = Hospital::pluck('name', 'id')->toArray(); // Assuming you have a Hospital model

        foreach ($patients as $patient) {
            // Store the count of patients by hospital and disease
            $hospitalData[$patient->hospital_id][$patient->disease_id] = $patient->total_patients;

            // Add the total count for the hospital
            if (!isset($hospitalTotalPatients[$patient->hospital_id])) {
                $hospitalTotalPatients[$patient->hospital_id] = 0;
            }
            $hospitalTotalPatients[$patient->hospital_id] += $patient->total_patients;
        }



        if ($request->fiscal_year_id) {
            $fiscalYear = FiscalYear::findOrFail($request->fiscal_year_id);
        } else {
            $fiscalYear = currentFiscalYear();
        }
        // return $hospitalData;
        if ($request->excel) {
            return Excel::download(new BipannaHospitalWiseExport($hospitalData, $diseaseNames, $hospitalNames, $hospitalTotalPatients), 'दिर्घ मासिक उपचार खर्च रिपोर्ट.xlsx');
        }




        // Pass data to the view
        return view('organization.report.bipanna.finalreport', compact('hospitalData', 'diseaseNames', 'hospitalNames', 'hospitalTotalPatients', 'fiscalYear'));
    }



    public function diseaseWiseReport(Request $request)
    {
        $patients =  Patient::where('fiscal_year_id', currentFiscalYear()->id)->where('address_id', municipalityId())->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 2);
        });

        $datas = [];
        $diseases = Disease::latest()->whereHas('application_types', function ($query) {
            $query->where('application_types.id', request('diseaseType'));
        })->get();

        if (request('date_from')) {
            $dateFrom = request('date_from')[0];
        }
        if (request('date_to')) {
            $dateTo = request('date_to')[0];
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }

        if (request('date_from')) {
            $patients = $patients->where('registered_date', '>=', $dateFrom);
        }
        if (request('date_to')) {
            $patients = $patients->where('registered_date', '<=', $dateTo);
        }
        if (request('ward_number')) {
            $patients = $patients->where('ward_number', request('ward_number'));
        }
        if (request('gender')) {
            // $patients = $patients->where('gender', request('gender'));
            $patients = $patients->whereRaw('LOWER(gender) = ?', [strtolower(request('gender'))]);
        }
        $patients = $patients->get();
        foreach ($diseases as $disease) {
            $total = $patients->where('disease_id', $disease->id)->count();

            $male = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'male';
            })->count();

            $female = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'female';
            })->count();

            $other = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'other';
            })->count();

            $totalRegistered = $patients->where('disease_id', $disease->id)->whereNotNull('registered_date')->count();

            $maleRegistered = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'male';
            })->whereNotNull('registered_date')->count();

            $femaleRegistered = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'female';
            })->whereNotNull('registered_date')->count();

            $otherRegistered = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'other';
            })->whereNotNull('registered_date')->count();

            if ($total > 0) {

                $datas[] = [
                    'disease' => $disease->name,
                    'total' => $total,
                    'male' => $male,
                    'female' => $female,
                    'other' => $other,

                    'totalRegistered' => $totalRegistered,
                    'maleRegistered' => $maleRegistered,
                    'femaleRegistered' => $femaleRegistered,
                    'otherRegistered' => $otherRegistered
                ];
            }
        }
        $datasCollection = collect($datas)->sortByDesc('total');
        $patientLists = $datasCollection->values()->all();
        if ($request->excel) {
            return Excel::download(new BipannaDiseseWiseExport($patientLists), 'bipanna disease wise report.xlsx');
        }
        return view('organization.report.bipanna.diseaseReport', compact('patientLists'));
    }


    public function socialDevelopmentMinistryFianlReport(Request $request)
    {
        $patients =  Patient::with(['disease', 'hospital'])->where('address_id', municipalityId())->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 3);
        });

        if ($request->fiscal_year_id) {

            $patients = $patients->where('fiscal_year_id', $request->fiscal_year_id);
        } else {
            $patients = $patients->where('fiscal_year_id', currentFiscalYear()->id);
        }

        if (request('date_from')) {
            $dateFrom = request('date_from')[0];
        }
        if (request('date_to')) {
            $dateTo = request('date_to')[0];
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }

        if (request('date_from')) {
            $patients = $patients->where('registered_date', '>=', $dateFrom);
        }
        if (request('date_to')) {
            $patients = $patients->where('registered_date', '<=', $dateTo);
        }
        if (request('ward_number')) {
            $patients = $patients->where('ward_number', request('ward_number'));
        }
        if (request('gender')) {
            // $patients = $patients->where('gender', request('gender'));
            $patients = $patients->whereRaw('LOWER(gender) = ?', [strtolower(request('gender'))]);
        }

        $patients = $patients->get();

        if ($request->excel) {
            return Excel::download(new SamajikExport($patients), 'bipanna disease wise report.xlsx');
        }

        if ($request->fiscal_year_id) {
            $fiscalYear = FiscalYear::findOrFail($request->fiscal_year_id);
        } else {
            $fiscalYear = currentFiscalYear();
        }

        return view('organization.report.socialDevelopment.final-report', compact('patients', 'fiscalYear'));
    }

    public function socialDevelopmentMinistryReport(Request $request)
    {
        $patients =  Patient::where('fiscal_year_id', currentFiscalYear()->id)->where('address_id', municipalityId())->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 3);
        });

        $datas = [];
        $diseases = Disease::latest()->whereHas('application_types', function ($query) {
            $query->where('application_types.id', 3);
        })->get();

        if (request('date_from')) {
            $dateFrom = request('date_from')[0];
        }
        if (request('date_to')) {
            $dateTo = request('date_to')[0];
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }

        if (request('date_from')) {
            $patients = $patients->where('registered_date', '>=', $dateFrom);
        }
        if (request('date_to')) {
            $patients = $patients->where('registered_date', '<=', $dateTo);
        }
        if (request('ward_number')) {
            $patients = $patients->where('ward_number', request('ward_number'));
        }
        if (request('gender')) {
            // $patients = $patients->where('gender', request('gender'));
            $patients = $patients->whereRaw('LOWER(gender) = ?', [strtolower(request('gender'))]);
        }
        $patients = $patients->get();
        foreach ($diseases as $disease) {
            $total = $patients->where('disease_id', $disease->id)->count();

            $male = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'male';
            })->count();

            $female = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'female';
            })->count();

            $other = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'other';
            })->count();

            // =========================
            $totalRegistered = $patients->where('disease_id', $disease->id)->whereNotNull('registered_date')->count();

            $maleRegistered = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'male';
            })->whereNotNull('registered_date')->count();

            $femaleRegistered = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'female';
            })->whereNotNull('registered_date')->count();

            $otherRegistered = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'other';
            })->whereNotNull('registered_date')->count();

            if ($total > 0) {

                $datas[] = [
                    'disease' => $disease->name,
                    'total' => $total,
                    'male' => $male,
                    'female' => $female,
                    'other' => $other,

                    'totalRegistered' => $totalRegistered,
                    'maleRegistered' => $maleRegistered,
                    'femaleRegistered' => $femaleRegistered,
                    'otherRegistered' => $otherRegistered
                ];
            }
        }
        $datasCollection = collect($datas)->sortByDesc('total');
        $patientLists = $datasCollection->values()->all();
        if ($request->excel) {
            return Excel::download(new BipannaDiseseWiseExport($patientLists), 'social development ministry report.xlsx');
        }
        return view('organization.report.socialDevelopment.diseaseReport', compact('patientLists'));
    }

    public function municipalityHealthRelifFund(Request $request)
    {
        $patients =  Patient::where('fiscal_year_id', currentFiscalYear()->id)->where('address_id', municipalityId())->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 4);
        });

        $datas = [];
        $diseases = Disease::latest()->whereHas('application_types', function ($query) {
            $query->where('application_types.id', 4);
        })->get();

        if (request('date_from')) {
            $dateFrom = request('date_from')[0];
        }
        if (request('date_to')) {
            $dateTo = request('date_to')[0];
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }

        if (request('date_from')) {
            $patients = $patients->where('registered_date', '>=', $dateFrom);
        }
        if (request('date_to')) {
            $patients = $patients->where('registered_date', '<=', $dateTo);
        }
        if (request('ward_number')) {
            $patients = $patients->where('ward_number', request('ward_number'));
        }
        if (request('gender')) {
            // $patients = $patients->where('gender', request('gender'));
            $patients = $patients->whereRaw('LOWER(gender) = ?', [strtolower(request('gender'))]);
        }
        $patients = $patients->get();
        foreach ($diseases as $disease) {
            $total = $patients->where('disease_id', $disease->id)->count();

            $male = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'male';
            })->count();

            $female = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'female';
            })->count();

            $other = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'other';
            })->count();

            // =========================
            $totalRegistered = $patients->where('disease_id', $disease->id)->whereNotNull('registered_date')->count();

            $maleRegistered = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'male';
            })->whereNotNull('registered_date')->count();

            $femaleRegistered = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'female';
            })->whereNotNull('registered_date')->count();

            $otherRegistered = $patients->filter(function ($patient) use ($disease) {
                return $patient->disease_id == $disease->id && strtolower($patient->gender) == 'other';
            })->whereNotNull('registered_date')->count();

            if ($total > 0) {

                $datas[] = [
                    'disease' => $disease->name,
                    'total' => $total,
                    'male' => $male,
                    'female' => $female,
                    'other' => $other,

                    'totalRegistered' => $totalRegistered,
                    'maleRegistered' => $maleRegistered,
                    'femaleRegistered' => $femaleRegistered,
                    'otherRegistered' => $otherRegistered
                ];
            }
        }
        $datasCollection = collect($datas)->sortByDesc('total');
        $patientLists = $datasCollection->values()->all();
        if ($request->excel) {
            return Excel::download(new BipannaDiseseWiseExport($patientLists), 'पालिकाको स्वास्थ्य राहत कोष.xlsx');
        }
        return view('organization.report.municipality.diseaseReport', compact('patientLists'));
    }
}
