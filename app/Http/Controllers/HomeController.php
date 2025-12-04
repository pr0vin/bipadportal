<?php

namespace App\Http\Controllers;

use App\User;
use App\Disease;
use App\Patient;
use Carbon\Carbon;
use App\FiscalYear;
use App\Organization;
use App\ApplicationType;
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
        if(Auth::user()->roles[0]->name == 'doctor'){
            $patient= Patient::with('onlineApplication')->whereHas('onlineApplication',function($query) use($request){
                $query->where('token_number',$request->token_number);
            })->first();
            return view('doctor',compact('patient'));
        }
        $municipality_id = municipalityId();

        $todayDate = ad_to_bs(now()->format('Y-m-d'));
        $year = $todayDate[0];
        $month = $todayDate[1];
        $today = Carbon::parse($year . '-' . $month . '-2');
        $currentMonthStart = Carbon::now()->startOfMonth()->toDateString();
        $currentMonthEnd = Carbon::now()->endOfMonth()->toDateString();
        $title = 'ड्यासबोर्ड';
        $fiscalYear = FiscalYear::where('is_running', 1)->first()->id;
        if($request->fiscal_year_id){
            $fiscalYear=$request->fiscal_year_id;
        }
        if ($fiscalYear) {
            $allDirgha = Patient::whereHas('disease.application_types', function ($query) {
                $query->where('application_types.id', 1);
            })
                ->where('address_id', $municipality_id)->where('fiscal_year_id', $fiscalYear)->get();

            $allbipanna = Patient::whereHas('disease.application_types', function ($query) {
                $query->where('application_types.id', 2);
            })
                ->where('address_id', $municipality_id)->where('fiscal_year_id', $fiscalYear)->get();

            $allSamajik = Patient::whereHas('disease.application_types', function ($query) {
                $query->where('application_types.id', 3);
            })
                ->where('address_id', $municipality_id)->where('fiscal_year_id', $fiscalYear)->get();

            $allNagarpalika = Patient::whereHas('disease.application_types', function ($query) {
                $query->where('application_types.id', 4);
            })
                ->where('address_id', $municipality_id)->where('fiscal_year_id', $fiscalYear)->get();

            $renewedCount = Patient::with(['disease', 'disease.application_types', 'renews'])
                ->where('address_id', $municipality_id)
                ->where('fiscal_year_id', $fiscalYear)
                ->whereNull('closed_date')
                ->whereHas('renews', function ($query) use ($today) {
                    $query->orderBy('id')->take(1)
                        ->whereDate('next_renew_date', '>=', $today);
                })->whereHas('disease.application_types', function ($query) {
                    $query->where('application_types.id', 1);
                })->count();

            $expiredCount = Patient::with(['disease', 'disease.application_types', 'renews'])
                ->where('address_id', $municipality_id)
                ->where('fiscal_year_id', $fiscalYear)
                ->whereNull('closed_date')
                ->whereHas('renews', function ($query) use ($today) {
                    $query->orderBy('id')->take(1)
                        ->whereDate('next_renew_date', '<', $today);
                })->whereHas('disease.application_types', function ($query) {
                    $query->where('application_types.id', 1);
                })->count();

            $totalDirgha = Patient::where('address_id', $municipality_id)
                ->where('fiscal_year_id', $fiscalYear)
                ->whereHas('disease.application_types', function ($query) {
                    $query->where('application_types.id', 1);
                })->count();
            $totalBipanna = Patient::where('address_id', $municipality_id)
                ->where('fiscal_year_id', $fiscalYear)
                ->whereHas('disease.application_types', function ($query) {
                    $query->where('application_types.id', 2);
                })->count();
            $totalSamajik = Patient::where('address_id', $municipality_id)
                ->where('fiscal_year_id', $fiscalYear)
                ->whereHas('disease.application_types', function ($query) {
                    $query->where('application_types.id', 3);
                })->count();
            // $onlineFormsCount=Patient::where('fiscal_year_id',$fiscalYear)->where('municipality_id',$municipality_id)->count();
            // $closedPatientsCount=Patient::where('fiscal_year_id',$fiscalYear)->where('municipality_id',$municipality_id)->whereNull('verified_date')->count();
            // $registeredPatientsCount=Patient::where('fiscal_year_id',$fiscalYear)->where('municipality_id',$municipality_id)->whereNotNull('registered_date')->whereNull('closed_date')->count();
        } else {
            // $onlineFormsCount=Patient::where('municipality_id',$municipality_id)->count();

            $renewedCount = Patient::with(['disease', 'disease.application_types', 'renews'])
                ->where('address_id', $municipality_id)
                ->where('current_renew_quarter', currentquarter())
                ->whereHas('renews', function ($query) use ($today) {
                    $query->orderBy('id')->take(1)
                        ->whereDate('next_renew_date', '>=', $today);
                })->whereHas('disease.application_types', function ($query) {
                    $query->where('application_types.id', 1);
                })->count();
            $expiredCount = Patient::with(['disease', 'disease.application_types', 'renews'])
                ->where('address_id', $municipality_id)
                ->whereHas('renews', function ($query) use ($today) {
                    $query->orderBy('id')->take(1)
                        ->whereDate('next_renew_date', '<', $today);
                })->whereHas('disease.application_types', function ($query) {
                    $query->where('application_types.id', 1);
                })->count();

            $totalDirgha = Patient::where('address_id', $municipality_id)
                ->whereHas('disease.application_types', function ($query) {
                    $query->where('application_types.id', 1);
                })->count();
            $totalBipanna = Patient::where('address_id', $municipality_id)
                ->whereHas('disease.application_types', function ($query) {
                    $query->where('application_types.id', 2);
                })->count();
            $totalSamajik = Patient::where('address_id', $municipality_id)
                ->whereHas('disease.application_types', function ($query) {
                    $query->where('application_types.id', 3);
                })->count();
            // $closedPatientsCount=Patient::where('municipality_id',$municipality_id)->whereNotNull('closed_date')->count();
            // $registeredPatientsCount=Patient::where('municipality_id',$municipality_id)->whereNotNull('registered_date')->whereNull('closed_date')->count();
        }

        $applicationTypes = ApplicationType::latest()->get();

        $totalApplications = Patient::where('address_id', $municipality_id)
            ->where('fiscal_year_id', $fiscalYear)->count();

        $graphData = $this->GraphData($municipality_id, $fiscalYear);
        $bipannaGraphData = $this->BipannaGraphData($municipality_id, $fiscalYear);
        $samajikGraphData = $this->SamajikGraphData($municipality_id, $fiscalYear);
        $nagarpalikaGraphData = $this->NagarpalikaGraphData($municipality_id, $fiscalYear);
        return view('home', [
            'dirghaCount' => $allDirgha,
            'bipannaCount' => $allbipanna,
            'samajikCount' => $allSamajik,
            'nagarpalikaCount' => $allNagarpalika,
            'applicationTypes' => $applicationTypes,
            'renewedCount' => $renewedCount,
            'expiredCount' => $expiredCount,
            'totalApplications' => $totalApplications,
            'totalDirgha' => $totalDirgha,
            'totalBipanna' => $totalBipanna,
            'totalSamajik' => $totalSamajik,
            'title' => 'ड्यासबोर्ड',
            'graphData' => $graphData,
            'bipannaGraphData' => $bipannaGraphData,
            'samajikGraphData' => $samajikGraphData,
            'nagarpalikaGraphData' => $nagarpalikaGraphData,
        ]);
    }


    // public function index()
    // {
    //     $municipality_id = municipalityId();
    //     $todayDate = ad_to_bs(now()->format('Y-m-d'));
    //     $year = $todayDate[0];
    //     $month = $todayDate[1];
    //     $today = Carbon::parse($year . '-' . $month . '-2');
    //     $fiscalYear = FiscalYear::where('is_running', 1)->first();

    //     $applicationTypes = ApplicationType::latest()->get();

    //     // Fetch patients and other data for each application type
    //     $patientsByApplicationType = $this->getPatientsByApplicationTypes($municipality_id, $fiscalYear->id ?? null);

    //     // Get renewed and expired counts for all application types
    //     $renewedCounts = $this->getRenewedCountByApplicationType($municipality_id, $fiscalYear->id ?? null, $today);
    //     $expiredCounts = $this->getExpiredCountByApplicationType($municipality_id, $fiscalYear->id ?? null, $today);

    //     $graphData = $this->GraphData($municipality_id, $fiscalYear->id ?? null);
    //     $bipannaGraphData = $this->BipannaGraphData($municipality_id, $fiscalYear->id ?? null);
    //     $samajikGraphData = $this->SamajikGraphData($municipality_id, $fiscalYear->id ?? null);
    //     $nagarpalikaGraphData = $this->NagarpalikaGraphData($municipality_id, $fiscalYear->id ?? null);

    //     return view('home', [
    //         'dirghaCount' => $patientsByApplicationType['dirgha'] ?? 0,
    //         'bipannaCount' => $patientsByApplicationType['bipanna'] ?? 0,
    //         'samajikCount' => $patientsByApplicationType['samajik'] ?? 0,
    //         'nagarpalikaCount' => $patientsByApplicationType['nagarpalika'] ?? 0,
    //         'applicationTypes' => $applicationTypes,
    //         'renewedCounts' => $renewedCounts,
    //         'expiredCounts' => $expiredCounts,
    //         'totalDirgha' => $patientsByApplicationType['totalDirgha'] ?? 0,
    //         'totalBipanna' => $patientsByApplicationType['totalBipanna'] ?? 0,
    //         'totalSamajik' => $patientsByApplicationType['totalSamajik'] ?? 0,
    //         'title' => 'ड्यासबोर्ड',
    //         'graphData' => $graphData,
    //         'bipannaGraphData' => $bipannaGraphData,
    //         'samajikGraphData' => $samajikGraphData,
    //         'nagarpalikaGraphData' => $nagarpalikaGraphData,
    //     ]);
    // }

    private function getPatientsByApplicationTypes($municipality_id, $fiscalYearId)
    {
        if ($fiscalYearId) {
            return [
                'dirgha' => $this->getPatientsByType(1, $municipality_id, $fiscalYearId),
                'bipanna' => $this->getPatientsByType(2, $municipality_id, $fiscalYearId),
                'samajik' => $this->getPatientsByType(3, $municipality_id, $fiscalYearId),
                'nagarpalika' => $this->getPatientsByType(4, $municipality_id, $fiscalYearId),
                'totalDirgha' => Patient::where('address_id', $municipality_id)->where('fiscal_year_id', $fiscalYearId)
                    ->whereHas('disease.application_types', function ($query) {
                        $query->where('application_types.id', 1);
                    })->count(),
                'totalBipanna' => Patient::where('address_id', $municipality_id)->where('fiscal_year_id', $fiscalYearId)
                    ->whereHas('disease.application_types', function ($query) {
                        $query->where('application_types.id', 2);
                    })->count(),
                'totalSamajik' => Patient::where('address_id', $municipality_id)->where('fiscal_year_id', $fiscalYearId)
                    ->whereHas('disease.application_types', function ($query) {
                        $query->where('application_types.id', 3);
                    })->count(),
            ];
        }
        return [];
    }

    private function getPatientsByType($typeId, $municipality_id, $fiscalYearId)
    {
        return Patient::whereHas('disease.application_types', function ($query) use ($typeId) {
            $query->where('application_types.id', $typeId);
        })->where('address_id', $municipality_id)->where('fiscal_year_id', $fiscalYearId)->get();
    }

    private function getRenewedCountByApplicationType($municipality_id, $fiscalYearId, $today)
    {
        $applicationTypes = ApplicationType::all();
        $renewedCounts = [];

        foreach ($applicationTypes as $type) {
            $renewedCounts[$type->id] = Patient::with(['disease', 'disease.application_types', 'renews'])
                ->where('address_id', $municipality_id)
                ->where('fiscal_year_id', $fiscalYearId)
                ->whereHas('renews', function ($query) use ($today) {
                    $query->orderBy('id')->take(1)
                        ->whereDate('next_renew_date', '>=', $today);
                })
                ->whereHas('disease.application_types', function ($query) use ($type) {
                    $query->where('application_types.id', $type->id);
                })
                ->count();
        }

        return $renewedCounts;
    }

    private function getExpiredCountByApplicationType($municipality_id, $fiscalYearId, $today)
    {
        $applicationTypes = ApplicationType::all();
        $expiredCounts = [];

        foreach ($applicationTypes as $type) {
            $expiredCounts[$type->id] = Patient::with(['disease', 'disease.application_types', 'renews'])
                ->where('address_id', $municipality_id)
                ->where('fiscal_year_id', $fiscalYearId)
                ->whereHas('renews', function ($query) use ($today) {
                    $query->orderBy('id')->take(1)
                        ->whereDate('next_renew_date', '<', $today);
                })
                ->whereHas('disease.application_types', function ($query) use ($type) {
                    $query->where('application_types.id', $type->id);
                })
                ->count();
        }

        return $expiredCounts;
    }


    public function graphData($municipality_id, $fiscalYear)
    {
        $allDiseases = Disease::whereHas('application_types', function ($query) {
            $query->where('application_types.id', 1);
        })->get();
        $patients = Patient::where('address_id', $municipality_id)->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 1);
        })
            ->where('fiscal_year_id', $fiscalYear)->get()->groupBy('disease_id');
        $formatedData = [];
        // foreach($patients as $key=>$patient){
        //     $formatedData[]=[
        //         'dirghaDisease'=>Disease::find($key)->name,
        //         'totalCount'=>$patient->count()
        //     ];
        // }

        foreach ($allDiseases as $disease) {
            $diseaseId = $disease->id;
            $totalCount = $patients->has($diseaseId) ? $patients[$diseaseId]->count() : 0;
            $patientsForDisease = $patients->get($diseaseId, collect());
            $totalCountMale = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'male';
            })->count();

            $totalCountFemale = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'female';
            })->count();
            $totalCountOther = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'other';
            })->count();

            $formatedData[] = [
                'dirghaDisease' => $disease->name,
                'dirghaCount' => $totalCount,
                'dirghaMale' => $totalCountMale,
                'dirghaFemale' => $totalCountFemale,
                'dirghaOther' => $totalCountOther,
            ];
        }

        return $formatedData;
    }

    public function BipannaGraphData($municipality_id, $fiscalYear)
    {
        $allDiseases = Disease::whereHas('application_types', function ($query) {
            $query->where('application_types.id', 2);
        })->get();
        $patients = Patient::where('address_id', $municipality_id)->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 2);
        })
            ->where('fiscal_year_id', $fiscalYear)->get()->groupBy('disease_id');
        $formatedData = [];

        foreach ($allDiseases as $disease) {
            $diseaseId = $disease->id;
            $totalCount = $patients->has($diseaseId) ? $patients[$diseaseId]->count() : 0;
            $patientsForDisease = $patients->get($diseaseId, collect());
            $totalCountMale = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'male';
            })->count();

            $totalCountFemale = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'female';
            })->count();

            $totalCountOther = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'other';
            })->count();

            $formatedData[] = [
                'bipannaDisease' => $disease->name,
                'bipannaCount' => $totalCount,
                'bipannaMale' => $totalCountMale,
                'bipannaFemale' => $totalCountFemale,
                'bipannaOther' => $totalCountOther,
            ];
        }

        return $formatedData;
    }
    public function SamajikGraphData($municipality_id, $fiscalYear)
    {
        $allDiseases = Disease::whereHas('application_types', function ($query) {
            $query->where('application_types.id', 3);
        })->get();
        $patients = Patient::where('address_id', $municipality_id)->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 3);
        })
            ->where('fiscal_year_id', $fiscalYear)->get()->groupBy('disease_id');
        $formatedData = [];
        foreach ($allDiseases as $disease) {
            $diseaseId = $disease->id;
            $totalCount = $patients->has($diseaseId) ? $patients[$diseaseId]->count() : 0;
            $patientsForDisease = $patients->get($diseaseId, collect());
            $totalCountMale = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'male';
            })->count();

            $totalCountFemale = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'female';
            })->count();

            $totalCountOther = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'other';
            })->count();

            $formatedData[] = [
                'samajikDisease' => $disease->name,
                'samajikCount' => $totalCount,
                'samajikMale' => $totalCountMale,
                'samajikFemale' => $totalCountFemale,
                'samajikOther' => $totalCountOther,
            ];
        }

        return $formatedData;
    }
    public function NagarpalikaGraphData($municipality_id, $fiscalYear)
    {
        $allDiseases = Disease::whereHas('application_types', function ($query) {
            $query->where('application_types.id', 4);
        })->get();
        $patients = Patient::where('address_id', $municipality_id)->whereHas('disease.application_types', function ($query) {
            $query->where('application_types.id', 4);
        })
            ->where('fiscal_year_id', $fiscalYear)->get()->groupBy('disease_id');
        $formatedData = [];
        foreach ($allDiseases as $disease) {
            $diseaseId = $disease->id;
            $totalCount = $patients->has($diseaseId) ? $patients[$diseaseId]->count() : 0;
            $patientsForDisease = $patients->get($diseaseId, collect());
            $totalCountMale = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'male';
            })->count();

            $totalCountFemale = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'female';
            })->count();

            $totalCountOther = $patientsForDisease->filter(function ($patient) {
                return strtolower($patient->gender) === 'other';
            })->count();

            $formatedData[] = [
                'nagarpalikaDisease' => $disease->name,
                'nagarpalikaCount' => $totalCount,
                'nagarpalikaMale' => $totalCountMale,
                'nagarpalikaFemale' => $totalCountFemale,
                'nagarpalikaOther' => $totalCountOther,
            ];
        }

        return $formatedData;
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function indexBak() // Older version
    {
        $title = 'Dashboard';
        $totals = collect(DB::select("SELECT
        (SELECT count(*) FROM organizations where applied_date IS NULL) AS onlineFormsCount,
        (SELECT count(*) FROM organizations where verified_date IS NULL) AS unverifiedOrganizationsCount,
        (SELECT count(*) FROM organizations where registered_date IS NULL) AS unRegisteredOrganizationsCount,
        (SELECT count(*) FROM organizations where registered_date IS NOT NULL) AS registeredOrganizationsCount,
        (SELECT count(*) FROM organizations where closed_date IS NOT NULL) AS closedOrganizationsCount
        "))->first();

        $totalUsersCount = User::count();

        $organizations = Organization::select('org_type', DB::raw('count(org_type) as count', 'org_name'))->groupBy('org_type')->get();
        // $labels = collect();
        // $counts = collect();
        // $organizations->each(function ($organization) use($labels, $counts) {
        //     $labels->push($organization->org_type);
        //     $counts->push($organization->count);
        // });

        return view('home', [
            'title' => $title,
            'onlineFormsCount' => $totals->onlineFormsCount,
            'unverifiedOrganizationsCount' => $totals->unverifiedOrganizationsCount,
            // 'unRegisteredOrganizationsCount' => $totals->unRegisteredOrganizationsCount,
            'registeredOrganizationsCount' => $totals->registeredOrganizationsCount,
            'closedOrganizationsCount' => $totals->closedOrganizationsCount,
            'totalUsersCount' => $totalUsersCount,
            'organizations' => $organizations
        ]);
    }
}
