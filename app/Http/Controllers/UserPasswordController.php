<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UserPasswordController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->userService = $userService;
    }

    public function form(User $user)
    {
        Gate::authorize('user.password');
        if (!Auth::user()->hasRole(['super-admin', 'admin'])) {
            if (Auth::user()->id != $user->id) {
                abort(403, 'Access Denied');
            }
        }

        return view('user.password', compact('user'));
    }

    public function change(Request $request, User $user)
    {
        Gate::authorize('user.password');
        $request->validate([
            'new_password' => 'required|confirmed'
        ]);
        if (!Auth::user()->hasRole(['super-admin', 'admin'])) {
            $request->validate([
                'password' => 'required'
            ]);
            if (Auth::user()->id != $user->id) {
                return redirect()->back()->with('error', 'Access Denied');
            }
            if (!$this->userService->validateUserPassword($request->password)) {
                return redirect()->back()->with('error', 'Invalid Password');
            }
        }

        $this->userService->changePassword($user, $request);

        return redirect()->back()->with('success', 'Password has been changed successfully');
    }
}
