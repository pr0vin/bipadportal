<?php

namespace App\Http\Controllers;

use App\User;
use App\Disease;
use App\Patient;
use Carbon\Carbon;
use App\FiscalYear;
use App\Organization;
use App\ApplicationType;
use App\DistributionDetail;
use App\PatientApplication;
use App\PatientApplicationDisease;
use App\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $applicationTypeCounts = PatientApplication::select(
            'application_type_id',
            DB::raw('COUNT(DISTINCT patient_id) as total_patients'),
            DB::raw('COUNT(DISTINCT CASE WHEN patients.verified_date IS NOT NULL THEN patient_id END) as verified_patients'),
            DB::raw('COUNT(DISTINCT CASE WHEN patients.verified_date IS NULL THEN patient_id END) as unverified_patients')
        )
            ->join('patients', 'patients.id', '=', 'patient_applications.patient_id')
            ->groupBy('application_type_id')
            ->with('application_type')
            ->get();

        $allPatientsCount = Patient::count();

        $allverifiedPatientsCount = Patient::whereNotNull('verified_date')->count();

        $allunverifiedPatientsCount = Patient::whereNull('verified_date')->count();
        $totalResources = Resource::count();
        $returnableResources = DistributionDetail::where('returnable', 1)
            ->distinct('resource_id')
            ->count('resource_id');


        return view('home', compact('applicationTypeCounts', 'allPatientsCount', 'allverifiedPatientsCount', 'allunverifiedPatientsCount', 'totalResources', 'returnableResources'));
    }
}
