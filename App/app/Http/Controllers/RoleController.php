<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
{
    //
    public function add(Request $request){
        $request->validate([
            'name' => 'required|unique:role'
        ]);
        $data = $request->all();
        $role = Role::create($data);
        return response()->json($role);
    }
}
