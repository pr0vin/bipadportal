<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Reason;
use Illuminate\Http\Request;

class ReasonController extends Controller
{
    public function store(Request $request){
        $data=$request->validate([
            'reason'=>'required'
        ]);

        Reason::create($data);

        return redirect()->back()->with('success',"New reason saved");
    }

    public function delete(Reason $reason){
        $reason->delete();

        return redirect()->route('settings.reason')->with('success',"Selected reason removed");
    }

    public function edit(Reason $reason){
        return view('settings.reason',compact('reason'));
    }

    public function update(Request $request,Reason $reason){
        $data=$request->validate([
            'reason'=>'required'
        ]);

        $reason->update($data);

        return redirect()->route('settings.reason')->with('success','लागतकट्टाको कारण सफलतापुर्वक हटाइयो');
    }
}
