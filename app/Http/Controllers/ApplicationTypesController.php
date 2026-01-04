<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use Illuminate\Http\Request;

class ApplicationTypesController extends Controller
{
    public function index()
    {
        $applicationTypes = ApplicationType::latest()->paginate(5);
        return view('application-types.index', compact('applicationTypes'));
    }

    public function create()
    {
        
        return view('application-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:application_types,name',
        ]);

        try {
            ApplicationType::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('application-types.index')
                ->with('success', 'अनुप्रयोग प्रकार सफलतापूर्वक सिर्जना गरियो।');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'केही गलत भयो। कृपया पुनः प्रयास गर्नुहोस्।');
        }
    }

    public function edit($id)
    {
        $applicationType = ApplicationType::findOrFail($id);
        $applicationTypes = ApplicationType::paginate(10);
        
        return view('application-types.index', compact('applicationType', 'applicationTypes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:application_types,name,' . $id,
        ]);

        try {
            $applicationType = ApplicationType::findOrFail($id);
            $applicationType->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('application-types.index')
                ->with('success', 'अनुप्रयोग प्रकार सफलतापूर्वक अपडेट गरियो।');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'अनुप्रयोग प्रकार अपडेट गर्दा त्रुटि भयो।');
        }
    }

    public function destroy($id)
    {
        try {
            $applicationType = ApplicationType::findOrFail($id);
            $applicationType->delete();

            return redirect()
                ->route('application-types.index')
                ->with('success', 'अनुप्रयोग प्रकार सफलतापूर्वक हटाइयो।');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'अनुप्रयोग प्रकार हटाउने क्रममा त्रुटि भयो।');
        }
    }
}