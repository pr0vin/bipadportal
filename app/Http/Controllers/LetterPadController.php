<?php

namespace App\Http\Controllers;

use App\LetterPad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LetterPadController extends Controller
{
    public function store(Request $request){
        $municipality=municipalityId();
        if($municipality==null){
            return redirect()->back();
        }
        $data=$request->validate([
            'municipality_name'=>'required',
            'tag_line'=>'required',
            'address_line_one'=>'required',
            'address_line_two'=>'required',
            'phone'=>'nullable',
            'email'=>'nullable',
            'website'=>'nullable'
        ]);
        $data['municipality_id']=$municipality;
        LetterPad::create($data);

        return redirect()->back()->with('success',"Letterpad saved");
    }

    public function update(Request $request,$id){
        $letterpad=LetterPad::find($id);
        $data=$request->validate([
            'municipality_name'=>'required',
            'tag_line'=>'required',
            'address_line_one'=>'required',
            'address_line_two'=>'required',
            'phone'=>'nullable',
            'email'=>'nullable',
            'website'=>'nullable'
        ]);

        $letterpad->update($data);
        return redirect()->route('user.settings.index')->with('success',"Letterpad saved");

    }
}
