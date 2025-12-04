<?php

namespace App\Http\Controllers;

use App\Naamsari;
use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NaamsariController extends Controller
{
    public function index(Organization $organization)
    {

        return view('naamsari.index', [
            'organization' => $organization,
            'provinces' => \App\Province::all(['id', 'name', 'name_en']),
            'districts' => \App\District::with('province')->get(['id', 'name', 'name_en', 'province_id']),
            'municipalities' => \App\Municipality::with('district')->get(['id', 'name', 'name_en', 'district_id']),
            'wards' => \App\Ward::all('id', 'name', 'name_en')->sortBy('name_en'),
        ]);
    }

    public function store(Request $request, Organization $organization)
    {
        $request->validate([
            'prop_name' => ['required'],
            'prop_phone' => ['required'],
            'prop_province_id' => ['required'],
            'prop_district_id' => ['required'],
            'prop_municipality_id' => ['required'],
            'prop_ward_id' => ['required'],
            'prop_citizenship_no' => ['required'],
            'prop_citizenship_district' => ['required'],
            'prop_citizenship_issued_date' => ['required'],
            'prop_road_name' => ['required'],
            'prop_house_no' => ['nullable'],
        ]);

        try {
            DB::beginTransaction();
            // copy the data to naamsari
            Naamsari::create([
                'organization_id' => $organization->id,

                'old_prop_name' => $organization->prop_name,
                'old_prop_phone' => $organization->prop_phone,
                'old_prop_province_id' => $organization->prop_province_id,
                'old_prop_district_id' => $organization->prop_district_id,
                'old_prop_municipality_id' => $organization->prop_municipality_id,
                'old_prop_ward_id' => $organization->prop_ward_id,
                'old_prop_citizenship_no' => $organization->prop_citizenship_no,
                'old_prop_citizenship_district' => $organization->prop_citizenship_district,
                'old_prop_citizenship_issued_date' => $organization->prop_citizenship_issued_date,
                'old_prop_road_name' => $organization->prop_road_name,
                'old_prop_house_no' => $organization->prop_house_no,

                'new_prop_name' => $request->prop_name,
                'new_prop_phone' => $request->prop_phone,
                'new_prop_province_id' => $request->prop_province_id,
                'new_prop_district_id' => $request->prop_district_id,
                'new_prop_municipality_id' => $request->prop_municipality_id,
                'new_prop_ward_id' => $request->prop_ward_id,
                'new_prop_citizenship_no' => $request->prop_citizenship_no,
                'new_prop_citizenship_district' => $request->prop_citizenship_district,
                'new_prop_citizenship_issued_date' => $request->prop_citizenship_issued_date,
                'new_prop_road_name' => $request->prop_road_name,
                'new_prop_house_no' => $request->prop_house_no,

                'date_en' => date('Y-m-d'),
                'date_np' => \App\Helpers\BSDateHelper::AdToBsEn('-', date('Y-m-d')),
                'processing_officer' => auth()->user()->name ?? '',
            ]);

            $organization->update([
                'prop_name' => $request->prop_name,
                'prop_phone' => $request->prop_phone,
                'prop_province_id' => $request->prop_province_id,
                'prop_district_id' => $request->prop_district_id,
                'prop_municipality_id' => $request->prop_municipality_id,
                'prop_ward_id' => $request->prop_ward_id,
                'prop_citizenship_no' => $request->prop_citizenship_no,
                'prop_citizenship_district' => $request->prop_citizenship_district,
                'prop_citizenship_issued_date' => $request->prop_citizenship_issued_date,
                'prop_road_name' => $request->prop_road_name,
                'prop_house_no' => $request->prop_house_no,
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            logger('An error occured while processing naamsari.', ['Exception' => $ex->getMessage()]);
            return redirect()->back()->with('error', 'नामसारी प्रशोधन गर्दा एउटा त्रुटि भयो।')->withInput();
        }

        return redirect()->route('organization.show', $organization);
    }
}
