<?php

namespace App\Http\Controllers;

use App\Disease;
use App\ApplicationType;
use App\DiseaseApplication;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class DiseaseController extends Controller
{
    public function index(Disease $disease,Request $request)
    {
        if (Gate::any(['disease.store', 'disease.edit', 'disease.delete'])) {
            // The user is authorized to perform at least one of these actions
        } else {
            abort(403); // Unauthorized
        }
        $applicationTypes = ApplicationType::latest()->get();
        $diseases = Disease::with('application_types.application_type')->latest();
        if($request->application_type_id){
            $application_type_id=$request->application_type_id;
            $diseases=$diseases->whereHas('application_types',function($query) use($application_type_id) {
                $query->where('application_types.id',$application_type_id);
            });
        }

        $diseases=$diseases->paginate(20);
        return view('disease.index', [
            'applicationTypes' => $applicationTypes,
            'diseases' => $diseases,
            'disease' => $disease
        ]);
    }

    public function store(Request $request)
    {
        // return $request;
        Gate::authorize('disease.store');
        $request->validate([
            'name' => 'required',
            'application_type_id' => 'required',
        ]);

        $disease = Disease::create([
            'name' => $request->name,
        ]);

        if ($disease) {
            foreach ($request->application_type_id as $applicationType) {
                DiseaseApplication::create([
                    'disease_id' => $disease->id,
                    'application_type_id' => $applicationType
                ]);
            }
        }

        return redirect()->back()->with('success', 'नयाँ रोग सफलतापुर्वक थपियो');
    }

    public function edit(Disease $disease)
    {
        Gate::authorize('disease.edit');
        $applicationTypes = ApplicationType::latest()->get();
        $diseases = Disease::with('application_types.application_type')->latest()->paginate(20);
        return view('disease.index', [
            'applicationTypes' => $applicationTypes,
            'diseases' => $diseases,
            'disease' => $disease
        ]);
    }

    public function update(Request $request, Disease $disease)
    {
        Gate::authorize('disease.edit');
        $request->validate([
            'name' => 'required',
            'application_type_id' => 'required',
        ]);

        $disease->update([
            'name' => $request->name,
        ]);

        DiseaseApplication::where('disease_id', $disease->id)->delete();
        // foreach ($request->application_type_id as $applicationType) {
        // }
        foreach ($request->application_type_id as $applicationType) {
            DiseaseApplication::create([
                'disease_id' => $disease->id,
                'application_type_id' => $applicationType
            ]);
        }

        return redirect()->route('disease.index')->with('success', "रोग विवरण सफलतापुर्वक परिवर्तन भयो");
    }

    public function destroy(Disease $disease)
    {
        Gate::authorize('disease.delete');
        $disease->delete();

        return redirect()->route('disease.index')->with('success', "रोग विवरण सफलतापुर्वक हटाइयो");
    }
    public function getAll($diseaseId)
    {
        $data = ApplicationType::with('diseases')->find($diseaseId);
        //    $application_types= DiseaseApplication::with('disease')->where("application_type_id",$diseaseId)->get();
        // $diseases=DiseaseApplication::where()
        return response()->json($data);
    }

    public function getDisease($typeId)
    {
        $diseases = Disease::whereHas('application_types', function ($query) use ($typeId) {
            $query->where('application_types.id', $typeId);
        })->get();

        return response()->json($diseases);
    }
}
