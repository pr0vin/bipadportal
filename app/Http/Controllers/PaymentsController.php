<?php

namespace App\Http\Controllers;

use App\Patient;
use App\Payment;
use App\PaymentDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentsController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            // Validate request
            $validated = $request->validate([
                'decision_id'      => 'required|exists:decisions,id',
                'distributed_date' => 'required|date',
                'title'            => 'nullable|string|max:255',
                'remark'           => 'nullable|string|max:1000',
                'patients'         => 'required|array',
                'patients.*.id'    => 'required|exists:patients,id',
                'patients.*.paid_amount' => 'nullable|numeric|min:0',
                'patients.*.remark'      => 'nullable|string|max:255',
            ]);

            $patientsData = collect($validated['patients']);

            // Check if all paid_amounts are empty
            $allEmpty = $patientsData->every(fn($p) => empty($p['paid_amount']));
            if ($allEmpty) {
                return back()->with('error', 'कृपया केही एक पिडितको लागि रकम भर्नुहोस्।')->withInput();
            }

            // Calculate total amount
            $totalAmount = $patientsData->sum(fn($p) => $p['paid_amount'] ?? 0);

            // Create Payment (summary)
            $payment = Payment::create([
                'decision_id'      => $validated['decision_id'],
                'paid_date'        => $validated['distributed_date'],
                'title'            => $validated['title'],
                'remark'           => $validated['remark'] ?? null,
                'fiscal_year_date' => runningFiscalYear('start_date'),
                'total'            => $totalAmount,
            ]);

            $messages = [];
            $updatedCount = 0;

            // Loop through patients
            foreach ($patientsData as $p) {
                $patient = Patient::find($p['id']);
                if (!$patient) continue;

                $paidAmount = $p['paid_amount'] ?? null;
                $remark     = $p['remark'] ?? null;

                if ($paidAmount === null || $paidAmount === '') {
                    continue;
                }

                // Skip if already paid
                if ($patient->status === 'paid') {
                    $messages[] = "रकम पहिले नै भुक्तानी गरिएको छ ({$patient->name})";
                    continue;
                }

                // Create payment detail
                PaymentDetail::create([
                    'payment_id'  => $payment->id,
                    'patient_id'  => $patient->id,
                    'paid_amount' => $paidAmount,
                    'remark'      => $remark,
                ]);

                // Update patient table
                $patient->update([
                    'paid_amount' => $paidAmount,
                    'status'      => 'paid',
                ]);

                $updatedCount++;
            }

            if ($updatedCount === 0) {
                DB::rollBack();
                return back()->with('error', implode("\n", $messages) ?: 'कुनै पनि भुक्तानी सेभ भएन।')->withInput();
            }

            DB::commit();

            $successMessage = count($messages)
                ? implode("\n", $messages)
                : 'भुक्तानी सफलतापूर्वक सेभ भयो।';

            return redirect()->route('decision.index')->with('success', $successMessage);

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', 'केही समस्या आयो। ' . ($e->getMessage() ?? ''))->withInput();
        }
    }
}
