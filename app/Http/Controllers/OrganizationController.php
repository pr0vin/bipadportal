<?php

namespace App\Http\Controllers;

use Excel;
use App\Address;
use App\Disease;
use App\Patient;
use App\District;
use App\Province;
use App\Relation;
use App\LetterPad;
use App\VipadCategory;
use App\Municipality;
use App\Organization;
use App\ApplicationType;
use App\DiseaseApplication;
use Illuminate\Http\Request;
use App\Services\DocumentService;
use Illuminate\Support\Facades\URL;
use App\Exports\OrganizationsExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Services\OrganizationService;
use App\Http\Requests\OrganizationRequest;
use App\PatientApplication;
use App\Services\OnlineApplicationService;

class OrganizationController extends Controller
{
    protected  $organizationService;

    public function __construct(OrganizationService $organizationService)
    {
        $this->middleware('auth', ['except' => ['store']]);
        $this->organizationService = $organizationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::any(['newPalika.store', 'newPalika.edit', 'newPalika.delete'])) {
            // The user is authorized to perform at least one of these actions
        } else {
            abort(403); // Unauthorized
        }
        $provinces = Address::select('province')->distinct()->get();
        $organizations = Organization::with(['address'])->latest()->get();
        $organization = new Organization();
        $address = new Address();
        return view('user_settings.index', compact(['provinces', 'organizations', 'organization', 'address']));
    }

    public function orgDelete(Organization $organization)
    {
        Gate::authorize('newPalika.delete');
        $organization->delete();

        return redirect()->back()->with('success', "नयाँ पालिका विवरण सफलतापुर्वक हटाइयो");
    }

    public function orgEdit(Organization $organization)
    {
        Gate::authorize('newPalika.edit');
        $address = Address::find($organization->address_id);
        $provinces = Address::select('province')->distinct()->latest()->get();
        $organizations = Organization::with(['address'])->latest()->get();
        return view('user_settings.index', compact([
            'provinces',
            'organizations',
            'organization',
            'address'
        ]));
    }
    public function orgUpdate(Request $request, Organization $organization)
    {
        Gate::authorize('newPalika.edit');
        $data = $request->validate([
            'address_id' => 'required|unique:organizations,address_id,' . $organization->id,
            'tag_line' => 'required',
            'address_line_one' => 'nullable',
            'address_line_two' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable',
            'website' => 'nullable',
            'is_allowed_to_register' => 'nullable',
        ]);
        // $address = Address::where('id', $request->address_id)->first();
        // $data['address_id'] = $address->id;

        $organization->update($data);

        return redirect()->route('organization.index')->with('success', 'पालिका विवरण सफलतापुर्वक परिवर्तन भयो');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'नयाँ व्यवसाय';
        return view('organization.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('newPalika.store');
        $data = $request->validate([
            'address_id' => 'required|unique:organizations,address_id',
            'tag_line' => 'required',
            'address_line_one' => 'nullable',
            'address_line_two' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable',
            'website' => 'nullable',
            'is_allowed_to_register' => 'nullable',
        ]);
        // $address = Address::where('municipality', $request->address_id)->first();
        // $data['address_id'] = $address->id;

        Organization::create($data);

        $address = Address::find($request->address_id);
        $letterpadData['municipality_name'] = $address->municipality;
        $letterpadData['tag_line'] = $request->tag_line;
        $letterpadData['address_line_one'] = $request->address_line_one ?? '';
        $letterpadData['address_line_two'] = $request->address_line_two ?? '';
        $letterpadData['phone'] = $request->phone ?? '';
        $letterpadData['email'] = $request->email ?? '';
        $letterpadData['website'] = $request->website ?? '';

        $letterpadData['municipality_id'] = $request->address_id;
        LetterPad::create($letterpadData);
        return redirect()->back()->with('success', 'पालिका सफलतापूर्वक थपियो ।');
    }

    public function show(Patient $patient, Request $request)
    {
        $patient = $patient->load(['patientApplication.patientApplicationDisease.disease', 'address', 'doctor', 'onlineApplication', 'renews']);

        $prefixIncrement = settings('registration_auto_increment_prefix');

        $patientRegNumber = Patient::where('address_id', municipalityId())
            ->whereNotNull('registration_number')
            ->orderBy('updated_at', 'desc')
            ->first();

        $registrationNumber = $patientRegNumber ? $patientRegNumber->registration_number : '0';
        $registrationNumber = str_pad(
            $registrationNumber + $prefixIncrement,
            settings('registration_number_digits') ?? 4,
            '0',
            STR_PAD_LEFT
        );

        

        $latestRegNumber = Patient::whereNotNull('reg_number')->max('reg_number');

        $nextRegNumber = $latestRegNumber
            ? $latestRegNumber + 1
            : 1;

        // return $nextRegNumber;

        return view('organization.show', compact('patient', 'registrationNumber'));
    }



    public function edit(Patient $patient)
    {
        $relations = Relation::latest()->get();
        $applicationTypes = ApplicationType::latest()->get();
        $diseases = Disease::latest()->get();


        $patientApplication = $patient->patientApplication()->latest()->first();

        // Load selected diseases from pivot table
        $selectedDiseaseIds = $patientApplication
            ? $patientApplication->patientApplicationDisease()->pluck('disease_id')->toArray()
            : [];

        $provinces = Address::select('province')->distinct()->get();
        $districts = Address::select('district')->where('province', $patient->address->province)->distinct()->get();
        $municipalities = Address::select('municipality')->where('district', $patient->address->district)->get();
        return view('organization.edit', compact('patient', 'diseases', 'provinces', 'districts', 'municipalities', 'applicationTypes', 'relations', 'patientApplication', 'selectedDiseaseIds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function update(OrganizationRequest $request, Organization $organization, DocumentService $documentService)
    {

        $this->checkAuthorization($organization);
        $this->organizationService->update($organization, $request->except('id'));

        if ($request->has('applied_date') && !$organization->isChecked()) {
            $this->organizationService->markChecked($organization, $request->applied_date);
        }

        if ($request->hasFile('documents.*.document')) {
            $documentService->upload($request->documents, $organization->id);
        }

        return redirect()->route('organization.show', $organization)->with('success', 'व्यवसाय सफलतापूर्वक अपडेट गरिएको छ ।');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization)
    {
        // abort_unless(Auth::user()->hasAnyRole('super-admin'), 403, 'Not authorized.');
        $organization->delete();
        return redirect()->back()->with('success', "$organization->org_name sent to trash.");
    }


    public function restore($id)
    {
        abort_unless(Auth::user()->hasAnyRole('super-admin'), 403, 'Not authorized.');
        $organization = Organization::onlyTrashed()->findOrFail($id);
        $organization->restore();

        return redirect()->back()->with('success', "$organization->org_name restored successfully.");
    }

    private function checkAuthorization(Organization $organization)
    {
        if ($organization->isRegistered()) {
            if (!Auth::user()->hasAnyRole(['super-admin', 'admin'])) {
                abort(403, 'You are not authorized to edit this record.');
            }
        }
        return true;
    }

    public function unrenewedList()
    {
        $title = 'नवीकरण नभएका व्यवसायहरु';
        $date = runningFiscalYear();
        $organizations = $this->organizationService->getOrganizationPipeline()
            ->whereDate('renewed_date_ad', '<', $date)
            ->orWhereNull('renewed_date_ad')
            ->paginate();

        return view('organization.index', compact(['organizations', 'title']));
    }
}
