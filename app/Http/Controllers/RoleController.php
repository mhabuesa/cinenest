<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    function role(){
        if(Auth::user()->role == 'admin'){
            $permissions = Permission::all();
            $roles = Role::all();
            $users = User::all();
            return view('backend.role.role', compact('permissions', 'roles', 'users'));
        }
        else{
            return redirect()->route('unauthorized');
        }
    }
    function permission_store(Request $request){
        $request->validate([
            'permission_name'=>'required|unique:permissions,name',
        ]);
        Permission::create(['name' => $request->permission_name]);
        return redirect()->back()->with('success', 'Permission created successfully');
    }
    function role_store(Request $request){
        $role = Role::create(['name' => $request->role_name]);
        $role->givePermissionTo($request->permission);
        return redirect()->back()->with('success', 'Role created successfully');
    }

    function role_delete($id){
        $role = Role::find($id);
        $role->revokePermissionTo($role->permissions);
        $role->delete();
        return redirect()->back()->with('success', 'Role deleted successfully');
    }

    function role_edit($id){
        $role = Role::find($id);
        $permissions = Permission::all();
        return view('backend.role.role_edit', compact('role', 'permissions'));

    }

    function permission_update(Request $request, $id){
        $role = Role::find($id);
        $role->syncPermissions($request->permission);
        return redirect()->back()->with('success', 'Permission updated successfully');
    }

    function role_assign(Request $request){
        $user = User::find($request->user_id);
        $user->assignRole($request->role);
        return redirect()->back()->with('success', 'Role assigned successfully');
    }

   function role_remove($id){
       DB::table('model_has_roles')->where('model_id', $id)->delete();
       return redirect()->back()->with('success', 'Role removed successfully');
   }
}
