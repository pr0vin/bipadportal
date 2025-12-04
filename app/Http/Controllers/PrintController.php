<?php

namespace App\Http\Controllers;

use App\OnlineApplication;
use App\Organization;

class PrintController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('token');
        $this->middleware('role:super-admin|ward-secretary')->only(['personalSifaris', 'wardSifaris']);
        $this->middleware('role:super-admin|admin')->except([
            'token',
            'personalSifaris',
            'wardSifaris'
        ]);
    }

    public function token($tokenNumber)
    {
        $onlineApplication = OnlineApplication::where('token_number', $tokenNumber)->firstOrFail();
        $patient = $onlineApplication->patient;
        $contentEditable = "false";
        return view('print.token', compact(['onlineApplication', 'patient', 'contentEditable']));
    }

    public function personalSifaris(Organization $organization)
    {
        return view('print.personal-sifaris', compact('organization'));
    }

    public function wardSifaris(Organization $organization)
    {
        return view('print.ward-sifaris', compact('organization'));
    }

    public function pramanpatraFront(Organization $organization)
    {
        return view('print.pramanpatra-front', compact('organization'));
    }

    public function pramanpatraBack(Organization $organization)
    {
        return view('print.pramanpatra-back', compact('organization'));
    }

    public function ghareluSifaris(Organization $organization)
    {
        return view('print.gharelu-sifaris', compact('organization'));
    }

    public function kardataSifaris(Organization $organization)
    {
        return view('print.kardata-sifaris', compact('organization'));
    }

    public function banijyaSifaris(Organization $organization)
    {
        return view('print.banijya-sifaris', compact('organization'));
    }

    public function karobarParibartan(Organization $organization)
    {
        return view('print.karobar-paribartan', compact('organization'));
    }

    public function bandaSifarisGharelu(Organization $organization)
    {
        return view('print.banda-sifaris.gharelu', compact('organization'));
    }

    public function bandaSifarisKardata(Organization $organization)
    {
        return view('print.banda-sifaris.kardata', compact('organization'));
    }

    public function bandaSifarisBanijya(Organization $organization)
    {
        return view('print.banda-sifaris.banijya', compact('organization'));
    }
}
