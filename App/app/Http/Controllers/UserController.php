<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Mail\Contact;
use Illuminate\Support\Facades\Mail;

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

        //Encrypting user's password using bcrypt hash algorithm
        $pass = $this->password();
        $data['password'] = bcrypt($pass);

        //Storing user's avatar in filesystem
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

        $objDemo = new \stdClass();
        $objDemo->name = $request->first_name.' '.$request->last_name;
        $objDemo->email = $request->email;
        $objDemo->subject = "Creation du compte UserManager";
        $objDemo->message = "Les paramètres de votre compte sont $request->email et $pass";
        try {
            Mail::to($request->email)->send(new Contact($objDemo));
        } 
        catch (Exception $e) {
            return response()->json([
                'user' => $user,
                'message' => "Le mail n'a pas été envoyé"
            ]);
        }

        return response()->json([
            'user' => $user,
            'message' => "Le mail a été envoyé"
        ]);
    }

    public function update(Request $request, $id){
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
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

    public function password() {
        do {
            $pass = $this->ramdonString();
            $user = User::wherePassword(bcrypt($pass))->first();
        } while($user != null);
        return $pass;
    }

    public function ramdonString() {
        $area = 'abcdef01234567';
        $pass = array();
        for($i=0; $i < 5; $i++){
            $n = rand(0, strlen($area)-1);
            $pass[] = $area[$n];
        }
        return implode($pass);
    }
}
