<?php

namespace App\Http\Controllers;

use App\Member;
use App\Patient;
use App\Committee;
use App\Decision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DecisionController extends Controller
{
    public function index(Request $request)
    {
        $patients = [];
        $ids = json_decode($request->ids, true);
        foreach ($ids as $id) {
            $patients[] = Patient::with('disease')->find($id);
        }

        $committee = Committee::where('address_id', municipalityId())->first();
        $members = null;
        if ($committee) {
            $members = Member::with('position', 'committeePosition')
                ->where('committee_id', $committee->id)
                ->orderBy('order', 'asc')
                ->get();
        }

        return view('frontend.decisionPrint', compact('patients', 'members'));
    }

    public function uploadFile(Request $request, $id)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $decision = Decision::findOrFail($id);

        // delete old file if exists
        if ($decision->decision_file && Storage::disk('public')->exists($decision->decision_file)) {
            Storage::disk('public')->delete($decision->decision_file);
        }

        $path = $request->file('file')->store('decisions', 'public');

        $decision->update([
            'decision_file' => $path,
        ]);

        return response()->json([
            'status' => true,
            'file_url' => asset('storage/' . $path),
        ]);
    }
}
