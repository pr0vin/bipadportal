<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OldOrganizationController extends Controller
{
    public function create()
    {
        $title = 'पुरानो डाटा इन्ट्री';
        return view('old-organization.create', compact('title'));
    }
}
