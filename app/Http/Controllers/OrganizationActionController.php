<?php

namespace App\Http\Controllers;

use App\Http\Requests\RenewOrganizationRequest;
use App\Organization;
use App\Services\OrganizationService;
use Illuminate\Http\Request;
use App\Rules\NepaliDate;

class OrganizationActionController extends Controller
{
    protected  $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->middleware('auth');
        $this->organizationService = $organizationService;
        $this->middleware('role:super-admin|admin|ward-secretary')->only(['verifyForm', 'verify']);
        $this->middleware('role:super-admin|admin')->except(['verifyForm', 'verify']);
    }

    // Mark Verified
    public function verifyForm(Organization $organization)
    {
        return view('organization.action.verify', compact('organization'));
    }

    public function verify(Request $request, Organization $organization)
    {
        $request->validate(['verified_date' => ['required', new NepaliDate]]);
        $this->organizationService->markVerified($organization, $request->verified_date);

        return redirect()->route('organization.show', $organization)->with('success', 'Verified successfully');
    }

    // Mark Registered
    public function registerForm(Organization $organization)
    {
        $registrationNumberSuggestion = $this->organizationService->generateRegistrationNumber($organization);
        return view('organization.action.register', compact('organization', 'registrationNumberSuggestion'));
    }

    public function register(Request $request, Organization $organization)
    {
        $request->validate([
            'registered_date' => ['required', new NepaliDate],
            'org_reg_no' => 'nullable|integer'
            ]);

        // return back with error if organization is registered
        if ($organization->isRegistered()) {
            return redirect()->back()->with('error', 'This organization is already registered.');
        }

        $this->organizationService->markRegistered($organization, $request->registered_date, $request->org_reg_no);

        return redirect()->route('organization.show', $organization)->with('success', 'Registered successfully');
    }

    // Renew Organization
    public function renewForm(Organization $organization)
    {
        return view('organization.action.renew', compact('organization'));
    }

    public function renew(RenewOrganizationRequest $request, Organization $organization)
    {
        $this->organizationService->renew($organization, $request);

        return redirect()->route('organization.show', $organization)->with('success', 'Renewed successfully');
    }

    // Mark Closed
    public function closeForm(Organization $organization)
    {
        return view('organization.action.close', compact('organization'));
    }

    public function close(Request $request, Organization $organization)
    {
        $request->validate(['closed_date' => ['required', new NepaliDate]]);
        $this->organizationService->markClosed($organization, $request->closed_date);

        return redirect()->route('organization.show', $organization)->with('success', 'Closed successfully');
    }

    // Rename
    public function renameForm(Organization $organization)
    {
        return view('organization.action.rename', compact('organization'));
    }

    public function rename(Request $request, Organization $organization)
    {
        $request->validate(['org_name' => 'required|unique:App\Organization,org_name,']);
        $this->organizationService->rename($organization, $request->org_name);

        return redirect()->route('organization.show', $organization)->with('success', 'नाम सफलतापूर्वक परिवर्तन गरियो');
    }

    // Continue when the ability to change the registration number is required
    // // Change registration number
    // public function changeRegistrationNumberForm(Organization $organization)
    // {
    //     return view('organization.action.change-registration-number', compact('organization'));
    // }

    // public function changeRegistrationNumber(Request $request, Organization $organization)
    // {
    //     $request->validate(['org_name' => 'required|unique:App\Organization,org_name,']);
    //     // $this->organizationService->rename($organization, $request->org_name);

    //     return redirect()->route('organization.show', $organization)->with('success', 'नाम सफलतापूर्वक परिवर्तन गरियो');
    // }
}
