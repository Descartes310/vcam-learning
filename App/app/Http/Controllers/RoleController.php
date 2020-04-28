<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\User;

class RoleController extends Controller
{
    //
    public function add(Request $request){
        $request->validate([
            'name' => 'required|unique:roles',
            'creator_id' => 'required'
        ]);

        if(User::find($request->creator_id) == null) {
            abort(404, "No user found with id $request->creator_id");
        }

        $data = $request->all();
        $role = Role::create($data);
        return response()->json($role);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|unique:roles',
            'creator_id' => 'required'
        ]);

        $data = $request->all();
        $role = Role::find($id);

        if($role == null) {
            abort(404, "No role found with id $id");
        }

        if(User::find($request->creator_id) == null) {
            abort(404, "No user found with id $request->creator_id");
        }
        
        $role->update($data);
        return response()->json($data);
    }

    public function find($id){
        $role = Role::find($id);
        if($role == null) {
            abort(404, "No role found with id $id");
        }
        return response()->json($role);
    }

    public function get(){
        $roles = Role::get();
        return response()->json($roles);
    }

    public function delete($id){
        $role = Role::find($id);
        if($role == null) {
            abort(404, "No role found with id $id");
        }
        $role->delete($role);
        return response()->json($role);
    }

    public function addUserRole($id_role, $id_user){
        $user = User::find($id_user);
        $role = Role::find($id_role);
        if(!($user && $role)) {
            abort(404, "L'utilisateur ou le rolee son inexistant");
        }
        $user_role = UserRole::create([
            'user_id' => $id_user,
            'role_id' => $id_role,
            'is_active' => true,
        ]);
        return response()->json($user_role);
    }

    public function deleteUserrole($id_role, $id_user){
        $user = User::find($id_user);
        $role = Role::find($id_role);
        if(!($user && $role)) {
            abort(404, "L'utilisateur ou le rolee son inexistant");
        }
        $user_role = UserRole::whereUserIdAndRoleId($id_user, $id_role)->first();
        $user_role->delete();
        return response()->json($user_role);
    }
}
