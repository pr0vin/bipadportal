<?php

namespace App\Http\Controllers;

use App\Organization;
use App\OrganizationType;
use Illuminate\Http\Request;

class OrganizationTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizationTypes = OrganizationType::latest()->get();
        $organizationType = new OrganizationType();

        return view('organization_type.index', compact(['organizationTypes', 'organizationType']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        OrganizationType::create($request->all());

        return redirect()->back()->with('success', 'व्यवसाय किसिम थप गर्न सफल');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OrganizationType  $organizationType
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizationType $organizationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OrganizationType  $organizationType
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizationType $organizationType)
    {
        $organizationTypes = OrganizationType::all();

        return view('organization_type.index', compact('organizationTypes', 'organizationType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OrganizationType  $organizationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizationType $organizationType)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $organizationType->update($request->all());

        return redirect()->route('organization-type.index')->with('success', 'व्यवसाय किसिम सफलतापूर्वक अपडेट गरिएको छ');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OrganizationType  $organizationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(OrganizationType $organizationType)
    {
        $organizationType->delete();
        return redirect()->route('organization-type.index')->with('success', 'व्यवसाय किसिम सफलतापूर्वक हटाइएको छ');
    }

    public function renameExisting(Request $request)
    {
        abort_unless(auth()->user()->hasRole('super-admin'), 403);
        
        $request->validate([
            'old_value' => 'required',
            'new_value' => 'required',
        ]);

        Organization::where('org_type', $request->old_value)->update(['org_type' => $request->new_value]);

        return redirect()->back()->with('success', 'Organization type renamed successfully.');
    }
}
