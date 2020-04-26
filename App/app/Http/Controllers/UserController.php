<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    //
    public function add(Request $request){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'email' => 'required|unique:users',
        ]);
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        if ($file = $request->file('avatar')) {
            $request->validate(['avatar' => 'image|mimes:jpeg,png,jpg,gif,svg']);
            $extension = $file->getClientOriginalExtension();
            $relativeDestination = "uploads/users";
            $destinationPath = public_path($relativeDestination);
            $safeName = str_replace(' ', '_', $request->email) . time() . '.' . $extension;
            $file->move($destinationPath, $safeName);
            $data['avatar'] = url("$relativeDestination/$safeName");
        }
        $user = User::create($data);
        return response()->json($user);
    }

    public function update(Request $request, $id){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
        ]);
        $data = $request->all();
        $user = User::find($id);
        if($user == null) {
            abort(404, "No user found with id $id");
        }

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        if ($file = $request->file('avatar')) {
            $this->validate($request->all(), ['avatar' => 'image|mimes:jpeg,png,jpg,gif,svg']);
            $extension = $file->getClientOriginalExtension();
            $relativeDestination = "uploads/users";
            $destinationPath = public_path($relativeDestination);
            $safeName = str_replace(' ', '_', $user->name) . time() . '.' . $extension;
            $file->move($destinationPath, $safeName);
            $data['avatar'] = url("$relativeDestination/$safeName");
            //Delete old user image if exxists
            if ($user->avatar) {
                $oldImagePath = str_replace(url('/'), public_path(), $user->avatar);
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
        }
        $user->update($data);
        return response()->json($data);
    }

    public function find($id){
        $user = User::find($id);
        if($user == null) {
            abort(404, "No user found with id $id");
        }
        return response()->json($user);
    }

    public function get(){
        $users = User::get();
        return response()->json($users);
    }

    public function delete($id){
        $user = User::find($id);
        if($user == null) {
            abort(404, "No user found with id $id");
        }
        $user->delete($user);
        return response()->json($user);
    }
}
