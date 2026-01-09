<?php

namespace App\Http\Controllers\Admin;

use App\Exports\NewApplication;
use App\Patient;
use Carbon\Carbon;
use App\ApplicationType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Renew;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function newApplication(Request $request)
    {

        $title = "दीर्घरोगी मासिक उपचार खर्च";
        $municipality_id = municipalityId();
        if (!$municipality_id) {
            return redirect()->back()->with('error', "कृपया पालिका छान्नुहोस्");
        }



        $patients = Patient::with(['patientApplication.patientApplicationDisease.disease'])->where('address_id', $municipality_id)->whereNull('verified_date')->whereNull('registered_date')->whereNull('closed_date');


        if ($request->filled('diseaseType')) {
            $patients = $patients->whereHas('patientApplication', function ($query) use ($request) {
                $query->where('application_type_id', $request->diseaseType);
            });
        }

        // return $patients->get();



        if ($request->token_number) {
            $patients = $patients->whereHas('onlineApplication', function ($query) use ($request) {
                $query->where('token_number', $request->token_number);
            });
        }
        if ($request->name) {
            $patients = $patients->where('name', 'like', '%' . $request->name . '%')
                ->orWhere('name_en', '%', '%' . $request->name . '%');
        }

        if ($request->fiscal_year) {
            $patients = $patients->where('fiscal_year_id', $request->fiscal_year);
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }
        if ($request->registration_number) {
            $patients = $patients->where('registration_number', $request->registration_number);
        }
        if ($request->ward) {
            $patients = $patients->where('ward_number', $request->ward);
        }

        if ($request->filled('application_type_id')) {
            $patients->whereHas('patientApplication', function ($query) use ($request) {
                $query->where('application_type_id', $request->application_type_id);
            });
        }


        if ($request->gender) {
            $patients = $patients->where('gender', $request->gender);
        }
        if ($request->nno) {
            $patients = $patients->where('citizenship_number', 'like', '%' . $request->nno . '%');
        }
        if ($request->mobile) {
            $patients = $patients->where('mobile_number', 'like', '%' . $request->mobile . '%');
        }

        // if ($request->diseaseType == 1) {
        //     $fileName = "दीर्घरोगी मासिक उपचार खर्च.xlsx";
        // } elseif ($request->diseaseType == 2) {
        //     $fileName = "बिपन्न सहयोगको सिफारिस.xlsx";
        // } elseif ($request->diseaseType == 3) {
        //     $fileName = "सामाजिक विकास मन्त्रालय.xlsx";
        // } elseif ($request->diseaseType == 4) {
        //     $fileName = "नगरपालिका.xlsx";
        // }
        if ($request->export) {
            $applicationType = ApplicationType::find(request('diseaseType'))->name;
            $patients = $patients->orderBy('created_at', $request->order ?? 'desc')->get();
            $status = 'new';
            return Excel::download(new NewApplication($patients, $status, $applicationType), $fileName);
        } else {
            $patients = $patients->orderBy('created_at', $request->order ?? 'desc')->paginate($request->per_page ?? 20);
        }
        $isrecommended = false;
        $isRegistered = false;
        $deasiseTypes = ApplicationType::latest()->get();
        // return $deasiseTypes;
        return view('organization.index', compact(['patients', 'isrecommended', 'isRegistered', 'deasiseTypes']));
    }

    public function regLocation(Request $request)
    {

        $municipality_id = municipalityId();
        if (!$municipality_id) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }


        $patients = Patient::with(['patientApplication.patientApplicationDisease.disease'])->where('address_id', $municipality_id)->where('address_id', $municipality_id)->whereNotNull('verified_date')->whereNotNull('registered_date')->whereNull('status')->whereNull('closed_date');


        if ($request->filled('diseaseType')) {
            $patients = $patients->whereHas('patientApplication', function ($query) use ($request) {
                $query->where('application_type_id', $request->diseaseType);
            });
        }

        if ($request->name) {
            $patients = $patients->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('name_en', 'like', '%' . $request->name . '%');
            });
        }
        if ($request->registration_number) {
            $patients = $patients->where('registration_number', 'like', '%' . $request->registration_number . '%');
        }
        if ($request->nno) {
            $patients = $patients->where('citizenship_number', 'like', '%' . $request->nno . '%');
        }
        if ($request->mobile) {
            $patients = $patients->where('mobile_number', 'like', '%' . $request->mobile . '%');
        }
        if ($request->fiscal_year) {
            $patients = $patients->where('fiscal_year_id', $request->fiscal_year);
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }
        if ($request->ward) {
            $patients = $patients->where('ward_number', $request->ward);
        }
        if ($request->gender) {
            $patients = $patients->where('gender', $request->gender);
        }

         if ($request->filled('application_type_id')) {
            $patients->whereHas('patientApplication', function ($query) use ($request) {
                $query->where('application_type_id', $request->application_type_id);
            });
        }

      

        

        // if ($request->diseaseType == 1) {
        //     $fileName = "दीर्घरोगी मासिक उपचार खर्च.xlsx";
        // } elseif ($request->diseaseType == 2) {
        //     $fileName = "बिपन्न सहयोगको सिफारिस.xlsx";
        // } elseif ($request->diseaseType == 3) {
        //     $fileName = "सामाजिक विकास मन्त्रालय.xlsx";
        // } elseif ($request->diseaseType == 4) {
        //     $fileName = "नगरपालिका.xlsx";
        // }

        if ($request->export) {
            $applicationType = ApplicationType::find(request('diseaseType'))->name;
            $patients = $patients->get();
            $status = 'registered';
            return Excel::download(new NewApplication($patients, $status, $applicationType), $fileName);
        } else {
            $patients = $patients->paginate($request->per_page ?? 20);
        }

        $isrecommended = false;
        $isRegistered = false;
        $deasiseTypes = ApplicationType::latest()->get();

    

        return view('organization.index', compact(['patients', 'isrecommended', 'isRegistered', 'deasiseTypes']));
    }

    public function hospitalSifaris(Patient $patient)
    {
        // $patient=Patient::with(['address','district'])->find($patient);
        $application_type_id = $patient->disease->application_types[0]->id;
        $permissions = [
            '2' => 'bipanna.SifarisPrint'
        ];
        $diseaseTypeId = checkPermission($permissions, $application_type_id);
        return view('frontend.hospitalSifaris', [
            'patient' => $patient,
        ]);
    }

    function SocialRecommandation(Patient $patient)
    {
        return view('frontend.socialRecommandation', [
            'patient' => $patient,
        ]);
    }

    public function assignHospital(Request $request, Patient $patient)
    {
        $request->validate([
            'hospital_id' => 'required'
        ]);
        $patient->update([
            'hospital_id' => $request->hospital_id,
        ]);

        return redirect()->route('hospitalSifaris', $patient);
    }

    public function closedPatient(Request $request)
    {
        $municipality_id = municipalityId();

        if (!$municipality_id) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }

        $patients = Patient::with('disease.application_types')->where('address_id', $municipality_id);
        // $patients = $patients->whereNotNull('verified_date');
        // $patients = $patients->whereNotNull('registered_date');
        $permissions = [
            '1' => 'closed.report',
        ];
        $diseaseTypeId = checkPermission($permissions, 1);
        $patients = $patients->whereNotNull('closed_date');
        $patients = $patients->whereHas('disease.application_types', function ($query) use ($request) {
            $query->where('application_types.id', 1);
        });
        if ($request->name) {
            $patients = $patients->where('name', 'like', '%' . $request->name . '%')->orWhere('name_en', 'like', '%' . $request->name . '%');
            $patients = $patients->whereNotNull('verified_date');
            $patients = $patients->whereNotNull('registered_date');
            $patients = $patients->whereNotNull('closed_date');
        }
        if ($request->registration_number) {
            $patients = $patients->where('registration_number', 'like', '%' . $request->registration_number . '%');
        }
        if ($request->nno) {
            $patients = $patients->where('citizenship_number', 'like', '%' . $request->nno . '%');
        }
        if ($request->mobile) {
            $patients = $patients->where('mobile_number', 'like', '%' . $request->mobile . '%');
        }
        if ($request->fiscal_year) {
            $patients = $patients->where('fiscal_year_id', $request->fiscal_year);
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }
        if ($request->ward) {
            $patients = $patients->where('ward_number', $request->ward);
        }
        if ($request->gender) {
            $patients = $patients->where('gender', $request->gender);
        }


        $fileName = "लागतकट्टा भएका.xlsx";

        if ($request->export) {
            $patients = $patients->get();
            $status = 'closed';
            $applicationType = ApplicationType::find(1)->name;
            return Excel::download(new NewApplication($patients, $status, $applicationType), $fileName);
        } else {
            $patients = $patients->paginate($request->per_page ?? 20);
        }

        // $patients = $patients->paginate($request->per_page ?? 20);
        $isrecommended = false;
        $isRegistered = false;
        $deasiseTypes = ApplicationType::latest()->get();
        return view('organization.index', compact(['patients', 'isrecommended', 'isRegistered', 'deasiseTypes']));
    }

    public function renewedPatient(Request $request)
    {
        $permissions = [
            '1' => 'renewed.report',
        ];
        $diseaseTypeId = checkPermission($permissions, 1);

        $municipality_id = municipalityId();
        if (!$municipality_id) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }
        $todayDate = ad_to_bs(today()->format('Y-m-d'));
        $today = formatDate($todayDate);

        $currentQuarter = currentQuarterDate();
        $currentMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $currentMonthEnd = Carbon::now()->endOfMonth()->toDateString();

        // Retrieve patients with conditions
        $patients = Patient::with(['disease', 'disease.application_types', 'renews'])
            ->whereNotNull('registered_date')
            ->where('address_id', municipalityId())
            ->whereHas('renews', function ($query) use ($currentQuarter) {
                $query->selectRaw('max(next_renew_date) as latest_renewal')
                    ->groupBy('patient_id') // Adjust if needed based on your relationship
                    ->havingRaw('latest_renewal >= ?', [$currentQuarter]);
            });

        if ($request->registration_number) {
            $patients = $patients->where('registration_number', $request->registration_number);
        }
        if ($request->name) {
            $patients = $patients->where('name', 'like', '%' . $request->registration_number . '%')->orWhere('name_en', 'like', '%' . $request->registration_number . '%');
        }
        if ($request->nno) {
            $patients = $patients->where('citizenship_number', 'like', '%' . $request->nno . '%');
        }
        if ($request->mobile) {
            $patients = $patients->where('mobile_number', 'like', '%' . $request->mobile . '%');
        }
        if ($request->fiscal_year) {
            $patients = $patients->where('fiscal_year_id', $request->fiscal_year);
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }
        if ($request->ward) {
            $patients = $patients->where('ward_number', $request->ward);
        }
        if ($request->gender) {
            $patients = $patients->where('gender', $request->gender);
        }

        $fileName = "नबिकरण भएका.xlsx";

        // return $patients = $patients->get();
        if ($request->export) {
            $patients = $patients->get();
            $status = 'renew';
            $applicationType = ApplicationType::find(1)->name;
            return Excel::download(new NewApplication($patients, $status, $applicationType), $fileName);
        } else {
            $patients = $patients->paginate($request->per_page ?? 20);
        }
        // $patients = $patients->paginate($request->per_page ?? 20);

        // Return the paginated results
        // return $patients;
        $isrecommended = false;
        $isRegistered = false;
        $deasiseTypes = ApplicationType::latest()->get();
        return view('organization.index', compact(['patients', 'isrecommended', 'isRegistered', 'deasiseTypes']));
    }
    public function dateExpiredPatient(Request $request)
    {
        $permissions = [
            '1' => 'notRenewed.report',
        ];
        $diseaseTypeId = checkPermission($permissions, 1);
        $municipality_id = municipalityId();
        if (!$municipality_id) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }

        $todayDate = ad_to_bs(today()->format('Y-m-d'));
        $today = formatDate($todayDate);

        $currentQuarter = currentQuarterDate();

        $currentMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $currentMonthEnd = Carbon::now()->endOfMonth()->toDateString();


        $patients = Patient::with(['disease', 'disease.application_types', 'renews'])
            ->whereNotNull('registered_date')
            ->whereHas('renews', function ($query) use ($currentQuarter) {
                $query->selectRaw('max(next_renew_date) as latest_renewal')
                    ->groupBy('patient_id') // Adjust if needed based on your relationship
                    ->havingRaw('latest_renewal < ?', [$currentQuarter]);
            });



        if ($request->registration_number) {
            $patients = $patients->where('registration_number', $request->registration_number);
        }
        if ($request->name) {
            $patients->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->name . '%')
                    ->orWhere('name_en', 'like', '%' . $request->name . '%');
            });
        }

        if ($request->nno) {
            $patients = $patients->where('citizenship_number', 'like', '%' . $request->nno . '%');
        }
        if ($request->mobile) {
            $patients = $patients->where('mobile_number', 'like', '%' . $request->mobile . '%');
        }
        if ($request->fiscal_year) {
            $patients = $patients->where('fiscal_year_id', $request->fiscal_year);
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }
        if ($request->ward) {
            $patients = $patients->where('ward_number', $request->ward);
        }
        if ($request->gender) {
            $patients = $patients->where('gender', $request->gender);
        }

        $fileName = "नबिकरण नभएका.xlsx";



        if ($request->export) {
            $patients = $patients->get();
            $status = 'dateExpired';
            $applicationType = ApplicationType::find(1)->name;
            return Excel::download(new NewApplication($patients, $status, $applicationType), $fileName);
        } else {
            $patients = $patients->paginate($request->per_page ?? 20);
        }
        // Return the paginated results
        // return $patients;
        $isrecommended = false;
        $isRegistered = false;
        $deasiseTypes = ApplicationType::latest()->get();
        return view('organization.index', compact(['patients', 'isrecommended', 'isRegistered', 'deasiseTypes']));
    }
}
