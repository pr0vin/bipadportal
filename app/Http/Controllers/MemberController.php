<?php

namespace App\Http\Controllers;

use App\Member;
use App\Position;
use App\Committee;
use App\CommitteePosition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MemberController extends Controller
{
    public function index(Request $request){
        if (Gate::any(['member.store','member.edit','member.delete'])) {
            // The user is authorized to perform at least one of these actions
        } else {
            abort(403); // Unauthorized
        }
        $member=new Member();
        $committies=Committee::latest()->get();
        $members=Member::where('committee_id',request('committee_id'))->where('address_id',municipalityId())->with('committee','position','committeePosition');
        if($request->name){
            $members=$members->where('name','like','%'.$request->name.'%');
        }
        if($request->position_id){
            $members=$members->where('position_id',$request->position_id);
        }
        if($request->committee_position_id){
            $members=$members->where('committee_position_id',$request->committee_position_id);
        }
        $members=$members->orderBy('order','asc')->paginate($request->per_page??10);
        $positions=Position::latest()->get();
        $committeePositions=CommitteePosition::latest()->get();
        return view('member.index',compact('member','committies','members','positions','committeePositions'));
    }

    public function store (Request $request){
        // return $request;
        Gate::authorize('member.store');
        $data=$request->validate([
            'committee_id'=>'required',
            'name'=>'required',
            'position_id'=>'required',
            'committee_position_id'=>'required',
        ]);
        $data['address_id']=municipalityId();
        $memberOrder=Member::orderBy('order','desc')->first();
        if($memberOrder){
            $data['order']=$memberOrder->order+1;
        }else{
            $data['order']=1;
        }
        Member::create($data);

        return redirect()->back()->with('success','नयाँ सदस्य विवरण सफलतापुर्वक थपियो');
    }

    public function edit (Member $member, Request $request){
        Gate::authorize('member.edit');
        $committies=Committee::latest()->get();
       $members=Member::where('committee_id',request('committee_id'))->where('address_id',municipalityId())->with('committee','position','committeePosition')->orderBy('order','asc')->paginate($request->per_page??10);
        $positions=Position::latest()->get();
        $committeePositions=CommitteePosition::latest()->get();
        return view('member.index',compact('member','committies','members','positions','committeePositions'));
    }

    public function update(Request $request, Member $member){
        Gate::authorize('member.edit');
        $data=$request->validate([
            'committee_id'=>'required',
            'name'=>'required',
            'position_id'=>'required',
            'committee_position_id'=>'required',
        ]);
        $member->update($data);
        return redirect()->route('member.index', ['committee_id' => $request->committee_id])
        ->with('success', "सदस्य विवरण सफलतापुर्वक परिवर्तन भयो");
        }

    public function delete(Member $member){
        $committee_id=$member->committee_id;
        Gate::authorize('member.delete');
        $member->delete();

        return redirect()->route('member.index',['committee_id'=>$committee_id])->with('success',"सदस्य विवरण सफलतापुर्वक हटाइयो");
    }

    public function order(Request $request){
        $order = $request->input('order');
        foreach ($order as $item) {
            Member::where('id', $item['id'])->update(['order' => $item['position']]);
        }
    }
}
