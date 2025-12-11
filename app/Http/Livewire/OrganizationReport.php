<?php

namespace App\Http\Livewire;

use App\ApplicationType;
use App\Renew;
use App\Patient;
use App\PatientApplicationDisease;
use Carbon\Carbon;
use App\Organization;
use Livewire\Component;
use App\PatientApplication;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Session;

class OrganizationReport extends Component
{
    use WithPagination;


    private $organizations;
    public $dateFrom;
    public $dateTo;
    public $status;
    public $statusList = [
        'registered' => 'दर्ता भएका',
        'closed' => 'बन्द भएका',
        'renewed' => 'नवीकरण भएका',
        'not_renewed' => 'नवीकरण नभएका'
    ];
    public $applicationTypeCounts = [];

    private $message;
    public $applicationTypeId;

    public $rate = 5000;
   
    public function mount($message)
    {
        $rate = ApplicationType::where('id', 1)->first();
        $this->rate = $rate->amount;
        $this->message = $message;

     $this->applicationTypeCounts = PatientApplicationDisease::with([
        'disease',
        'patientApplication.application_type',
        'patientApplication.patient'
    ])->whereHas('patientApplication.patient', function($query) {
        $query->whereNotNull('verified_date');
    })
    ->get()
    ->groupBy(fn($item) => $item->patientApplication->application_type->name ?? 'Unknown')
    ->map(function($diseases, $typeName) {
        $totalLoss = $diseases->sum(fn($d) => $d->patientApplication->patient->estimated_amount ?? 0);

        return (object)[
            'name' => $typeName,
            'diseases' => $diseases->map(function($d) {
                return (object)[
                    'disease_id' => $d->disease_id,
                    'disease_name' => $d->disease->name ?? 'Unknown',
                    'patient_count' => 1
                ];
            }),
            'estimated_loss' => $totalLoss
        ];
    })
    ->values();



        if (request('date_from')) {
            $dateFrom = request('date_from')[0];
        }
        if (request('date_to')) {
            $dateTo = request('date_to')[0];
        }
        $period = null;
        $currentQuarter = null;
        if (request('quarter')) {
            $currentQuarter = (int)request('quarter');
        } else {
            $currentQuarter = currentquarter();
        }

        // dd($currentQuarter);

        if ($currentQuarter == 1) {
            $period = 4;
        } elseif ($currentQuarter == 2) {
            $period = 7;
        } elseif ($currentQuarter == 3) {
            $period = 10;
        } else {
            $period = 1;
        }
        // $dateFrom = timePeriodFilter($period)['to'];
        // dd($dateFrom);
        $this->status = 'registered';
        $municipality_id = municipalityId();
        if (request('diseaseType') != 1) {
            $patients = Patient::with('disease.application_types')->where('address_id', $municipality_id);
            $patients = $patients->whereNotNull('verified_date');
            $patients = $patients->whereNotNull('registered_date');
            $patients = $patients->whereNull('closed_date');
            $patients = $patients->whereHas('disease.application_types', function ($query) {
                $query->where('application_types.id', request('diseaseType'));
            });
            if (request('name')) {
                $patients = $patients->where('name', 'like', '%' . request('name') . '%');
            }
            if (request('disease_id')) {
                $patients = $patients->where('disease_id', request('disease_id'));
            }
            if (request('date_from')) {
                $patients = $patients->where('registered_date', '>=', $dateFrom);
            }
            if (request('date_to')) {
                $patients = $patients->where('registered_date', '<=', $dateTo);
            }
            if (request('ward')) {
                $patients = $patients->where('ward_number', request('ward'));
            }
            if (request('gender')) {
                $patients = $patients->where('gender', request('gender'));
            }
            if (request('status') == "closed") {
                $patients = $patients->whereNotNull('closed_date');
            }

            $patients = $patients->get();

            $this->organizations = $patients;
        } else {
            $organizations = Renew::with('patient');
            if (request('payment_status') == 'unpaid') {
                $organizations = $organizations->where('isPaid', 0);
            } else {
                $organizations = $organizations->where('isPaid', 1);
            }

            if (request('fiscal_year')) {

                $organizations = $organizations->where('fiscal_year_id', request('fiscal_year'));
                // dd($organizations->get());
            } else {
                $organizations = $organizations->where('fiscal_year_id', currentFiscalYear()->id);
            }
            // if (request('date_from')) {
            //     $organizations = $organizations->whereHas('patient', function ($query) use ($dateFrom) {
            //         $query->where('registered_date', '>', $dateFrom);
            //     });
            // } else {
            //     $dateFrom = timePeriodFilter($period)['from'];

            //     $organizations = $organizations->where('current_renew_quarter', $currentQuarter);
            // }
            // if (request('date_to')) {
            //     $organizations = $organizations->where('registered_date', '<=', $dateTo);
            // } else {
            //     $dateTo = timePeriodFilter($period)['to'];
            //     $organizations = $organizations->where('next_renew_date', '<', $dateTo);

            // }
            if (request('status') == "closed") {
                $organizations = $organizations->whereHas('patient', function ($query) {
                    $query->whereNotNull('closed_date');
                });
            }
            if (request('name')) {
                $organizations = $organizations->whereHas('patient', function ($query) {
                    $query->where('name', 'like', '%' . request('name') . '%');
                });
            }
            if (request('gender')) {
                $organizations = $organizations->whereHas('patient', function ($query) {
                    $query->where('gender', request('gender'));
                });
            }
            if (request('ward')) {
                $organizations = $organizations->whereHas('patient', function ($query) {
                    $query->where('ward_number', request('ward'));
                });
            }
            if (request('disease_id')) {
                $organizations = $organizations->whereHas('patient', function ($query) {
                    $query->where('disease_id', request('disease_id'));
                });
            }

            if (request('status') == "renewed") {
                $year = Carbon::parse(ad_to_bs(today()->format('Y-m-d')))->format('Y');
                $month = Carbon::parse(ad_to_bs(today()->format('Y-m-d')))->format('m');
                $today = Carbon::parse($year . '-' . $month . '-2');
                $organizations = $organizations->whereHas('patient', function ($query) use ($today) {
                    $query->whereHas('renews', function ($query1) use ($today) {
                        $query1->orderBy('id')->take(1)
                            ->whereDate('next_renew_date', '>=', $today);
                    });
                });
            }

            if (request('status') == "not_renewed") {
                $year = Carbon::parse(ad_to_bs(today()->format('Y-m-d')))->format('Y');
                $month = Carbon::parse(ad_to_bs(today()->format('Y-m-d')))->format('m');
                $today = Carbon::parse($year . '-' . $month . '-2');
                $organizations = $organizations->whereHas('patient', function ($query) use ($today) {
                    $query->whereHas('renews', function ($query1) use ($today) {
                        $query1->orderBy('id')->take(1)
                            ->whereDate('next_renew_date', '<=', $today);
                    });
                });
            }
            // dd($dateTo);
            $organizations = $organizations->whereHas('patient', function ($query2) use ($municipality_id) {
                $query2->where('address_id', $municipality_id);
            });
            // $organizations = $organizations->latest()->paginate(15);
            $organizations = $organizations->latest()->get();
            $filteredOrganizations = $organizations->filter(function ($organization) use ($currentQuarter) {
                return $organization->current_renew_quarter === $currentQuarter;
            });

            // dd($filteredOrganizations);
            $this->organizations = $filteredOrganizations;
        }
    }

    public function filter()
    {

        if (request('diseaseType') != 1) {
            $this->organizations = Renew::with('patient')->whereHas('patient', function ($query) {
                $query->where('registered_date', '<', $this->dateFrom[0]);
            })->latest()->paginate(15);
        }
        // $organizations = Organization::latest();
        // switch ($this->status) {
        //     case 'registered':
        //         $organizations = $organizations->registered(true)->whereBetween('registered_date', [$this->dateFrom, $this->dateTo]);
        //         break;
        //     case 'closed':
        //         $organizations = $organizations->closed(true)->whereBetween('closed_date', [$this->dateFrom, $this->dateTo]);
        //         break;
        //     case 'renewed':
        //         $organizations = $organizations->renewed(true)->whereBetween('renewed_date', [$this->dateFrom, $this->dateTo]);
        //         break;
        //     case 'not_renewed':
        //         $organizations = $organizations->renewed(false)->whereNotBetween('renewed_date', [$this->dateFrom, $this->dateTo]);
        //         break;
        //     default:
        //         break;
        // };
        // $this->organizations = $organizations->paginate(15);
    }



    public function render()
    {
        return view('livewire.organization-report')->with([
            'organizations' => $this->organizations,
            'applicationTypeCounts' => $this->applicationTypeCounts,

            // 'period' => timePeriod(explode('/', ad_to_bs(today()->format('Y-m-d')))[1])['period']
        ]);
    }
}
