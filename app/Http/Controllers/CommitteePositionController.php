<?php

namespace App\Http\Controllers;

use App\CommitteePosition;
use Illuminate\Http\Request;

class CommitteePositionController extends Controller
{
    public function store (Request $request){
        $data=$request->validate([
            'name'=>'required'
        ]);
        $data['address_id']=municipalityId();
        CommitteePosition::create($data);

        return redirect()->back()->with('success','ned committee position saved');
    }

    public function edit (Request $request, CommitteePosition $committeePosition){
        return view('settings.committeePosition',compact('committeePosition'));
    }

    public function update (Request $request, CommitteePosition $committeePosition){
        $committeePosition->update($request->validate([
             'name'=>'required'
        ]));

        return redirect()->route('settings.committeePosition')->with('success','Selected committee position updated');
    }
    public function delete (CommitteePosition $committeePosition){
        $committeePosition->delete();
        return redirect()->route('settings.committeePosition')->with('success','Selected committee removed');
    }
}
