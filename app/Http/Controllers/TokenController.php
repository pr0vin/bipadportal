<?php

namespace App\Http\Controllers;

use App\OnlineApplication;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function index(Request $request, $tokenNumber)
    {
        if (!$request->hasValidSignature()) {
            abort(419, 'This page has already expired');
        }
        $onlineApplication = OnlineApplication::with('patient.disease.application_types')->where('token_number', $tokenNumber)->firstOrFail();

        // return $onlineApplication;
        $contentEditable = 'false';
        return view('token', compact('onlineApplication', 'contentEditable'));
    }

    public function search()
    {
        return view('frontend.token-search');
    }
}
