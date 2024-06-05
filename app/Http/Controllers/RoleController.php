<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        return view('register', [
        'role' => Role::all()
        ]);
    }

    public function getRole($id_role){
        $user = User::where('id_role', $id_role)->get();
        return response()->json($user);
    }
}
