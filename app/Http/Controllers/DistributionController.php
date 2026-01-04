<?php

namespace App\Http\Controllers;

use App\Distribution;
use App\Resource;
use App\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribution::with('resource')
            ->latest()
            ->paginate(10);

        return view('distributions.index', compact('distributions'));
    }

    public function create()
    {
        $resources = Resource::all();
        $patients = Patient::wherenotNull('verified_date')->get();
        return view('distributions.create', compact('resources', 'patients'));
    }

    public function store(Request $request)
    {

       

        $request->validate([

            'patient_id' => 'nullable|exists:patients,id',
            'distributed_date' => 'required|date',
            'resource_id' => 'required|exists:resources,id',
            'quantity'    => 'required|integer|min:1',
            'type'        => 'required|boolean',
            'remark'      => 'nullable|string',
        ]);


        DB::transaction(function () use ($request) {

            $resource = Resource::findOrFail($request->resource_id);

            //  Supplied
            if ($request->type == 0) {
                if ($resource->quantity < $request->quantity) {
                    throw ValidationException::withMessages([
                        'quantity' => ['पर्याप्त परिमाण उपलब्ध छैन।'],
                    ]);
                }
                $resource->quantity -= $request->quantity;
            }

            //  Received
            if ($request->type == 1) {
                $resource->quantity += $request->quantity;
            }

            $resource->save();


            Distribution::create($request->all());
        });

        return redirect()->route('distributions.index')
            ->with('success', 'वितरण विवरण सफलतापूर्वक थपियो।');
    }

    public function edit(Distribution $distribution)
    {
        $resources = Resource::all();

        $patients = Patient::wherenotNull('verified_date')->orWhere('id', $distribution->patient_id)->get();
        return view('distributions.create', compact('distribution', 'resources', 'patients'));
    }

    public function update(Request $request, Distribution $distribution)
    {
        $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'distributed_date' => 'required|date',
            'resource_id' => 'required|exists:resources,id',
            'quantity'    => 'required|integer|min:1',
            'type'        => 'required|boolean',
            'remark'      => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $distribution) {

            $resource = $distribution->resource;

            //  rollback old
            if ($distribution->type == 0) {
                $resource->quantity += $distribution->quantity;
            } else {
                $resource->quantity -= $distribution->quantity;
            }

            // apply new
            if ($request->type == 0) {
                if ($resource->quantity < $request->quantity) {
                    throw ValidationException::withMessages([
                        'quantity' => ['पर्याप्त परिमाण उपलब्ध छैन।'],
                    ]);
                }
                $resource->quantity -= $request->quantity;
            } else {
                $resource->quantity += $request->quantity;
            }

            $resource->save();
            $distribution->update($request->all());
        });

        return redirect()->route('distributions.index')
            ->with('success', 'वितरण विवरण सफलतापूर्वक अद्यावधिक भयो।');
    }

    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()->route('distributions.index')
            ->with('success', 'वितरण विवरण सफलतापूर्वक हटाइयो।');
    }
}
