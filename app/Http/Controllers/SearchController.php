<?php

namespace App\Http\Controllers;

use App\OnlineApplication;
use App\Patient;
use App\Services\OnlineApplicationService;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //

    public function search(Request $request)
    {
        $onlineApplication = OnlineApplication::where('token_number', $request->tokenNumber)->first();

        if (!$onlineApplication) {
            return redirect()->back()->with('error', 'टोकन नम्बर मिलेन ।');
        }
        return view('frontend.token-search', ['tokenNumber' => $request->tokenNumber]);
    }

    public function searchPatient($patientId)
    {

        $patient = Patient::where('address_id', municipalityId());

if ($patientId) {
    $patient = $patient
        ->where(function($query) use ($patientId) {
            $query->where('name', 'like', '%' . $patientId . '%')
                  ->orWhere('name_en', 'like', '%' . $patientId . '%')
                  ->orWhere('email', 'like', '%' . $patientId . '%');
        })
        ->limit(10)
        ->get();
}

        return response()->json($patient);
    }

    public function reApply(Request $request, OnlineApplicationService $onlineApplicationService)
    {
        $patient = Patient::find($request->patient_id);
        $newPatient = Patient::create([
            'applied_date' => bs_to_ad($request->applied_date),
            'disease_id' => $request->disease_id,
            'name' => $patient->name,
            'name_en' => $patient->name_en,
            'citizenship_number' => $patient->citizenship_number,
            'gender' => $patient->gender,
            'age' => $patient->age,
            'address_id' => $patient->address_id,
            'ward_number' => $patient->ward_number,
            'tole' => $patient->tole,
            'contact_person' => $patient->contact_person,
            'mobile_number' => $patient->mobile_number,
            'email' => $patient->email,
            'description' => $patient->description,
            'fiscal_year_id' => $patient->fiscal_year_id,
            'bank_account_number' => $patient->bank_account_number,
            'relation_with_patients' => $patient->relation_with_patients,
            'dob' => $patient->dob,
        ]);
        $tokenNumber = $onlineApplicationService->create($newPatient);
        return redirect()->route('patient.show', $newPatient);
    }
}
