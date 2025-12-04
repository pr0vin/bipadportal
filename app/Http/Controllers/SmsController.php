<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function index(){
        return view('settings.sms');
    }

    public function sync(Request $request){
        $request->validate([
            'sms_api_end_point'=>'required',
            'sma_api_key'=>'required',
            'sms_sender_id'=>'required',
            'sms_router_id'=>'required',
        ]);
        settings()->set([
            'sms_api_end_point' => $request->sms_api_end_point,
            'sma_api_key' => $request->sma_api_key,
            'sms_sender_id' => $request->sms_sender_id,
            'sms_router_id' => $request->sms_router_id,
         ]);

         return redirect()->back()->with('success','SMS setting sync successfully');
    }
}
