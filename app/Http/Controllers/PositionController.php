<?php

namespace App\Http\Controllers;

use App\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    public function store(Request $request){
        Position::create($request->validate([
            'name'=>'required|unique:positions,name'
        ]));

        return redirect()->back()->with('success','New position saved');
    }

    public function edit (Position $position){
        return view('settings.position',compact('position'));
    }

    public function update (Request $request, Position $position){
        $position->update($request->validate([
             'name'=>'required|unique:positions,name,'.$position->id
        ]));

        return redirect()->route('settings.position')->with('success','Selected position updated');
    }

    public function delete(Position $position){
        $position->delete();

        return redirect()->route('settings.position')->with('success','Selected position removed');
    }
}
