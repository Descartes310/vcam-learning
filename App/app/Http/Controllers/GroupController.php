<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Group;
use App\User;
use App\UserGroup;

class GroupController extends Controller
{
    //

    public function add(Request $request){
        $request->validate([
            'name' => 'required|unique:groups',
            'creator_id' => 'required|exists:App\User,id',
        ]);
        $data = $request->all();
        $group = Group::create($data);
        return response()->json($group);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required',
            'creator_id' => 'required|exists:App\User,id',
        ]);
        $data = $request->all();
        $group = Group::find($id);
        if($group == null) {
            abort(404, "No group found with id $id");
        }
        $group->update($data);
        return response()->json($group);
    }

    public function find($id){
        $group = Group::find($id);
        if($group == null) {
            abort(404, "No group found with id $id");
        }
        return response()->json($group);
    }

    public function get(){
        $groups = Group::get();
        return response()->json($groups);
    }

    public function delete($id){
        $group = Group::find($id);
        if($group == null) {
            abort(404, "No group found with id $id");
        }
        $group->delete($group);
        return response()->json($group);
    }

    public function addUserGroup($id_group, $id_user){
        $user = User::find($id_user);
        $group = Group::find($id_group);
        if(!($user && $group)) {
            abort(404, "L'utilisateur ou le groupe son inexistant");
        }
        $user_group = UserGroup::create([
            'user_id' => $id_user,
            'group_id' => $id_group,
            'is_active' => true,
            'is_admin' => false
        ]);
        return response()->json($user_group);
    }

    public function deleteUserGroup($id_group, $id_user){
        $user = User::find($id_user);
        $group = Group::find($id_group);
        if(!($user && $group)) {
            abort(404, "L'utilisateur ou le groupe son inexistant");
        }
        $user_group = UserGroup::whereUserIdAndGroupId($id_user, $id_group)->first();
        $user_group->delete();
        return response()->json($user_group);
    }

    public function setAsAdmin($id_group, $id_user){
        $user = User::find($id_user);
        $group = Group::find($id_group);
        if(!($user && $group)) {
            abort(404, "L'utilisateur ou le groupe son inexistant");
        }
        $user_group = UserGroup::whereUserIdAndGroupId($id_user, $id_group)->first();
        $user_group->is_admin = true;
        $user_group->update($user_group);
        return response()->json($user_group);
    }

    public function removeAsAdmin($id_group, $id_user){
        $user = User::find($id_user);
        $group = Group::find($id_group);
        if(!($user && $group)) {
            abort(404, "L'utilisateur ou le groupe son inexistant");
        }
        $user_group = UserGroup::whereUserIdAndGroupId($id_user, $id_group)->first();
        $user_group->is_admin = false;
        $user_group->update($user_group);
        return response()->json($user_group);
    }
}
