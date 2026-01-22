<?php

namespace App\Http\Controllers;

use App\Resource;
use App\Unit;
use App\Distribution;
use App\DistributionDetail;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{

    public function index()
    {
        $resources = Resource::with('unit')->latest()->paginate(10);
        return view('resources.index', compact('resources'));
    }


    public function create()
    {
        $units = Unit::all();
        return view('resources.create', compact('units'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        Resource::create($validated);

        return redirect()->route('resources.index')->with('success', 'सामाग्री सफलतापूर्वक सिर्जना भयो।');
    }

    public function show(Resource $resource)
    {
        $resource->load('unit');
        return view('resources.create', compact('resource'));
    }


    public function edit(Resource $resource)
    {
        $units = Unit::all();
        return view('resources.create', compact('resource', 'units'));
    }


    public function update(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit_id' => 'required|exists:units,id',
            'quantity' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        $resource->update($validated);

        return redirect()->route('resources.index')->with('success', 'सामाग्री सफलतापूर्वक साम्पादन भयो।');
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->route('resources.index')
            ->with('success', 'सामाग्री सफलतापूर्वक हटाइयो');
    }

    public function showtimeline(Resource $resource)
    {
        $timeline = DistributionDetail::with([
            'distribution.patient',
            'distribution',
        ])
            ->where('resource_id', $resource->id)
            ->orderBy('created_at', 'asc')
            ->get();

            // return $timeline;

        return view('resources.show', compact('resource', 'timeline'));
    }
}
