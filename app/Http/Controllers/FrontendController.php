<?php

namespace App\Http\Controllers;

use App\Ward;
use App\Member;
use App\Address;
use App\Disease;
use App\Patient;
use App\Province;
use App\Relation;
use App\Committee;
use App\Municipality;
use App\Organization;
use App\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\NewOrganizationNameCheckRequest;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('organization.create');
        }
        if (!$request->has('org_name')) {
            return view('frontend.check-organization-name');
        }
        return view('frontend.index');
    }

    public function checkOrganizationName(NewOrganizationNameCheckRequest $request)
    {
        return redirect()->route('organization.new', ['org_name' => $request->org_name]);
    }

    public function home()
    {
        return view('frontend.home');
    }

    public function apply()
    {
        $wards = Ward::all();
        $provinces = Address::select('province')->distinct()->get();
        
         $diseases = Disease::latest()->get();

        $relations = Relation::latest()->get();
        $applicationTypes = ApplicationType::latest()->get();
        return view('frontend.patient-registration-form', [
            'provinces' => $provinces,
            'diseases' => $diseases,
            'applicationTypes' => $applicationTypes,
            'wards' => $wards,
            'title' => 'बिरामी दर्ता',
            'relations' => $relations,
        ]);
        // return view('frontend.index');
    }

    public function tokenSearch()
    {
        return view('frontend.token-search');
    }

    public function applicationSubmited($patient)
    {
        // return $patient;
        $patient = Patient::where('id', $patient)->first();
        return view('frontend.application-submited', compact('patient'));
    }

    public function scheduleOne(Patient $patient)
    {
        return view('frontend.scheduleOne', compact('patient'));
    }
    public function scheduleTwo(Patient $patient)
    {
        return view('frontend.scheduleTwo', compact('patient'));
    }
    public function suchiPrint($patient)
    {
        $patient = Patient::with(['address', 'district'])->find($patient);
        // $application_type_id = $patient->disease->application_types[0]->id;
       
        if(Auth::user()){
            $municipalityId=municipalityId();
        }else{
            $municipalityId=$patient->address_id;
        }
        $organization = Organization::where('address_id', $municipalityId)->first();

        if ($organization->is_allowed_to_register && $patient->disease->application_types[0]->id == 1) {
            return view('frontend.wardSuchiPrint', [
                'patient' => $patient,
            ]);
        }
        return view('frontend.suchiPrint', [
            'patient' => $patient,
        ]);
    }

    public function decision()
    {
        $patient = Patient::find(request('patient_id'));
        $application_type_id = $patient->disease->application_types[0]->id;

        $type_id = $patient->disease->application_types[0]->id;
        $committee = Committee::where('application_type_id', $type_id)->where('address_id',municipalityId())->first();

        $permissions = [
            '2' => 'bipanna.DecisionPrint',
            '3' => 'samajik.DecisionPrint',
            '4' => 'nagarpalika.DecisionPrint',
        ];
        $diseaseTypeId = checkPermission($permissions, $application_type_id);
        return view('frontend.decision');
    }
}
