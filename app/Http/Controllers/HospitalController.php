<?php

namespace App\Http\Controllers;

use App\Hospital;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class HospitalController extends Controller
{
    public function index(){
        if (Gate::any(['hospital.store', 'hospital.edit', 'hospital.delete'])) {
            // The user is authorized to perform at least one of these actions
        } else {
            abort(403); // Unauthorized
        }
        $hospital=new Hospital();
        $hospitals=Hospital::latest()->paginate(20);
        return view('hospital.index',compact('hospitals','hospital'));
    }

    public function store(Request $request){
        Gate::authorize('hospital.store');
        Hospital::create($request->validate([
            'name'=>'required',
            'address'=>'required',
            'diseases'=>'required',
        ]));

        return redirect()->back()->with('success',"नयाँ अस्पताल सफलतापुर्वक थपियो");
    }

    public function edit(Hospital $hospital){
        Gate::authorize('hospital.edit');
        $hospitals=Hospital::latest()->paginate(20);
        return view('hospital.index',compact('hospitals','hospital'));
    }

    public function update(Request $request,Hospital $hospital){
        Gate::authorize('hospital.edit');
        $hospital->update($request->validate([
            'name'=>'required',
            'address'=>'required',
            'diseases'=>'required',
        ]));

        return redirect()->route('hospital.index')->with('success','अस्पताल विवरण सफलतापुर्वक परिवर्तन भयो');
    }

    public function delete(Hospital $hospital){
        Gate::authorize('hospital.delete');
        $hospital->delete();

        return redirect()->route('hospital.index')->with('success',"अस्पताल सफलतापुर्वक हटाइयो");
    }

    public function getDisease($id){
        $hospital=Hospital::find($id);

        return response()->json($hospital);
    }
}
