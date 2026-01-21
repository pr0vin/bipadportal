<?php

namespace App\Http\Controllers;

use App\Distribution;
use App\DistributionDetail;
use App\Resource;
use App\Patient;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DistributionController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->type;

        $distributions = Distribution::with([
            'details.resource.unit',
            'patient'
        ])
            ->when($type, fn($q) => $q->where('type', $type))
            ->latest()
            ->paginate(10);

        // return $distributions;

        return view('distributions.index', compact('distributions', 'type'));
    }

    public function show(Distribution $distribution)
    {
        $distribution->load(['details.resource.unit', 'patient']);

        // return $distribution;

        return view('distributions.show', compact('distribution'));
    }


    public function create()
    {
        $resources = Resource::with('unit')->get();
        $patients  = Patient::whereNotNull('verified_date')->get();
        $unit = Unit::all();

        $returnableDetails = DistributionDetail::with(['resource.unit', 'distribution.patient'])
            ->where('returnable', 1)
            ->where('is_returned', 0)
            ->whereHas('distribution', fn($q) => $q->where('type', 'distribute'))
            ->get();


        $returnablePatients = $returnableDetails->pluck('distribution.patient')->filter()->unique('id')->values();

        $returnableOrganizations = $returnableDetails->pluck('distribution.organization_name')->filter()->unique()->values();

        return view('distributions.create', [
            'resources' => $resources,
            'patients'  => $patients,
            'units'     => $unit,
            'returnableDetails' => $returnableDetails,
            'returnablePatients' => $returnablePatients,
            'returnableOrganizations' => $returnableOrganizations,
        ]);
    }

    public function getReturnableDetails(Request $request)
    {
        $query = DistributionDetail::with(['resource.unit', 'distribution'])
            ->where('returnable', 1)
            ->where('is_returned', 0)
            ->whereHas('distribution', function ($q) {
                $q->where('type', 'distribute');
            });

        if ($request->patient_id) {
            $query->whereHas('distribution', function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            });
        }

        if ($request->organization) {
            $query->whereHas('distribution', function ($q) use ($request) {
                $q->where('organization_name', $request->organization);
            });
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {

        // return $request;

        if ($request->type === 'return') {
            $request->merge([
                'patient_id'   => $request->return_patient_id,
                'organization' => $request->return_organization,
            ]);
        }

        // $request->validate([
        //     'type'              => 'required|in:distribute,receive,return',
        //     'distributed_date'  => 'required|date',
        //     'patient_id'        => 'nullable|exists:patients,id',
        //     'organization'      => 'nullable|string',
        //     'remark'            => 'nullable|string',
        //     'resources'                     => 'required|array|min:1',
        //     'resources.*.resource_display'  => 'required|string',
        //     'resources.*.unit' => 'required_without:resources.*.resource_id|string',
        //     'resources.*.quantity'          => 'required|integer|min:1',
        // ]);

        $request->validate([
            'type'             => 'required|in:distribute,receive,return',
            'distributed_date' => 'required|date',

            'patient_id' => 'nullable|exists:patients,id',
            'organization' => 'nullable|string',
            'remark' => 'nullable|string',

            'resources' => 'required|array|min:1',
            'resources.*.resource_id' => 'required|exists:resources,id',
            'resources.*.quantity' => 'required|integer|min:1',
            'resources.*.remark' => 'nullable|string',
        ]);


        DB::transaction(function () use ($request) {

            /** ---------------- HEADER ---------------- */
            $distribution = Distribution::create([
                'patient_id'        => in_array($request->type, ['distribute', 'return']) ? $request->patient_id : null,
                'organization_name' => in_array($request->type, ['distribute', 'receive', 'return']) ? $request->organization : null,
                'distributed_date'  => $request->distributed_date,
                'type'              => $request->type,
                'remark'            => $request->remark,
                'fiscal_year_date'  => currentFiscalYear()?->id,
            ]);

            /** ---------------- DETAILS ---------------- */
            foreach ($request->resources as $row) {

                $isNewResource = empty($row['resource_id']);

                // ---------------- RESOURCE ----------------
                if (!$isNewResource) {
                    $resource = Resource::findOrFail($row['resource_id']);
                } else {
                    $unit = Unit::firstOrCreate(['name' => $row['unit']]);
                    $resource = Resource::create([
                        'name'        => $row['resource_display'],
                        'unit_id'     => $unit->id,
                        'quantity'    => 0, // negative stock if new
                        'description' => $row['remark'] ?? null,
                    ]);
                }

                /** ---------------- STOCK ---------------- */
                if ($request->type === 'distribute') {
                    $resource->decrement('quantity', $row['quantity']); // old or new
                }

                if ($request->type === 'receive') {
                    $resource->increment('quantity', $row['quantity']); // receive from outside
                }

                /** ---------------- RETURN LOGIC ---------------- */
                // if ($request->type === 'return') {

                //     // Find the distribution detail that matches:
                //     // 1. Same resource
                //     // 2. returnable = 1
                //     // 3. is_returned = 0
                //     // 4. Same patient or organization
                //     $originalDetail = DistributionDetail::where('resource_id', $resource->id)
                //         ->where('returnable', 1)
                //         ->where('is_returned', 0)
                //         ->whereHas('distribution', function ($q) use ($request) {
                //             $q->where('type', 'distribute')
                //                 ->where(function ($q2) use ($request) {
                //                     $q2->where('patient_id', $request->patient_id)
                //                         ->orWhere('organization_name', $request->organization);
                //                 });
                //         })->first();

                //     if (!$originalDetail) {
                //         // यदि original detail छैन → return गर्न नपाइने
                //         throw ValidationException::withMessages([
                //             'resources' => ['यो सामग्री उक्त आवेदक वा संस्था का लागि फिर्ता योग्य छैन।']
                //         ]);
                //     }

                //     // यदि original detail भेटियो → proceed
                //     $originalDetail->update([
                //         'is_returned' => 1,
                //         'returnable'  => 0,
                //     ]);

                //     // Stock update
                //     $resource->increment('quantity', $row['quantity']);
                // }

                if ($request->type === 'return') {

                    $originalDetail = DistributionDetail::where('resource_id', $resource->id)
                        ->where('returnable', 1)
                        ->where('is_returned', 0)
                        ->whereHas('distribution', function ($q) use ($request) {
                            $q->where('type', 'distribute')
                                ->where(function ($q2) use ($request) {
                                    $q2->where('patient_id', $request->patient_id)
                                        ->orWhere('organization_name', $request->organization);
                                });
                        })
                        ->first();

                    if (!$originalDetail) {
                        throw ValidationException::withMessages([
                            'resources' => ['यो सामग्री फिर्ता योग्य छैन।']
                        ]);
                    }

                    // mark original as returned
                    $originalDetail->update([
                        'is_returned' => 1,
                    ]);

                    // stock comes back
                    $resource->increment('quantity', $row['quantity']);
                }



                /** ---------------- DETAIL ---------------- */
                DistributionDetail::create([
                    'distribution_id' => $distribution->id,
                    'resource_id'     => $resource->id,
                    'quantity'        => $row['quantity'],
                    'remark'          => $row['remark'] ?? null,
                    'returnable'      => $request->type === 'distribute' ? !empty($row['is_checked']) : false,
                    'is_returned'     => $request->type === 'return',
                ]);
            }
        });

        return redirect()
            ->route('distributions.index')
            ->with('success', 'वितरण सफलतापूर्वक सुरक्षित भयो।');
    }


    public function destroy(Distribution $distribution)
    {

        DB::transaction(function () use ($distribution) {
            foreach ($distribution->details as $detail) {
                switch ($distribution->type) {
                    case 'distribute':
                        $detail->resource->increment('quantity', $detail->quantity);
                        break;
                    case 'receive':
                        $detail->resource->decrement('quantity', $detail->quantity);
                        break;
                    case 'return':
                        $detail->resource->decrement('quantity', $detail->quantity);
                        // Mark original as not returned
                        $originalDetail = DistributionDetail::where('resource_id', $detail->resource_id)
                            ->where('is_returned', true)
                            ->first();

                        if ($originalDetail) {
                            $originalDetail->update(['is_returned' => false]);
                        }
                        break;
                }
            }

            $distribution->delete();
        });

        return redirect()->route('distributions.index')
            ->with('success', 'वितरण विवरण सफलतापूर्वक हटाइयो।');
    }
}
