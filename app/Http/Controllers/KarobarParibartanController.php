<?php

namespace App\Http\Controllers;

use App\KarobarParibartan;
use App\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KarobarParibartanController extends Controller
{
    public function index(Organization $organization)
    {

        return view('karobar-paribartan.index', [
            'organization' => $organization,
            'organizationTypes' => \App\OrganizationType::latest()->get(),
            'karobarParibartans' => $organization->karobarParibartans()->latest('date_en')->get(),
        ]);
    }

    public function store(Request $request, Organization $organization)
    {
        $request->validate([
            'org_type' => ['required'],
            'org_product_type' => ['required'],
        ]);

        try {
            DB::beginTransaction();
            // copy the data to Karobar Paribartan
            KarobarParibartan::create([
                'organization_id' => $organization->id,

                'old_org_type' => $organization->org_type,
                'old_org_product_type' => $organization->org_product_type,

                'new_org_type' => $request->org_type,
                'new_org_product_type' => $request->org_product_type,

                'date_en' => date('Y-m-d'),
                'date_np' => \App\Helpers\BSDateHelper::AdToBsEn('-', date('Y-m-d')),
                'processing_officer' => auth()->user()->name ?? '',
            ]);

            $organization->update([
                'org_type' => $request->org_type,
                'org_product_type' => $request->org_product_type,
            ]);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            logger('An error occured while processing naamsari.', ['Exception' => $ex->getMessage()]);
            return redirect()->back()->with('error', 'कारोवार परिवर्तन गर्दा त्रुटि भयो।')->withInput();
        }

        return redirect()->route('organization.show', $organization)->with('success', 'Action completed successfully.');
    }
}
