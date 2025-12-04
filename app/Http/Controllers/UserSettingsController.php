<?php

namespace App\Http\Controllers;

use App\District;
use App\FiscalYear;
use App\LetterPad;
use App\Municipality;
use App\Province;
use App\UserSettings;
use App\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $municipalityId=municipalityId();
        if($municipalityId!=null){
           $letterPad=LetterPad::where('municipality_id',$municipalityId)->first();
        //    $letterPad->address_line_one;
           return view('letterPad.index',compact('letterPad'));
        }
        return redirect()->back()->with('error','please select a municipality');
    }


    /**
     * sync
     *
     * @param  mixed $request
     * @return void
     */
    public function sync(Request $request)
    {
        $user = Auth::user();

        if ($user->settings()->exists()) {
            $user->settings->update($request->all());
        } else {
            $user->settings()->save(new UserSettings($request->all()));
        }

        return redirect()->back()->with('success', 'Settings Updated');
    }

    public function getDistrict($id){
        $districts=District::where('province_id',$id)->latest()->get();

        return response()->json($districts);
    }

    public function getMunicipality($id){
        $municipalities=Municipality::where('district_id',$id)->latest()->get();

        return response()->json($municipalities);
    }

    public function setOrganization(Request $request){
        Session::put('municipality_id', $request->address_id);

        return redirect()->back();
    }

    public function setFiscalYear(Request $request){
        // Session::put('fiscal_year_id', $request->fiscal_year_id);
        $fiscalYear=FiscalYear::find($request->fiscal_year_id);
        if($fiscalYear){
            FiscalYear::query()->update(['is_running' => false]);
            $fiscalYear->update([
                'is_running'=>true
            ]);
        }
        return redirect()->back();
    }
}
