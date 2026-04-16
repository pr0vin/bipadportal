<?php

namespace App\Http\Controllers;

use App\FiscalYear;
use App\Services\FiscalYearService;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\FiscalYearRequest;

class FiscalYearController extends Controller
{
    protected $fiscalYearService;

    public function __construct(FiscalYearService $fiscalYearService)
    {
        $this->fiscalYearService = $fiscalYearService;
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($fiscalYear = null)
    {
        if (Gate::any(['fiscalYear.store', 'fiscalYear.edit', 'fiscalYear.delete'])) {
            // The user is authorized to perform at least one of these actions
        } else {
            abort(403); // Unauthorized
        }
        $fiscalYear = $fiscalYear
            ? FiscalYear::findOrFail($fiscalYear)
            : new FiscalYear();

        $fiscalYears = FiscalYear::latest()->get();

        return view('fiscal_year.index', compact('fiscalYears', 'fiscalYear'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FiscalYearRequest $request)
    {
        // AD dates are saved using observer\
        Gate::authorize('fiscalYear.store');
        $start = is_array($request->start) ? reset($request->start) : $request->start;
        $end = is_array($request->end) ? reset($request->end) : $request->end;

        FiscalYear::create([
            'name'=>$request->name,
            'start'=>$start,
            'end'=>$end,
            'is_running'=>$request->is_running,
        ]);
        $this->fiscalYearService->flushCache();

        return redirect()->route('fiscal-year.index')->with('success', 'नयाँ आर्थिक वर्ष सफलता पुर्वक थपियो');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FiscalYear  $fiscalYear
     * @return \Illuminate\Http\Response
     */
    public function update(FiscalYearRequest $request, FiscalYear $fiscalYear)
    {
        Gate::authorize('fiscalYear.edit');
        $start = is_array($request->start) ? reset($request->start) : $request->start;
        $end = is_array($request->end) ? reset($request->end) : $request->end;

        $fiscalYear->update([
            'name'=>$request->name,
            'start'=>$start,
            'end'=>$end,
            'is_running'=>$request->is_running,
        ]);
        $this->fiscalYearService->flushCache();

        return redirect()->route('fiscal-year.index')->with('success', 'आर्थिक वर्ष विवरण सफलतापुर्वक परिवर्तन भयो');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FiscalYear  $fiscalYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(FiscalYear $fiscalYear)
    {
        Gate::authorize('fiscalYear.delete');
        if ($fiscalYear->is_running) {
            return redirect()->route('fiscal-year.index')->with('error', 'हाल चलिरहेको आर्थिक वर्ष मेटाउन सकिँदैन');
        }

        $fiscalYear->delete();
        $this->fiscalYearService->flushCache();

        return redirect()->route('fiscal-year.index')->with('success', 'आर्थिक वर्ष विवरण सफलतापुर्वक हटाइयो');
    }
}
