<?php

namespace App\Http\Controllers;

use App\Member;
use App\Patient;
use App\Committee;
use Illuminate\Http\Request;

class DecisionController extends Controller
{
    public function index(Request $request)
    {
        $patients = [];
        $ids = json_decode($request->ids, true);
        foreach ($ids as $id) {
            $patients[] = Patient::with('disease')->find($id);
        }

        $type_id = $patients[0]->disease->application_types[0]->id;
        $committee = Committee::where('application_type_id', $type_id)->where('address_id',municipalityId())->first();
        $members = null;
        if ($committee) {
            $members = Member::with('position', 'committeePosition')
                ->where('committee_id', $committee->id)
                ->orderBy('order', 'asc')
                ->get();
        }
       
        return view('frontend.decisionPrint', compact('patients','members'));
    }

    
}
