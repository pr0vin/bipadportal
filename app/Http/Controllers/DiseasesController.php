<?php

namespace App\Http\Controllers;

use App\Disease;
use Illuminate\Http\Request;

class DiseasesController extends Controller
{
    
    public function index()
    {
        $diseases = Disease::paginate(5);

        return view('diseases.index', compact('diseases'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:diseases,name',
        ]);

        try {
            Disease::create([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('diseases.index')
                ->with('success', 'रोग सफलतापूर्वक सिर्जना गरियो।');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'केही गलत भयो। कृपया पुनः प्रयास गर्नुहोस्।');
        }
    }

   
    public function edit($id)
    {
        $disease = Disease::findOrFail($id);
        $diseases = Disease::paginate(10);

        return view('diseases.index', compact('disease', 'diseases'));
    }

       public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:diseases,name,' . $id,
        ]);

        try {
            $disease = Disease::findOrFail($id);
            $disease->update([
                'name' => $request->name,
            ]);

            return redirect()
                ->route('diseases.index')
                ->with('success', 'रोग सफलतापूर्वक अपडेट गरियो।');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'रोग अपडेट गर्दा त्रुटि भयो।');
        }
    }

   
    public function destroy($id)
    {
        try {
            $disease = Disease::findOrFail($id);
            $disease->delete();

            return redirect()
                ->route('diseases.index')
                ->with('success', 'रोग सफलतापूर्वक हटाइयो।');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'रोग हटाउने क्रममा त्रुटि भयो।');
        }
    }
}
