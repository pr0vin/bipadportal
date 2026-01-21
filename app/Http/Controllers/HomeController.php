<?php

namespace App\Http\Controllers;

use App\User;
use App\Disease;
use App\Patient;
use Carbon\Carbon;
use App\FiscalYear;
use App\Organization;
use App\ApplicationType;
use App\PatientApplication;
use App\PatientApplicationDisease;
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
            DB::raw('COUNT(DISTINCT patient_id) as total_patients')
        )
            ->whereHas('patient', function ($q) {
                $q->whereNotNull('verified_date');
            })
            ->groupBy('application_type_id')
            ->with('application_type')
            ->get();

        return view('home', compact('applicationTypeCounts'));
    }
}
