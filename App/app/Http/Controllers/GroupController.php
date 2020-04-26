<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Group;

class GroupController extends Controller
{
    //

    public function add(Request $request){
        $request->validate([
            'name' => 'required|unique:groups',
            'creator_id' => 'required|exists:App\User,id',
            'deleted_by' => 'required|exists:App\User,id'
        ]);
        $data = $request->all();
        $group = Group::create($data);
        return response()->json($group);
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|unique:group',
            'creator_id' => 'required|exists:App\User,id',
            'deleted_by' => 'required|exists:App\User,id'
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
}
