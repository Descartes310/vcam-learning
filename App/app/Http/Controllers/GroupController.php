<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Group;
use App\User;
use App\Mail\Invite;
use App\UserGroup;
use Illuminate\Support\Facades\Auth;
use App\Invitation;
use Illuminate\Support\Facades\Mail;

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

    public function addUserGroup($hash){
        $invitation = Invitation::whereHash($hash)->first();
        if($invitation==null) {
            abort(404, "L'invitation est inexistante");
        }
        $invitation->update([
            'status' => 'ACCEPTED'
        ]);

        $user_group = UserGroup::create([
            'user_id' => $invitation->receiver_id,
            'group_id' => $invitation->group_id,
            'is_active' => true,
            'is_admin' => false,
        ]);

        
    }

    public function inviteUser($id_group, $id_user, $id_admin) {

        $user = User::find($id_user);
        $admin = User::find($id_admin);
        $group = Group::find($id_group);
        if($user==null || $group==null) {
            abort(404, "L'utilisateur ou le groupe son inexistant");
        }
        $hash = $this->generateHash();
        $invitation = Invitation::create([
            'sender_id' => $id_admin,
            'receiver_id' => $id_user,
            'group_id' => $id_group,
            'is_active' => true,
            'hash' => $hash,
            'status' => 'WAITING'
        ]);
        
        $link = url("/")."/api/groups/invitation/$hash";
        $objDemo = new \stdClass();
        $objDemo->name = $user->first_name.' '.$user->last_name;
        $objDemo->subject = "Invitation au groupe $group->name par $admin->first_name $admin->last_name";
        $objDemo->message = "Vous êtes invité a joindre le groupe $group->name. \n Cliquez sur le lien pour accepter: $link";

        try 
        {
            Mail::to($user->email)->send(new Invite($objDemo));
        } 
        catch (Exception $e) {}

        return response()->json($invitation);

    }

    public function deleteUserGroup($id_group, $id_user){
        $user = User::find($id_user);
        $group = Group::find($id_group);
        if($user==null || $group==null) {
            abort(404, "L'utilisateur ou le groupe son inexistant");
        }
        $user_group = UserGroup::whereUserIdAndGroupId($id_user, $id_group)->first();
        $user_group->delete();
        return response()->json($user_group);
    }

    public function setAsAdmin($id_group, $id_user){
        $user = User::find($id_user);
        $group = Group::find($id_group);
        if($user==null || $group==null) {
            abort(404, "L'utilisateur ou le groupe son inexistant");
        }
        $user_group = UserGroup::whereUserIdAndGroupId($id_user, $id_group)->first();
        //$user_group->is_admin = true;
        $user_group->update([
            "is_admin" => true
        ]);
        return response()->json($user_group);
    }

    public function removeAsAdmin($id_group, $id_user){
        $user = User::find($id_user);
        $group = Group::find($id_group);
        if($user==null || $group==null) {
            abort(404, "L'utilisateur ou le groupe son inexistant");
        }
        $user_group = UserGroup::whereUserIdAndGroupId($id_user, $id_group)->first();
        //$user_group->is_admin = true;
        $user_group->update([
            "is_admin" => false
        ]);
        return response()->json($user_group);
    }

    public function generateHash() {
        $area = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567';
        $hash = array();
        for($i=0; $i < 256; $i++){
            $n = rand(0, strlen($area)-1);
            $hash[] = $area[$n];
        }
        return implode($hash);
    }
}
