<?php

namespace App\Http\Controllers;

use App\Address;
use App\Disease;
use App\Patient;
use App\Relation;
use App\Organization;
use App\ApplicationType;
use App\OnlineApplication;
use App\VipadCategory;
use Illuminate\Http\Request;
use App\Services\OrganizationService;
use App\Services\OnlineApplicationService;

class OnlineApplicationController extends Controller
{
    protected $onlineApplicationService;

    public function __construct(OnlineApplicationService $onlineApplicationService)
    {
        $this->middleware('auth', ['except' => []]);
        $this->onlineApplicationService = $onlineApplicationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'आवेदन फाराम';
        $title = 'आवेदन फाराम';
        $diseases = Disease::latest()->get();
        $provinces = Address::select('province')->distinct()->get();
        if (municipalityId()) {
            $address = Address::find(municipalityId());
            $districts = Address::select('district')->where('province', $address->province)->distinct()->get();
            $municipalities = Address::select('municipality')->where('district', $address->district)->distinct()->get();
        } else {
            $address = new Address();
            $districts = Address::select('district')->distinct()->get();
            $municipalities = Address::select('municipality')->distinct()->get();
        }
        $applicationTypes = ApplicationType::latest()->get();
         $vipadCategories = VipadCategory::latest()->get();
        $relations = Relation::latest()->get();
        return view('online_application.index', [
            'title' => $title,
            'diseases' => $diseases,
            'provinces' => $provinces,
            'applicationTypes' => $applicationTypes,
            'address' => $address,
            'districts' => $districts,
            'municipalities' => $municipalities,
            'relations' => $relations,
            'vipadCategories' => $vipadCategories,
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\OnlineApplication  $onlineApplication
     * @return \Illuminate\Http\Response
     */
    public function show(OnlineApplication $onlineApplication)
    {
        return $onlineApplication;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OnlineApplication  $onlineApplication
     * @return \Illuminate\Http\Response
     */
    public function edit(OnlineApplication $onlineApplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OnlineApplication  $onlineApplication
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OnlineApplication $onlineApplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\OnlineApplication  $onlineApplication
     * @return \Illuminate\Http\Response
     */
    public function destroy(OnlineApplication $onlineApplication)
    {
        //
    }

    public function regFilter($regNumber)
    {
        // return municipalityId();
        $patient = Patient::with(['disease.application_types', 'onlineApplication'])
            ->whereHas('onlineApplication', function ($query) use ($regNumber) {
                $query->where('token_number', $regNumber);
            })
            ->where('address_id',municipalityId())
            ->first();


        $typeId = $patient->disease->application_types[0]->id;

        $diseases = Disease::whereHas('application_types', function ($query) use ($typeId) {
            $query->where('application_types.id', $typeId);
        })->get();

        return response()->json([
            'patient'=>$patient,
            'diseases'=>$diseases
        ]);
    }
}
