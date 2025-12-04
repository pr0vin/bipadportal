<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubsidiaryRequest;
use App\Organization;
use App\Subsidiary;
use Illuminate\Http\Request;

class SubsidiaryController extends Controller
{
    public function create(Organization $organization)
    {
        return $this->showForm($organization, new Subsidiary());
    }
    
    private function showForm(Organization $organization, Subsidiary $subsidiary)
    {
        $updateMode = false;
        if($subsidiary->exists) {
            $updateMode = true;
        }
        $wards = \App\Ward::all('id', 'name', 'name_en')->sortBy('name_en');
        return view('subsidiary.form', compact('organization', 'subsidiary', 'updateMode', 'wards'));
    }

    public function store(SubsidiaryRequest $request, Organization $organization)
    {
        $subsidiary = new Subsidiary($request->validated());
        $subsidiary->organization_id = $organization->id;
        $subsidiary->start_date_ad = bs_to_ad($subsidiary->start_date);
        $subsidiary->save();

        return redirect()->route('organization.show', $organization->id)->with('success', 'Subsidiary created successfully');
    }

    public function edit(Subsidiary $subsidiary)
    {
        return $this->showForm($subsidiary->organization, $subsidiary);
    }

    public function update(SubsidiaryRequest $request, Subsidiary $subsidiary)
    {
        $subsidiary->update($request->validated() + [
            'start_date_ad' => bs_to_ad($request->start_date),
        ]);

        return redirect()->route('organization.show', $subsidiary->organization->id)->with('success', 'Subsidiary updated successfully');
    }

    public function destroy(Subsidiary $subsidiary)
    {
        $subsidiary->delete();

        return redirect()->back()->with('success', 'थप व्यवसाय सफलतापूर्वक मेटाईयो ।');
    }
}
