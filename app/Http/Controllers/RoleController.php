<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $role = new Role();
        $roles = Role::latest()->get();
        return view('user.role.index', compact('roles', 'role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required',
        ]);

        Role::firstOrCreate(['name' => $request->role]);

        return redirect()->back()->with('success', 'नयाँ प्रयोगकर्ता भूमिका सफलतापुर्वक थपियो');
    }

    public function edit($id)
    {
        $role = Role::find($id);
        $roles = Role::latest()->get();
        return view('user.role.index', compact('roles', 'role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'role' => 'required'
        ]);
        Role::find($id)->update([
            'name' => $request->role,
        ]);

        return redirect()->route('role.index')->with('success', 'प्रयोगकर्ता भूमिका सफलतापुर्वक परिवर्तन भयो');
    }

    public function delete($id)
    {
        $role = Role::find($id);

        $role->delete();

        return redirect()->route('role.index')->with('success', "प्रयोगकर्ता भूमिका सफलतापुर्वक हटाइयो");
    }

    public function permission($id)
    {
        $role = ROle::find($id);

        return view('user.role.permission', compact('role'));
    }
    public function permissionSync(Request $request, $id)
    {
        $role = Role::find($id);
        $role->syncPermissions([]);
        if ($request->permissions) {

            foreach ($request->permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }
        return redirect()->back()->with('success', 'प्रयोगकर्ता अनुमति सफलतापुर्वक परिवर्तन भयो');
    }
}
