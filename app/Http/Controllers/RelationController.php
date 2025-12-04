<?php

namespace App\Http\Controllers;

use App\Relation;
use Illuminate\Http\Request;

class RelationController extends Controller
{
    public function index()
    {
        $relation = new Relation();
        $relations = Relation::latest()->paginate(20);
        return view('settings.relation', compact('relations', 'relation'));
    }

    public function store(Request $request)
    {
        Relation::create($request->validate([
            'name' => 'required|unique:relations,name'
        ]));

        return redirect()->back()->with('success', "नयाँ नाता सफलता पुर्वक थपियो");
    }

    public function edit(Relation $relation)
    {
        $relations = Relation::latest()->paginate(20);
        return view('settings.relation', compact('relations', 'relation'));
    }

    public function update(Request $request, Relation $relation)
    {
        $relation->update($request->validate([
            'name' => 'required|unique:relations,name,' . $relation->id
        ]));

        return redirect()->route('relation.index')->with('success', 'बिरामीसंगको नाता सफलता पुर्वक परिवर्तन भयो');
    }

    public function delete(Relation $relation)
    {

        $relation->delete();
        return redirect()->route('relation.index')->with('success', "बिरामीसंगको नाता सफलतापुर्वक हटाइयो");
    }
}
