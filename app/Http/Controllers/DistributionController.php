<?php

namespace App\Http\Controllers;

use App\Distribution;
use App\Resource;
use App\Patient;
use App\Unit;
use App\DistributionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DistributionController extends Controller
{
    public function index(Request $request)
    {
          $municipality_id = municipalityId();
        if (!$municipality_id) {
            return redirect()->back()->with('error', 'कृपया पालिका छान्नुहोस्');
        }

        $type = $request->type; 

        $distributions = Distribution::with([
            'details.resource.unit',
            'patient'
        ])
            ->when($type !== null, function ($q) use ($type) {
                $q->where('type', $type);
            })
            ->latest()
            ->paginate(10, ['*'], 'page', 1);

        return view('distributions.index', compact('distributions', 'type'));
    }


    public function create()
    {
        $resources = Resource::all();
        $patients = Patient::wherenotNull('verified_date')->get();

        $units = Unit::all();

        return view('distributions.create', compact('resources', 'patients', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|boolean',
            'distributed_date' => 'required|date',
            'remark' => 'nullable|string',

            'patient_id' => 'required_if:type,0|nullable|exists:patients,id',
            'organization' => 'required_if:type,1|nullable|string',

            'resources' => 'required|array|min:1',
            'resources.*.quantity' => 'required|integer|min:1',
            'resources.*.resource_display' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {

            $distribution = Distribution::create([
                'patient_id'       => $request->type == 0 ? $request->patient_id : null,
                'organization_name' => $request->type == 1 ? $request->organization : null,
                'distributed_date' => $request->distributed_date,
                'type'             => $request->type,
                'remark'           => $request->remark,
                'fiscal_year_date' => currentFiscalYear()?->id,
            ]);

         
            foreach ($request->resources as $row) {

                /** --------------------------
                 * GET OR CREATE RESOURCE
                 * -------------------------- */
                if (!empty($row['resource_id'])) {

                    $resource = Resource::findOrFail($row['resource_id']);
                } else {
                    // create unit first
                    $unit = Unit::firstOrCreate([
                        'name' => $row['unit'],
                    ]);

                    // then resource
                    $resource = Resource::create([
                        'name'     => $row['resource_display'],
                        'unit_id'  => $unit->id,
                        'quantity' => 0,
                    ]);
                }

                /** --------------------------
                 * STOCK MANAGEMENT
                 * -------------------------- */
                if ($request->type == 0) {
                    // वितरण → decrease
                    if ($resource->quantity < $row['quantity']) {
                        throw ValidationException::withMessages([
                            'quantity' => ['पर्याप्त स्टक उपलब्ध छैन : ' . $resource->name],
                        ]);
                    }

                    $resource->decrement('quantity', $row['quantity']);
                } else {
                    // प्राप्त → increase
                    $resource->increment('quantity', $row['quantity']);
                }

             
                DistributionDetail::create([
                    'distribution_id' => $distribution->id,
                    'resource_id'     => $resource->id,
                    'quantity'        => $row['quantity'],
                ]);
            }
        });

        return redirect()
            ->route('distributions.index')
            ->with('success', 'वितरण विवरण सफलतापूर्वक सुरक्षित भयो।');
    }





    public function edit(Distribution $distribution)
    {
        $resources = Resource::all();
        $units     = Unit::all();
        $patients = Patient::wherenotNull('verified_date')->orWhere('id', $distribution->patient_id)->get();
        return view('distributions.create', compact('distribution', 'resources', 'patients', 'units'));
    }



    public function update(Request $request, Distribution $distribution)
    {
        $request->validate([
            'type' => 'required|boolean',
            'distributed_date' => 'required|date',
            'remark' => 'nullable|string',

            'patient_id' => 'required_if:type,0|nullable|exists:patients,id',
            'organization' => 'required_if:type,1|nullable|string',

            'resources' => 'required|array|min:1',
            'resources.*.quantity' => 'required|integer|min:1',
            'resources.*.resource_display' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $distribution) {

            /** --------------------------------
             * 1️⃣ ROLLBACK OLD STOCK
             * -------------------------------- */
            foreach ($distribution->details as $detail) {
                if ($distribution->type == 0) {
                    // Old was वितरण → add back
                    $detail->resource->increment('quantity', $detail->quantity);
                } else {
                    // Old was प्राप्त → remove
                    $detail->resource->decrement('quantity', $detail->quantity);
                }
            }

            /** --------------------------------
             * 2️⃣ DELETE OLD DETAILS
             * -------------------------------- */
            $distribution->details()->delete();

            /** --------------------------------
             * 3️⃣ UPDATE DISTRIBUTION HEADER
             * -------------------------------- */
            $distribution->update([
                'patient_id'        => $request->type == 0 ? $request->patient_id : null,
                'organization_name' => $request->type == 1 ? $request->organization : null,
                'distributed_date'  => $request->distributed_date,
                'type'              => $request->type,
                'remark'            => $request->remark,
            ]);

            /** --------------------------------
             * 4️⃣ APPLY NEW RESOURCES
             * -------------------------------- */
            foreach ($request->resources as $row) {

                // RESOURCE
                if (!empty($row['resource_id'])) {
                    $resource = Resource::findOrFail($row['resource_id']);
                } else {
                    // create unit
                    $unit = Unit::firstOrCreate([
                        'name' => $row['unit'],
                    ]);

                    // create resource
                    $resource = Resource::create([
                        'name'     => $row['resource_display'],
                        'unit_id'  => $unit->id,
                        'quantity' => 0,
                    ]);
                }

                // STOCK UPDATE
                if ($request->type == 0) {
                    if ($resource->quantity < $row['quantity']) {
                        throw ValidationException::withMessages([
                            'quantity' => ['पर्याप्त स्टक उपलब्ध छैन : ' . $resource->name],
                        ]);
                    }
                    $resource->decrement('quantity', $row['quantity']);
                } else {
                    $resource->increment('quantity', $row['quantity']);
                }

                // CREATE NEW DETAIL
                DistributionDetail::create([
                    'distribution_id' => $distribution->id,
                    'resource_id'     => $resource->id,
                    'quantity'        => $row['quantity'],
                ]);
            }
        });

        return redirect()
            ->route('distributions.index')
            ->with('success', 'वितरण विवरण सफलतापूर्वक अद्यावधिक भयो।');
    }




    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()->route('distributions.index')
            ->with('success', 'वितरण विवरण सफलतापूर्वक हटाइयो।');
    }
}
