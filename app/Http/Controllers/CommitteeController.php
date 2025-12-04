<?php

namespace App\Http\Controllers;

use App\Committee;
use App\ApplicationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CommitteeController extends Controller
{
    public function index()
    {
        if (Gate::any(['committee.store', 'committee.edit', 'committee.delete','member.store','member.edit','member.delete'])) {
            // The user is authorized to perform at least one of these actions
        } else {
            abort(403); // Unauthorized
        }
        $committeeTypes = ApplicationType::latest()->get();
        $committee = new Committee();
        $committies = Committee::with('type')->where('address_id',municipalityId())->latest()->get();
        return view('committee.index', ['committeeTypes' => $committeeTypes, 'committies' => $committies, 'committee' => $committee]);
    }

    public function store(Request $request)
    {
        Gate::authorize('committee.store');
        $data=$request->validate([
            'name' => 'required',
            'order_position' => 'nullable',
            'application_type_id' => 'required',
        ]);
        $data['address_id']=municipalityId();
        Committee::create($data);

        return redirect()->back()->with('success', 'नयाँ समिति सफलतापुर्वक थपियो');
    }

    public function edit(Committee $committee)
    {
        Gate::authorize('committee.edit');
        $committeeTypes = ApplicationType::latest()->get();
        $committies = Committee::with('type')->where('address_id',municipalityId())->latest()->get();
        return view('committee.index', ['committeeTypes' => $committeeTypes, 'committies' => $committies, 'committee' => $committee]);
    }

    public function update(Request $request, Committee $committee)
    {
        Gate::authorize('committee.edit');
        $committee->update($request->validate([
            'name' => 'required',
            'order_position' => 'nullable',
            'application_type_id' => 'required',
        ]));

        return redirect()->route('committee.index')->with('success', 'समिति सफलतापुर्वक परिवर्तन भयो');
    }

    public function delete(Committee $committee)
    {
        Gate::authorize('committee.delete');
        $committee->delete();

        return redirect()->route('committee.index')->with('success', 'समिति सफलतापुर्वक हटाइयो');
    }
}
