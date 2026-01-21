<?php

namespace App\Http\Controllers;

use App\Sifarish;
use App\Decision;
use App\Patient;
use App\Committee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SifarishController extends Controller
{
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $validated = $request->validate([
                'patient_ids'   => 'required|array',
                'patient_ids.*' => 'required|exists:patients,id',
                'paid_amount'   => 'required|array',
                'paid_amount.*' => 'nullable|numeric|min:0',
                'title'         => 'nullable|string|max:255',
            ]);

           
            $allEmpty = collect($validated['paid_amount'])->every(
                fn($v) => $v === null || $v === ''
            );

            if ($allEmpty) {
                return response()->json([
                    'status' => false,
                    'message' => 'कृपया केही एक पिडितको लागि रकम भर्नुहोस्।',
                ]);
            }

            $committee = Committee::latest()->first();

            if (!$committee) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => 'समिति फेला परेन।',
                ]);
            }

            // Calculate total amount
            $totalAmount = collect($validated['paid_amount'])->filter(fn($v) => $v !== null && $v !== '')->sum();

            $id = currentFiscalYear()?->id;
            // Create Decision FIRST
            $decision = Decision::create([
                'title'         => $committee->name . ' बाट सिफारिस निर्णय',
                'decision_date' => ad_to_bs(Carbon::today()->toDateString()),
                'total'         => $totalAmount,
                'fiscal_year_date' => $id,
            ]);

            $messages = [];
            $createdCount = 0;

            //  Loop patients
            foreach ($validated['patient_ids'] as $index => $patientId) {
                $paidAmount = $validated['paid_amount'][$index] ?? null;

                if ($paidAmount === null || $paidAmount === '') {
                    continue;
                }

                $patient = Patient::find($patientId);
                if (!$patient) continue;

                if ($patient->status === 'decision') {
                    $messages[] =
                        "सिफारिस पहिले नै गरिएको छ ({$patient->name})";
                    continue;
                }

                Sifarish::create([
                    'decision_id'   => $decision->id,
                    'patient_id'    => $patientId,
                    'paying_amount' => $paidAmount,
                    'sifarish_date' => ad_to_bs(Carbon::today()->toDateString()),
                ]);

                $patient->update(['status' => 'decision']);

                $createdCount++;
            }

            //  If no sifarish created → rollback
            if ($createdCount === 0) {
                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => implode("\n", $messages) ?: 'कुनै पनि सिफारिस सेभ भएन।',
                ]);
            }

            // Commit transaction
            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => count($messages)
                    ? implode("\n", $messages)
                    : 'सिफारिस सफलतापूर्वक सेभ भयो',
            ]);
        } catch (\Throwable $e) {
            //  Rollback on ANY error
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'केही समस्या आयो।',
                'error'   => config('app.debug') ? $e->getMessage() : null,
            ], 500);
        }
    }

    public function index()
    {
        $municipality_id = municipalityId();
        if (!$municipality_id) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }

        $decisions = Decision::with([
            'sifarish.patient'
        ])->latest()->paginate(10);
        return view('decision.dindex', compact('decisions'));
    }

    public function showDistributionForm(Decision $decision)
    {
        $sifarishList = $decision->sifarish()->with('patient')->get();
        return view('distributions.distribution-form', [
            'decision' => $decision,
            'sifarishList' => $sifarishList,
        ]);
    }
}
