<?php

namespace App\Http\Controllers;

use App\User;
use App\Month;
use App\Renew;
use OneSignal;
use App\Member;
use App\Address;
use App\Patient;
use App\Relation;
use App\Committee;
use Carbon\Carbon;
use App\FiscalYear;
use App\Onesignaltoken;
use App\ApplicationType;
use App\Disease;
use App\OnlineApplication;
use App\PatientApplication;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\OrganizationService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Services\OnlineApplicationService;
use DateTime;
use Illuminate\Validation\ValidationException;

class PatientController extends Controller
{
    protected  $organizationService;
    public function index(Request $request)
    {
        $municipality_id = municipalityId();

        $patients = Patient::with('disease.application_types')->where('address_id', $municipality_id);
        if (!$request->all) {

            if ($request->verify) {
                $patients = $patients->whereNotNull('verified_date');
            } else {
                $patients = $patients->whereNull('verified_date');
            }

            if ($request->registered) {
                $patients = $patients->whereNotNull('registered_date');
            } else {
                $patients = $patients->whereNull('registered_date');
            }

            if ($request->closed) {
                $patients = $patients->whereNotNull('closed_date');
            } else {
                $patients = $patients->whereNull('closed_date');
            }
        }
        if ($request->registration_number) {
            $patients = $patients->where('registration_number', 'like', '%' . $request->registration_number . '%');
        }
        if ($request->fiscal_year) {
            $patients = $patients->where('fiscal_year_id', $request->fiscal_year);
        }
        if ($request->name) {
            $patients = $patients->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->ward_number) {
            $patients = $patients->where('ward_number', $request->ward_number);
        }
        if ($request->disease_id) {
            $patients = $patients->where('disease_id', $request->disease_id);
        }
        if ($request->order) {
            // return $request->order;
            $patients = $patients->orderBy('created_at', $request->order);
        }
        if ($request->nno) {
            $patients = $patients->where('citizenship_number', 'like', '%' . $request->nno . '%');
        }
        if ($request->mobile) {
            $patients = $patients->where('mobile_number', 'like', '%' . $request->mobile . '%');
        }
        // if ($request->disease_id) {
        //     $patients = $patients->whereHas('disease.application_types', function ($query) use ($request) {
        //         $query->where('application_types.id', $request->disease_id);
        //     });
        // }
        if ($request->application_type) {
            $patients = $patients->whereHas('disease.application_types', function ($query) use ($request) {
                $query->where('application_types.id', $request->application_type);
            });
        }
        $patients = $patients->paginate($request->per_page ?? 20);
        $isrecommended = false;
        $isRegistered = false;
        $deasiseTypes = ApplicationType::latest()->get();
        $diseases = Disease::latest()->get();
        return view('organization.index', compact(['patients', 'isrecommended', 'isRegistered', 'deasiseTypes', 'diseases']));
    }

    function calculateAge($dob)
    {
        // Create DateTime object for the given date of birth
        // return $dob;
        $adDob = bs_to_ad($dob);
        $dob = new DateTime($dob);
        $today = new DateTime('today');
        $age = $dob->diff($today)->y; // 'y' represents the number of years

        return $age;
    }

    public function store(Request $request, OnlineApplicationService $onlineApplicationService)
    {
        $fiscalYear = currentFiscalYear();
        if (!$fiscalYear) {
            return redirect()->back()->with('error', "कृपया आर्थिकबर्ष छान्नुहोस्");
        }

        // $fiscalYear = FiscalYear::where('is_running', 1)->first();
        $address = Address::where('district', $request->district_id)->where('municipality', $request->address_id)->first();
        $users = User::where('municipality_id', $address->id)->latest()->get();
        $superadmin = $admins = User::role('super-admin')->first();
        if ($superadmin) {
            $users->push($superadmin);
        }

        $data = $request->validate([
            'disease_id' => 'required',
            'name' => 'required',
            'name_en' => 'required',
            'citizenship_number' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'age' => 'nullable',
            'address_id' => 'required',
            'ward_number' => 'required',
            'tole' => 'required',
            'contact_person' => 'required',
            'mobile_number' => 'required',
            'email' => 'nullable',
            'kshati_date' => 'nullable',
            'estimated_amount' => 'required',
            'description' => 'nullable',
            'relation_with_patients' => 'nullable',
            'applied_date' => 'nullable',
        ]);

        $data['fiscal_year_id'] = $fiscalYear->id;
        $data['address_id'] = $address->id;

        $data['age'] = $this->calculateAge($data['dob']);


        // dd($data['dob'], $data['age']);
        // $patient = Patient::create($data);
        // dd($patient->age);

        $kshatiDocs = [];
        if ($request->hasFile('kshati_document')) {
            foreach ($request->file('kshati_document') as $file) {
                $kshatiDocs[] = $file->store('documents');
            }
        }

        $data['kshati_document'] = json_encode($kshatiDocs);


        // if ($request->has('kshati_document')) {
        //     $data['kshati_document'] = $request->file('kshati_document')->store('documents');
        // }

        if ($request->has('hospital_document')) {
            $data['hospital_document'] = $request->file('hospital_document')->store('documents');
        }

        if ($request->has('disease_proved_document')) {
            $data['disease_proved_document'] = $request->file('disease_proved_document')->store('documents');
        }
        if ($request->has('citizenship_card')) {
            $data['citizenship_card'] = $request->file('citizenship_card')->store('documents');
        }
        if (!$request->applied_date) {
            $data['applied_date'] = now()->format('Y/m/d');
        } else {
            $currentDate = $request->applied_date;
            $dateParts = explode('-', $currentDate);
            $newDate = $dateParts[0] . '-' . $dateParts[1] . '-' . $dateParts[2];
            $data['applied_date'] = bs_to_ad($newDate);
        }



        $patient = Patient::create($data);

        $patientApplication = $patient->patientApplication()->create([
            'application_type_id' => $request->application_type_id,
            'registration_date' => now()->format('Y/m/d'),
        ]);

        $patientApplication->patientApplicationDisease()->create([
            'disease_id' => $request->disease_id,
        ]);



        // $patient->applicationType()->associate($request->application_type_id);
        // dd($patient);
        $tokenNumber = $onlineApplicationService->create($patient);
        $ids = [];
        // foreach ($users as $user) {
        //     $oneSignalIds = Onesignaltoken::where('user_id', $user->id)->latest()->get();
        //     foreach ($oneSignalIds as $oneSignalId) {
        //         if ($oneSignalId->token) {
        //             $ids[] = $oneSignalId->token;
        //         }
        //     }
        // }


        // OneSignal::sendNotificationToUser(
        //     "नयाँ बिरामी विवरण प्राप्त भयो",
        //     $ids,
        //     $url = null,
        //     $data = null,
        //     $buttons = null,
        //     $schedule = null
        // );

        if (!Auth::check()) {
            return redirect(URL::temporarySignedRoute('token.index', now()->addMinutes(180), $tokenNumber));
        }
        return redirect()->route('applicationSubmited', $patient);
    }

    public function applicationApply(Request $request)
    {
        $data = $request->validate([
            'patient_id' => 'required',
            'application_type_id' => 'required',
        ]);

        $patient = Patient::find($request->patient_id);
        $onlineApplication = OnlineApplication::where('patient_id', $patient->id)->first();

        if ($request->application_type_id == 1) {
            return view('print.dirgha', [
                'patient' => $patient,
                'onlineApplication' => $onlineApplication,
            ]);
        } elseif ($request->application_type_id == 2) {
            return "बिपन्न";
        } elseif ($request->application_type_id == 3) {
            return "सामाजिक";
        } else {
            return "Nagarpalika";
        }

        // PatientApplication::create($data);

        return redirect()->route('print.token', $request->token_number);
    }

    public function recommendation(Request $request)
    {


        // return $request;
        $fiscalYear = currentFiscalYear();
        if (!$fiscalYear) {
            return redirect()->back()->with('error', "कृपया आर्थिकबर्ष छान्नुहोस्");
        }
        $patient = Patient::with('disease.application_types')->find($request->patient_id);
        $date1 = Carbon::parse(ad_to_bs($patient->applied_date));
        $date2 = Carbon::parse($request->date_from);
        if ($date2 < $date1) {
            return redirect()->back()->with('error', ' कृपया दर्ता मिति आबेदन मिति भन्दा ठूलो हुनुपर्छ');
        }

        $request->validate([
            'patient_id' => 'required',
            'application_type_id' => 'required',
            'date_from' => 'required',
            'registration_number' => 'required',
            'application' => 'nullable',
            'doctor_recomandation' => 'nullable',
            'hospital_document' => 'nullable',
            'bank_account_number' => 'nullable',
            'bank_cheque' => 'nullable',
            'decision_document' => 'nullable',
            'disease_proved_document' => 'nullable',
            'citizenship_card' => 'nullable',
            'reg_number' => 'required',
        ]);

        $patient->update([
            'reg_number' => $request->reg_number,
        ]);
        // return $request->date_from;
        // $registerDate = new DateTime($request->date_from);
        // $applicationDate = new DateTime($patient->applied_date);

        // if ($registerDate < $applicationDate) {
        //     return redirect()->back()->with('error', 'दर्ता मिति आवेदन मिति पछि हुनुपर्छ');
        // }
        // return "Hello";
        // if (!$patient->bank_account_number && $request->bank_account_number == null && $patient->disease->application_types[0]->id == 1) {
        //     throw ValidationException::withMessages([
        //         'bank_account_number' => ['The bank account number field is required.'],
        //     ]);
        // }
        // if (!$patient->doctor_recomandation && $request->doctor_recomandation == null && $patient->disease->application_types[0]->id == 1) {
        //     throw ValidationException::withMessages([
        //         'doctor_recomandation' => ['The doctor recomandation field is required.'],
        //     ]);
        // }
        // if (!$patient->decision_document && $request->decision_document == null && $patient->disease->application_types[0]->id != 1) {
        //     throw ValidationException::withMessages([
        //         'decision_document' => ['The decision document field is required.'],
        //     ]);
        // }
        // if (!$patient->hospital_document && $request->hospital_document == null) {
        //     throw ValidationException::withMessages([
        //         'hospital_document' => ['The hospital document is required.'],
        //     ]);
        // }
        // if (!$patient->disease_proved_document && $request->disease_proved_document == null) {
        //     throw ValidationException::withMessages([
        //         'disease_proved_document' => ['The disease proved document field is required.'],
        //     ]);
        // }
        // if (!$patient->citizenship_card && $request->citizenship_card == null) {
        //     throw ValidationException::withMessages([
        //         'citizenship_card' => ['The citizenship card field is required.'],
        //     ]);
        // }

        // if (!$patient->application && $request->application == null) {
        //     throw ValidationException::withMessages([
        //         'application' => ['This field is required.'],
        //     ]);
        // }
        //
        // return $request->application_type_id;
        PatientApplication::create([
            'patient_id' => $request->patient_id,
            'application_type_id' => $request->application_type_id,
            'registration_date' => now(),
        ]);
        // foreach($request->application_type_id as $application_type){
        // }

        // $patient = Patient::find($request->patient_id);
        if ($request->file('application')) {
            $application = $request->file('application')->store('documents');
        } else {
            $application = $patient->application ?? '';
        }
        if ($request->file('doctor_recomandation')) {
            $doctor_recomandation = $request->file('doctor_recomandation')->store('documents');
        } else {
            $doctor_recomandation = $patient->doctor_recomandation ?? "";
        }
        if ($request->file('bank_cheque')) {
            $bank_cheque = $request->file('bank_cheque')->store('cheque_book');
        } else {
            $bank_cheque = $patient->bank_cheque ?? "";
        }
        if ($request->file('decision_document')) {
            $decision_document = $request->file('decision_document')->store('decision_document');
        } else {
            $decision_document = $patient->decision_document ?? "";
        }
        if ($request->file('hospital_document')) {
            $hospital_document = $request->file('hospital_document')->store('hospital_document');
        } else {
            $hospital_document = $patient->hospital_document ?? "";
        }

        if ($request->file('disease_proved_document')) {
            $disease_proved_document = $request->file('disease_proved_document')->store('disease_proved_document');
        } else {
            $disease_proved_document = $patient->disease_proved_document ?? "";
        }

        if ($request->file('citizenship_card')) {
            $citizenship_card = $request->file('citizenship_card')->store('citizenship_card');
        } else {
            $citizenship_card = $patient->citizenship_card ?? "";
        }

        $data = [
            'verified_date' => Carbon::parse($request->date_from),
            'application' => $application,
            'doctor_recomandation' => $doctor_recomandation,
            'registration_number' => $request->registration_number,
            'registered_date' => Carbon::parse($request->date_from),
            'bank_cheque' => $bank_cheque,
            'bank_account_number' => $request->bank_account_number,
            'decision_document' => $decision_document,
            'hospital_document' => $hospital_document,
            'disease_proved_document' => $disease_proved_document,
            'citizenship_card' => $citizenship_card,
            'isRecommended' => true,
        ];
        if ($request->application_type_id != 1) {
            $data['yearly_payment'] = $request->yearly_payment;
        }
        // if ($this->checkDocument($patient)) {
        //     if ($request->date_from[0] == null) {
        //         throw ValidationException::withMessages([
        //             'date_from' => ['The registration date field is required.'],
        //         ]);
        //     }
        //     if ($request->registration_number == null) {
        //         throw ValidationException::withMessages([
        //             'registration_number' => ['The registered date field is required.'],
        //         ]);
        //     }

        //     if ($request->bank_account_number == null && $patient->disease->application_types[0]->id == 1) {
        //         throw ValidationException::withMessages([
        //             'bank_account_number' => ['The bank account number field is required.'],
        //         ]);
        //     }
        //     $patient->update([
        //         'isRecommended' => true,
        //         'registration_number' => $request->registration_number,
        //         'registered_date' => Carbon::parse($request->date_from[0]),
        //     ]);
        // }
        $patient->update($data);
        // return $this->checkDocument($patient);

        $renewDate = nextRenewDate($request->date_from);
        $date1 = Carbon::parse($request->date_from)->format('m');
        $date2 = Carbon::parse($renewDate)->format('m');
        // return $diff = $date2 - $date1;




        if ($request->application_type_id == 1) {
            Renew::create([
                'patient_id' => $patient->id,
                'renew_date' => $request->date_from,
                'next_renew_date' => $renewDate,
                'price_rate' => $request->yearly_payment,
                'month' => totalMonth($date1, $date2),
                'fiscal_year_id' => $fiscalYear->id,
                'remarks' => 'नयाँ',

            ]);
            return redirect()->route('patient.show', $patient)->with('success', 'बिरामी विवरण सफलतापुर्वक दर्ता भयो');
        }
        return redirect()->route('patient.show', $patient)->with('success', 'बिरामी विवरण सफलतापुर्वक सिफारिस भयो');
    }

    public function checkDocument($patient)
    {
        if (!$this->checkCommonDocument($patient)) {
            return false;
        }
        switch ($patient->disease->application_types[0]->id) {
            case '1':

                if ($patient->doctor_recomandation && $patient->bank_cheque) {
                    return true;
                }
                return false;
            default:
                if ($patient->decision_document) {
                    return true;
                }
                return false;
        }
    }

    public function checkCommonDocument($patient)
    {
        if ($patient->hospital_document && $patient->disease_proved_document && $patient->citizenship_card && $patient->application) {
            return true;
        }
        return false;
    }
    public function checkData(Request $request)
    {
        $patient = Patient::where('citizenship_number', $request->citizenship_number)->orWhere('mobile_number', $request->mobile_number)->first();
        if ($patient) {
            return response()->json([
                'status' => true
            ]);
        } else {
            return response()->json([
                'status' => false
            ]);
        }
    }
    public function update(Request $request, $patient)
    {



        $data = $request->validate([
            'disease_id' => 'required',
            'name' => 'required',
            'name_en' => 'required',
            'citizenship_number' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'age' => 'nullable',
            'ward_number' => 'required',
            'tole' => 'required',
            'contact_person' => 'required',
            'mobile_number' => 'required',
            'email' => 'nullable',
            'kshati_date' => 'nullable',
            'estimated_amount' => 'required',
            'description' => 'nullable',

            'relation_with_patients' => 'nullable',
            // 'reg_number' => 'nullable',
        ]);
        $patient = Patient::find($patient);

        // handle file upload
        $data['hospital_document'] = $this->handleFileUpload($request, $patient, 'hospital_document');
        $data['disease_proved_document'] = $this->handleFileUpload($request, $patient, 'disease_proved_document');
        $data['citizenship_card'] = $this->handleFileUpload($request, $patient, 'citizenship_card');

        $data['age'] = $this->calculateAge($data['dob']);

        // if ($patient->reg_number) {
        // }
        if (!$request->applied_date) {
            $data['applied_date'] = now()->format('Y/m/d');
        } else {
            $currentDate = $request->applied_date;
            $dateParts = explode('-', $currentDate);
            $newDate = $dateParts[0] . '-' . $dateParts[1] . '-' . $dateParts[2];
            $data['applied_date'] = bs_to_ad($newDate);
        }
        $date1 = Carbon::parse(ad_to_bs($patient->applied_date));
        $date2 = Carbon::parse($request->registered_date);
        if ($patient->registered_date) {
            if ($date2 < $date1) {
                return redirect()->back()->with('error', ' कृपया दर्ता मिति आबेदन मिति भन्दा ठूलो हुनुपर्छ');
            }
            $data['registered_date'] = $date2;
        }


        $fiscalYear = currentFiscalYear();
        if (!$fiscalYear) {
            return redirect()->back()->with('error', "कृपया आर्थिकबर्ष छान्नुहोस्");
        }

        $today = ad_to_bs(now()->format('Y-m-d'));
        $parts = explode('/', $today);
        $year = explode('-', currentFiscalYear()->start)[0];
        $nextRenewDate = null;
        $renewDates = null;
        if (renewquarter($date2) == 1) {
            $renewDates = $year . "-4-1";
            $nextRenewDate = $year . "-7-1";
        }
        if (renewquarter($date2) == 2) {
            $renewDates = $year . "-7-1";
            $nextRenewDate = $year . "-10-1";
        }
        if (renewquarter($date2) == 3) {
            $renewDates = $year . "-10-1";
            $nextRenewDate = $year . "-1-1";
        }
        if (renewquarter($date2) == 4) {
            $renewDates = $year . "-1-1";
            $nextRenewDate = ($year + 1) . "-4-1";
        }

        if (!$nextRenewDate) {
            return redirect()->back()->with('error', "कृपया नवीकरण त्रैमासिक छान्नुहोस्");
        }

        if ($patient->renews->isNotEmpty()) {
            $patient->renews[0]->update([
                'renew_date' => $date2,
                'next_renew_date' => $nextRenewDate,
            ]);
        }
        $patient->update($data);

        return redirect()->route('patient.show', $patient)->with('success', "बिरामी विवरण सफलतापुर्वक परिवर्तन भयो");
    }

    private function getRenewDates(Carbon $registeredDate)
    {
        $year = explode('-', currentFiscalYear()->start)[0];
        $quarter = renewquarter($registeredDate);

        return match ($quarter) {
            1 => ['renew_date' => "$year-4-1", 'next_renew_date' => "$year-7-1"],
            2 => ['renew_date' => "$year-7-1", 'next_renew_date' => "$year-10-1"],
            3 => ['renew_date' => "$year-10-1", 'next_renew_date' => "$year-1-1"],
            4 => ['renew_date' => "$year-1-1", 'next_renew_date' => (intval($year) + 1) . "-4-1"],
            default => [null, null],
        };
    }


    private function handleFileUpload($request, $patient, $field)
    {
        if ($request->hasFile($field)) {
            if ($patient->$field) {
                Storage::delete($patient->$field);
            }
            return $request->file($field)->store('documents');
        }
        return $patient->$field;
    }


    public function recommended(Request $request)
    {
        // return "Hello";
        $paginate = $request->per_page ?? 50;
        $patients = Patient::with(['onlineApplication', 'province', 'district', 'municipality'])
            ->where('isRecommended', true)->where('registered_date', null)->where('renewed_date', null)->where('closed_date', null)->paginate($paginate);
        $isrecommended = true;
        $isRegistered = false;
        return view('organization.index', compact(['patients', 'isrecommended', 'isRegistered']));
    }

    public function registration(patient $patient, Request $request)
    {
        $data = $request->validate([
            'registered_date' => 'required',
            'registration_number' => 'required'
        ]);

        $patient->update($data);

        return redirect()->route('patient.recommended')->with('success', "Registered");
    }

    public function registered(Request $request)
    {
        $paginate = $request->per_page ?? 50;
        $patients = Patient::with(['onlineApplication', 'province', 'district', 'municipality'])
            ->whereNotNull('registered_date')->where('closed_date', null)->paginate($paginate);
        $isrecommended = true;
        $isRegistered = true;
        return view('organization.index', compact(['patients', 'isrecommended', 'isRegistered']));
    }

    public function renew(Patient $patient, Request $request)
    {
        $fiscalYear = currentFiscalYear();

        if (!$fiscalYear) {
            return redirect()->back()->with('error', "कृपया आर्थिकबर्ष छान्नुहोस्");
        }

        $request->validate([
            'renewing_document' => 'required|file',
            'quarter' => 'required|in:1,2,3,4'
        ]);

        $today = ad_to_bs(now()->format('Y-m-d'));
        $fiscalStartYear = explode('-', $fiscalYear->start)[0];

        [$renewDate, $nextRenewDate] = $this->getRenewDatesByQuarter($request->quarter, (int) $fiscalStartYear);

        if (!$renewDate || !$nextRenewDate) {
            return redirect()->back()->with('error', "कृपया नवीकरण त्रैमासिक छान्नुहोस्");
        }

        $existingRenewal = Renew::where('patient_id', $patient->id)
            ->where('next_renew_date', $nextRenewDate)
            ->first();

        if ($existingRenewal) {
            return redirect()->back()->with('error', 'बिरामीको नबिकरण पहिले भइसकेको छ |');
        }

        $documentPath = $request->file('renewing_document')->store('documents');

        $patient->update([
            'renewing_document' => $documentPath,
            'renewed_date' => $today,
        ]);

        Renew::create([
            'patient_id' => $patient->id,
            'renew_date' => $renewDate,
            'next_renew_date' => $nextRenewDate,
            'price_rate' => $patient->disease->application_types[0]->amount ?? 0,
            'month' => 3,
            'fiscal_year_id' => $fiscalYear->id,
            'remarks' => 'नविकरण'
        ]);

        return redirect()->back()->with('success', 'बिरामी बिवरण सफलतापुर्वक नवीकरण भयो');
    }

    private function getRenewDatesByQuarter(int $quarter, int $year): array
    {
        switch ($quarter) {
            case 1:
                return ["{$year}-04-01", "{$year}-07-01"];
            case 2:
                return ["{$year}-07-11", "{$year}-10-01"];
            case 3:
                return ["{$year}-10-01", "{$year}-01-01"];
            case 4:
                $nextYear = $year + 1;
                return ["{$nextYear}-01-01", "{$nextYear}-04-01"];
            default:
                return [null, null];
        }
    }


    public function closed(Patient $patient, Request $request)
    {
        $data = $request->validate([
            'closed_date' => 'required',
            'closing_document' => 'required'
        ]);
        $data['closed_date'] = Carbon::parse($request->closed_date[0]);
        if ($request->file('closing_document')) {
            $data['closing_document'] = $request->file('closing_document')->store('documents');
        }
        $patient->update($data);

        return redirect()->back()->with('success', 'बिरामी बिवरण सफलतापुर्वक लागतकट्टा भयो');
    }

    public function closedPatient(Request $request)
    {
        $paginate = $request->per_page ?? 50;
        $patients = Patient::with(['onlineApplication', 'province', 'district', 'municipality'])
            ->whereNotNull('closed_date')->paginate($paginate);
        $isrecommended = true;
        $isRegistered = true;
        return view('organization.index', compact(['patients', 'isrecommended', 'isRegistered']));
    }

    public function reuploadImage(Request $request, $id)
    {
        $data = $request->validate([
            'hospital_document' => 'nullable',
            'disease_proved_document' => 'nullable',
            'citizenship_card' => 'nullable',
            'application' => 'nullable',
            'doctor_recomandation' => 'nullable',
            'bank_cheque' => 'nullable',
            'decision_document' => 'nullable',
            'renewing_document' => 'nullable',
            'closing_document' => 'nullable',
        ]);
        if ($request->file('hospital_document')) {
            $data['hospital_document'] = $request->file('hospital_document')->store('documents');
        }
        if ($request->file('disease_proved_document')) {
            $data['disease_proved_document'] = $request->file('disease_proved_document')->store('documents');
        }
        if ($request->file('citizenship_card')) {
            $data['citizenship_card'] = $request->file('citizenship_card')->store('documents');
        }
        if ($request->file('application')) {
            $data['application'] = $request->file('application')->store('documents');
        }
        if ($request->file('doctor_recomandation')) {
            $data['doctor_recomandation'] = $request->file('doctor_recomandation')->store('documents');
        }
        if ($request->file('bank_cheque')) {
            $data['bank_cheque'] = $request->file('bank_cheque')->store('documents');
        }
        if ($request->file('decision_document')) {
            $data['decision_document'] = $request->file('decision_document')->store('documents');
        }
        if ($request->file('renewing_document')) {
            $data['renewing_document'] = $request->file('renewing_document')->store('documents');
        }
        if ($request->file('closing_document')) {
            $data['closing_document'] = $request->file('closing_document')->store('documents');
        }
        $patient = Patient::find($id);
        $patient->update($data);

        return redirect()->back()->with('success', 'कागजात परिबर्तन भयो');
    }

    public function documentUpload(Request $request, Patient $patient)
    {
        $data = [];
        $isData = false;
        // if ($request->registered_date) {
        //     $data['registered_date'] = $request->registered_date;
        //     $isData = true;
        // }
        if ($request->bank_account_number) {
            $data['bank_account_number'] = $request->bank_account_number;
            $isData = true;
        }
        if ($request->file('hospital_document')) {
            $data['hospital_document'] = $request->file('hospital_document')->store('documents');
            $isData = true;
        }
        if ($request->reg_number) {
            $data['reg_number'] = $request->reg_number;
            $isData = true;
        }
        if ($request->file('disease_proved_document')) {
            $data['disease_proved_document'] = $request->file('disease_proved_document')->store('documents');
            $isData = true;
        }
        if ($request->file('citizenship_card')) {
            $data['citizenship_card'] = $request->file('citizenship_card')->store('documents');
            $isData = true;
        }
        if ($request->file('application')) {
            $data['application'] = $request->file('application')->store('documents');
            $isData = true;
        }
        if ($request->file('doctor_recomandation')) {
            $data['doctor_recomandation'] = $request->file('doctor_recomandation')->store('documents');
            $isData = true;
        }
        if ($request->file('bank_cheque')) {
            $data['bank_cheque'] = $request->file('bank_cheque')->store('documents');
            $isData = true;
        }
        if ($request->file('decision_document')) {
            $data['decision_document'] = $request->file('decision_document')->store('documents');
            $isData = true;
        }
        if ($request->file('renewing_document')) {
            $data['renewing_document'] = $request->file('renewing_document')->store('documents');
            $isData = true;
        }
        if ($request->file('closing_document')) {
            $data['closing_document'] = $request->file('closing_document')->store('documents');
            $isData = true;
        }

        $patient->update($data);

        if ($isData == false) {
            return redirect()->back()->with('error', "कृपया बिरामीको विवरण हल्नुहोस");
        }
        return redirect()->back()->with('success', "बिरामीको विवरण सफलता पुर्वक ड्राफ्ट भयो");
    }

    public function delete(Patient $patient)
    {
        // $application_type_id = $patient->disease->application_types[0]->id;
        // $permissions = [
        //     '1' => 'dirgha.delete',
        //     '2' => 'bipanna.delete',
        //     '3' => 'samajik.delete',
        //     '4' => 'nagarpalika.delete',
        // ];
        // $diseaseTypeId = checkPermission($permissions, $application_type_id);

        $patient->delete();

        return redirect()->back()->with('success', "बिरामीको विवरण सफलतापुर्बक हटाइयो");
    }

    public function wordExport($id)
    {
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Add a font style for Nepali
        $fontStyle = [
            // 'name' => 'Noto Sans Devanagari', // Replace with the actual font name
            'name' => 'Noto Sans Devanagari', // Replace with the actual font name
            'size' => 12,
        ];
        $today = ad_to_bs(now()->format('Y-m-d'));
        $todayDate = englishToNepaliLetters($today);
        $address = Address::find(municipalityId());

        $patient = Patient::with('disease.application_types', 'hospital')->find($id);
        if ($patient) {
            $type_id = $patient->disease->application_types[0]->id;
            $committee = Committee::where('application_type_id', $type_id)->first();
            if ($committee) {
                $members = Member::with('position', 'committeePosition')
                    ->where('committee_id', $committee->id)
                    ->orderBy('order', 'asc')
                    ->get();
            }
        }




        // return "Hello";
        // Add text with the Nepali font style
        $string = 'आज मिति ' . $todayDate . ' गतेका दिन ' . englishToNepaliLetters(date('h:i')) . ' बजे यस ' . $address->municipality . ' का ';
        // $committee ? $members[0]->position->name
        if ($committee) {

            if ($members) {
                if ($members[0]) {
                    $string = $string . $members[0]->position->name;
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $string = $string . " " . 'एवं नेपालसरकार बाट जारी गरिएको "बिपन्न नागरिक औषधि उपचारकोष निर्देशिका २०८०" बमोजिम बिपन्न नागरिकहरु लाई औषधि उपचार सहुलियत उपलब्ध गराउने प्रयोजनको लागि सिफारिस समितिका ';
        if ($committee) {

            if ($members) {
                if ($members[0]) {
                    $string = $string . $members[0]->committeePosition->name;
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $string = $string . " श्री";
        if ($committee) {
            if ($members) {
                if ($members[0]) {
                    $string = $string . " " . $members[0]->name;
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $string = $string . " ज्युको अध्यक्ष्यतामा बसेको बैठकले तपसिल बमोजिम प्रस्ताबहरु माथि छलफल गरि तपसिल बमोजिम निर्णयहरु पारित गरियो";
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = 'उपस्थिति';
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = "१. ";
        if ($committee) {
            if ($members) {
                if ($members[0]) {
                    $string = $string . " " . $members[0]->position->name;
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $string = $string . ' श्री';
        if ($committee) {
            if ($members) {
                if ($members[0]) {
                    $string = $string . " " . $members[0]->name . ' (' . $members[0]->committeePosition->name . ')';
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);

        $string = "2. ";
        if ($committee) {
            if ($members) {
                if ($members[1]) {
                    $string = $string . " " . $members[1]->position->name;
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $string = $string . ' श्री';
        if ($committee) {
            if ($members) {
                if ($members[1]) {
                    $string = $string . " " . $members[1]->name . ' (' . $members[1]->committeePosition->name . ')';
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);

        $string = "3. ";
        if ($committee) {
            if ($members) {
                if ($members[2]) {
                    $string = $string . " " . $members[2]->position->name;
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $string = $string . ' श्री';
        if ($committee) {
            if ($members) {
                if ($members[2]) {
                    $string = $string . " " . $members[2]->name . ' (' . $members[2]->committeePosition->name . ')';
                } else {
                    $string = $string . " ";
                }
            } else {
                $string = $string . " ";
            }
        }
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = "अन्य उपस्थिति:";
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = "1.";
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = "2.";
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = "प्रस्ताव नं 1: औषधि उपचार सहुलियत का लागि सिफारिस सम्बन्ध मा";
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);
        $string = "निर्णय नं: 1 प्रस्ताव नं: 1 माथि छलफल गर्दा यस घोडाघोडी नगरपालिका मा स्थायी बसोबास भएका तपसिल बमोजिमका बिपन्न नागरिकहरुले यस पालिकामा दिएको निवेदन उपर छलफल गरि संग्लन कागजातका आधारमा “बिपन्न नागरिक औषधि उपचार कोष निर्देशिका 2080 अनुसार तपसिल बमोजिमका बिरामीहरु लाई देहाय बमोजिम तोकिएका अस्पतालंहरु मा उपचारका लागि सिफारिस गर्ने निर्णय पारित गरियो|";
        $section->addText($string, $fontStyle);
        $section->addTextBreak(0);

        $tableStyle = [
            'borderSize' => 6,      // Border thickness (in twips)
            'borderColor' => '000000',  // Border color (black)
            'cellMargin' => 50,     // Cell margins
        ];

        // Apply table style
        $phpWord->addTableStyle('myTable', $tableStyle);

        // Add the table with the applied style
        $table = $section->addTable('myTable');

        // Add a row with two columns
        $table->addRow();
        $table->addCell(2000)->addText('क्र. सं.');
        $table->addCell(2000)->addText('बिरामीको नाम थर');
        $table->addCell(2000)->addText('उमेर');
        $table->addCell(2000)->addText('ना.प्र.प.नं./ज. .द.प्र.प.नं.');
        $table->addCell(2000)->addText('रोगको किसिम');
        $table->addCell(2000)->addText('सिफारिसगरिएको अस्पताल');
        $table->addCell(2000)->addText('सम्पर्क नं:');
        $table->addCell(2000)->addText('कैफियत');

        // Add another row with two columns
        $table->addRow();
        $table->addCell(2000)->addText('1');
        $table->addCell(2000)->addText($patient->name ?? '');
        $table->addCell(2000)->addText($patient->age ?? '');
        $table->addCell(2000)->addText($patient->citizenship_number ?? '');
        $table->addCell(2000)->addText($patient->disease ? $patient->disease->name : '');
        $table->addCell(2000)->addText($patient->hospital ? $patient->hospital->name : '');
        $table->addCell(2000)->addText($patient->mobile_number ?? '');
        $table->addCell(2000)->addText($patient->description ?? '');
        // Add more content as needed...

        // Save the document to a temporary location
        $tempFilePath = tempnam(sys_get_temp_dir(), 'PHPWord') . '.docx';
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save($tempFilePath);

        // Return a response to force download the .docx file
        return response()->download($tempFilePath, 'निर्णय पत्र.docx')->deleteFileAfterSend(true);
    }


    public function deleteKshatiPhoto(Patient $patient, $index)
    {
        $photos = json_decode($patient->kshati_document, true);

        if (isset($photos[$index])) {
            Storage::disk('public')->delete($photos[$index]);  // delete old file
            unset($photos[$index]);  // remove from array
        }

        $patient->kshati_document = json_encode(array_values($photos)); // reindex array
        $patient->save();

        return back()->with('success', 'फोटो हटाइयो');
    }
    public function updateKshatiPhoto(Patient $patient, $index, Request $request)
    {
        $request->validate([
            'new_photo' => 'required|image|max:2048'
        ]);

        $photos = json_decode($patient->kshati_document, true);

        // delete the old file
        if (isset($photos[$index])) {
            Storage::disk('public')->delete($photos[$index]);
        }

        // store new image
        $newPath = $request->new_photo->store('documents', 'public');

        // replace old image with new one
        $photos[$index] = $newPath;

        $patient->kshati_document = json_encode($photos);
        $patient->save();

        return back()->with('success', 'फोटो अपडेट भयो');
    }

    public function addKshatiPhoto(Patient $patient, Request $request)
    {
        $request->validate([
            'new_photo' => 'required|image|max:2048'
        ]);

        $path = $request->new_photo->store('documents', 'public');

        $photos = $patient->kshati_document ? json_decode($patient->kshati_document, true) : [];
        $photos[] = $path;

        $patient->kshati_document = json_encode($photos);
        $patient->save();

        return back()->with('success', 'फोटो थपियो');
    }
}
