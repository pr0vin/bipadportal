<?php

namespace App\Http\Controllers;

use App\DoctorProfile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorProfileController extends Controller
{
    public function index(){
        $user= User::with('profile')->find(Auth::id());
        return view('profile.index',compact('user'));
    }

    public function update(Request $request){
       $user=User::find(Auth::id());
        $request->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$user->id,
            'post'=>'required',
            'nmc_no'=>'required|unique:doctor_profiles,nmc_no,'.$user->profile->id
        ]);

        $user->update( [
            'name'=>$request->name,
            'email'=>$request->email,
        ]);
        $profile= $user->profile;
        if($profile){
            $profile->update([
                'post'=>$request->post,
                'nmc_no'=>$request->nmc_no,
            ]);
        }else{
            DoctorProfile::create([
                'user_id'=>$user->id,
                'post'=>$request->post,
                'nmc_no'=>$request->nmc_no,
            ]);
        }
        return redirect()->back()->with('success','प्रोफाइल परिवर्तन भयो');
    }

    public function getDoctor ($id){
        $doctor=DoctorProfile::with('user')->where('nmc_no',$id)->first();
        if($doctor){
            $data=[
                'status'=>true,
                'data'=>$doctor
            ];
            return response()->json($data);
        }else{
            $data=[
                'status'=>false,
            ];
            return response()->json($data);
        }
    }
}
