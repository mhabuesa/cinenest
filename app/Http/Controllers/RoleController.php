<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function role(){
        $permissions = Permission::all();
        return view('backend.role.role', compact('permissions'));
    }
    function permission_store(Request $request){
        Permission::create(['name' => $request->permission_name]);
        return redirect()->back()->with('success', 'Permission created successfully');
    }
    function role_store(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);
        return redirect()->back()->with('success', 'Role created successfully');
    }
}
