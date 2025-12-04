<?php

namespace App\Http\Controllers;

use App\Patient;
use Illuminate\Http\Request;

class PatientDoctorController extends Controller
{
    //

    public function store(Request $request, Patient $patient)
    {


        $validated = $request->validate([
            'name' => 'required',
            'post' => 'required',
            'nmc_no' => 'required',

        ]);


        if ($patient->doctor) {
            // If the patient already has a doctor, update the doctor's details
            $patient->doctor->update($validated);
        } else {
            // If no doctor exists, create a new doctor for the patient
            $patient->doctor()->create($validated);
        }


        return redirect()->back()->with('success', "डाक्टर सफलतापुर्बक सेभ भयो |");
    }
}
