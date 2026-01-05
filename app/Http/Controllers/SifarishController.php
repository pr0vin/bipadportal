<?php

namespace App\Http\Controllers;

use App\Sifarish;
use App\Patient;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SifarishController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'patient_ids'   => 'required|array',
        'patient_ids.*' => 'required|exists:patients,id',
        'paid_amount'   => 'required|array',
        'paid_amount.*' => 'nullable|numeric|min:0',
    ]);
     $allEmpty = collect($validated['paid_amount'])->every(function ($value) {
            return $value === null || $value === '';
        });

        if ($allEmpty) {
            return response()->json([
                'status' => false,
                'message' => 'कृपया केही एक पिडितको लागि रकम भर्नुहोस्।',
            ]);
        }

    $messages = [];

    foreach ($validated['patient_ids'] as $index => $patientId) {
        $paidAmount = $validated['paid_amount'][$index] ?? null;

        if ($paidAmount === null || $paidAmount === '') {
            continue; 
        }

        $patient = Patient::find($patientId);

        if (!$patient) continue;
        if ((int)$patient->status == 1) {
            $messages[] = "सिफारिस पहिले नै गरिएको छ ( {$patient->name} ({$patient->onlineApplication->token_number}))";
            continue;
        }

        Sifarish::create([
            'patient_id'    => $patientId,
            'paid_amount'   => $paidAmount,
            'sifarish_date' => ad_to_bs(Carbon::today()->toDateString()),

        ]);

        $patient->update(['status' => 1]);
    }

    return response()->json([
        'status'  => true,
        'message' => count($messages) ? implode("\n", $messages) : 'सिफारिस सफलतापूर्वक सेभ भयो',
    ]);
}

}
