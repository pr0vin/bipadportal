<?php

namespace App\Http\Controllers;

use App\User;
use App\Ward;
use App\Address;
use App\Municipality;
use App\Organization;
use Illuminate\Http\Request;
use App\Services\UserService;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    private $userService;
    public function __construct(UserService $userService)
    {
        // $this->middleware(['permission:user.*']);
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if(Session::get('municipality_id')==null){
        //     return redirect()->back();
        // }
        if (Gate::any(['user.store', 'user.edit', 'user.delete', 'user.password'])) {
            // The user is authorized to perform at least one of these actions
        } else {
            abort(403); // Unauthorized
        }
        $title = 'प्रयोगकर्ताहरू';
        if (Auth::user()->roles[0]->name == 'super-admin') {
            $users = User::where('municipality_id', municipalityId())->orWhereNull('municipality_id')->latest();
        } else {
            $users = User::where('municipality_id', municipalityId())->latest();
        }
        if ($request->name) {
            $users = $users->where('name', 'like', '%' . $request->name . '%');
        }
        if ($request->username) {
            $users = $users->where('username', 'like', '%' . $request->username . '%');
        }
        if ($request->email) {
            $users = $users->where('email', 'like', '%' . $request->email . '%');
        }
        // if ($request->role) {
        //     $roleName=$request->role;
        //     $users = $users->whereHas('roles',function($query) use($roleName){
        //         $query->where('name','dsd');
        //     });
        // }
        $users = $users->paginate(20);
        $roles = Role::latest()->get();
        return view('user.index', compact('users', 'title', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('user.store');
        $title = 'नयाँ प्रयोगकर्ता दर्ता';
        $user = new User();
        $roles = Role::latest()->get();
        $municipalities = Organization::all();
        $wards = Ward::all();
        return view('user.form', compact('user', 'roles', 'municipalities', 'wards', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $is_allowed_to_register    = Organization::where('address_id', $request->municipality_id)->first()->is_allowed_to_register;
        $userRole = $request->roles[0];
        Gate::authorize('user.store');
        $user = $this->userService->create($request);
        if ($user) {
            $user->syncRoles($request->roles);
        }

        if ($userRole == 'ward-secretary' && $is_allowed_to_register == '1') {
            $user->givePermissionTo(['dirgha.create', 'dirgha.application', 'dirgha.registered', 'dirgha.show', 'dirgha.edit', 'dirgha.delete', 'dirgha.register', 'dirgha.tokenletter', 'dirgha.renew', 'dirgha.close']);
        }
        return redirect()->route('user.index')->with('success', 'नयाँ प्रयोगकर्ता सफलतापुर्वक थपियो');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Gate::authorize('user.edit');
        $title = 'प्रयोगकर्ता';
        $user = $this->userService->find($id);
        // $user->load(['municipality', 'ward']);
        // return $user->getRoleNames();
        $roles = Role::latest()->get();
        $municipalities = Organization::all();
        $wards = Ward::all();

        return view('user.form', compact('user', 'roles', 'municipalities', 'wards'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        Gate::authorize('user.edit');

        if ($this->userService->update($user, $request)) {
            $user->syncRoles($request->roles);
        }

        return redirect()->route('user.index')->with('success', 'प्रयोगकर्ता विवरण सफलतापुर्वक परिवर्तन भयो');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Gate::authorize('user.delete');
        $user->delete();
        return redirect()->route('user.index')->with('success', 'प्रयोगकर्ता विवरण सफलतापुर्वक हटाइयो');
    }

    public function userRole(){
        // $user=User::find(1);
        // $user->update([
        //     'municipality_id'=>null
        // ]);

        // $user->assignRole("super-admin");

        // return redirect()->back();
    }
}
