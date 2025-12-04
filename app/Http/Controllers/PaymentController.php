<?php

namespace App\Http\Controllers;

use App\ApplicationType;
use App\Renew;
use Illuminate\Http\Request;
use App\Exports\PaymentExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PaymentController extends Controller
{

    public function index()
    {
        $municipality_id = municipalityId();
        if (!$municipality_id) {
            return redirect()->back()->with('error', "कृपया पालिका छान्नुहोस्");
        }

        $currentQuarter = request('quarter') ? (int)request('quarter') : currentquarter();

        $renews = Renew::with('patient.address')
            ->where('fiscal_year_id', currentFiscalYear()->id)
            ->whereHas('patient', function ($query) use ($municipality_id) {
                $query->where('address_id', $municipality_id);
            })
            ->latest()
            ->get()
            ->filter(function ($renew) use ($currentQuarter) {
                return $renew->current_renew_quarter === $currentQuarter;
            });

        // Initialize counters
        $total = $renews->count();
        $totalPrice = 0;
        $male = $female = $other = 0;

        foreach ($renews as $renew) {
            $gender = strtolower($renew->patient->gender ?? '');
            $totalPrice += $renew->month * $renew->price_rate;

            if ($gender === 'male') {
                $male++;
            } elseif ($gender === 'female') {
                $female++;
            } elseif ($gender === 'other') {
                $other++;
            }
        }

        $totalRenewInfo = $renews;
        $rate = ApplicationType::where('id', 1)->first();
        if ($rate) {
            $rate = $rate->amount;
        } else {
            $rate = 5000;
        }

        return view('payment.index', compact('total', 'male', 'female', 'other', 'totalPrice', 'totalRenewInfo', 'rate'));
    }

    // public function index()
    // {
    //     $municipality_id = municipalityId();
    //     if (!$municipality_id) {
    //         return redirect()->back()->with('error', "कृपया पालिका छान्नुहोस्");
    //     }
    //     $currentQuarter = null;
    //     if (request('quarter')) {
    //         $currentQuarter = (int)request('quarter');
    //     } else {
    //         $currentQuarter = currentquarter();
    //     }
    //     // ==========
    //     $total = Renew::with('patient')->where('fiscal_year_id', currentFiscalYear()->id)->whereHas('patient', function ($query2) use ($municipality_id) {
    //         $query2->where('address_id', $municipality_id);
    //     })->latest()->get();
    //     $totalRenew = $total->filter(function ($organization) use ($currentQuarter) {
    //         return $organization->current_renew_quarter === $currentQuarter;
    //     });
    //     // ===========
    //     $male = Renew::with('patient')
    //         ->where('fiscal_year_id', currentFiscalYear()->id)
    //         ->whereHas('patient', function ($query2) use ($municipality_id) {
    //             $query2->where('address_id', $municipality_id)
    //                 ->where(DB::raw('LOWER(gender)'), 'male');
    //         })
    //         ->latest()
    //         ->get();
    //     $maleRenew = $male->filter(function ($organization) use ($currentQuarter) {
    //         return $organization->current_renew_quarter === $currentQuarter;
    //     });
    //     // ============
    //     $female = Renew::with('patient')
    //         ->where('fiscal_year_id', currentFiscalYear()->id)
    //         ->whereHas('patient', function ($query2) use ($municipality_id) {
    //             $query2->where('address_id', $municipality_id)
    //                 ->where(DB::raw('LOWER(gender)'), 'female');
    //         })
    //         ->latest()
    //         ->get();

    //     $femaleRenew = $female->filter(function ($organization) use ($currentQuarter) {
    //         return $organization->current_renew_quarter === $currentQuarter;
    //     });
    //     // =============
    //     $other = Renew::with('patient')
    //         ->where('fiscal_year_id', currentFiscalYear()->id)
    //         ->whereHas('patient', function ($query2) use ($municipality_id) {
    //             $query2->where('address_id', $municipality_id)
    //                 ->where(DB::raw('LOWER(gender)'), 'other');
    //         })
    //         ->latest()
    //         ->get();
    //     $otherRenew = $other->filter(function ($organization) use ($currentQuarter) {
    //         return $organization->current_renew_quarter == $currentQuarter;
    //     });
    //     $total = $totalRenew->count();

    //     $male = $maleRenew->count();
    //     $female = $femaleRenew->count();
    //     $other = $otherRenew->count();
    //     $totalPrice = 0;

    //     foreach ($totalRenew as $renew) {
    //         $totalPrice = $totalPrice + ($renew->month * $renew->price_rate);
    //     }

    //     $totalRenew = Renew::with('patient.address')->where('fiscal_year_id', currentFiscalYear()->id)->whereHas('patient', function ($query2) use ($municipality_id) {
    //         $query2->where('address_id', $municipality_id);
    //     })->latest()->get();
    //     $totalRenewInfo = $totalRenew->filter(function ($organization) use ($currentQuarter) {
    //         return $organization->current_renew_quarter === $currentQuarter;
    //     });


    //     return view('payment.index', compact('total', 'male', 'female', 'other', 'totalPrice', 'totalRenewInfo'));
    // }

    public function patientList()
    {
        $municipality_id = municipalityId();
        if (!$municipality_id) {
            return redirect()->back()->with('error', "कृपया पालिका छान्नुहोस्");
        }
        $currentQuarter = null;
        if (request('quarter')) {
            $currentQuarter = (int)request('quarter');
        } else {
            $currentQuarter = currentquarter();
        }
        $total = Renew::with('patient.address')->where('fiscal_year_id', currentFiscalYear()->id)->whereHas('patient', function ($query2) use ($municipality_id) {
            $query2->where('address_id', $municipality_id);
        })->latest()->get();
        $totalRenew = $total->filter(function ($organization) use ($currentQuarter) {
            return $organization->current_renew_quarter === $currentQuarter;
        });
        return view('payment.patientList', compact('totalRenew'));
    }

    public function pay()
    {
        $municipality_id = municipalityId();
        if (!$municipality_id) {
            return redirect()->back()->with('error', "कृपया पालिका छान्नुहोस्");
        }
        $currentQuarter = null;
        if (request('quarter')) {
            $currentQuarter = (int)request('quarter');
        } else {
            $currentQuarter = currentquarter();
        }
        $total = Renew::with('patient.address')->where('fiscal_year_id', currentFiscalYear()->id)->whereHas('patient', function ($query2) use ($municipality_id) {
            $query2->where('address_id', $municipality_id);
        })->latest()->get();
        $totalRenew = $total->filter(function ($organization) use ($currentQuarter) {
            return $organization->current_renew_quarter === $currentQuarter;
        });

        foreach ($totalRenew as $renew) {
            $renew->update([
                'isPaid' => true,
            ]);
        }
        // return $totalRenew;
        $message = "मृर्गौला प्रत्यारोपण गरेका, डायलासिस गराई रहेका, क्यान्सर रोगी र मेरुदण्ड पक्षघातका बिरामीहरुलाई औषधि उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम मासिक रु. ५ हजारका दरले रकम भुक्तानी दिएको बिबरण(आ. व." . currentFiscalYear()->name . ") ";
        Excel::download(new PaymentExport($totalRenew, $message), 'भुक्तानी सिफारिस.xlsx');
        return  redirect()->back()->with('success', 'भुक्तानी सफलतापूर्वक गरिएको छ');
    }

    public function export()
    {
        $municipality_id = municipalityId();
        if (!$municipality_id) {
            return redirect()->back()->with('error', "कृपया पालिका छान्नुहोस्");
        }
        $currentQuarter = null;
        if (request('quarter')) {
            $currentQuarter = (int)request('quarter');
        } else {
            $currentQuarter = currentquarter();
        }
        $total = Renew::with('patient.address')->where('fiscal_year_id', currentFiscalYear()->id)->whereHas('patient', function ($query2) use ($municipality_id) {
            $query2->where('address_id', $municipality_id);
        })->latest()->get();
        $totalRenew = $total->filter(function ($organization) use ($currentQuarter) {
            return $organization->current_renew_quarter === $currentQuarter;
        });
        $message = "मृर्गौला प्रत्यारोपण गरेका, डायलासिस गराई रहेका, क्यान्सर रोगी र मेरुदण्ड पक्षघातका बिरामीहरुलाई औषधि उपचार बापत खर्च उपलब्ध गराउने सम्बन्धि कार्यविधि २०७८ बमोजिम मासिक रु. ५ हजारका दरले रकम भुक्तानी दिएको बिबरण(आ. व." . currentFiscalYear()->name . ") ";

        return Excel::download(new PaymentExport($totalRenew, $message), 'भुक्तानी सिफारिस.xlsx');
    }
}
